<?php 

define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_NAME", 'db_sibandid');
define("DB_HOST", 'localhost');
define("BACKUP_DIR", '../../backup/db'); // Comment this line to use same script's directory ('.')
define("BACKUP_FILE", 'db_sibandid.sql.gz'); // Script will autodetect if backup file is gzipped based on .gz extension
define("CHARSET", 'utf8');
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails

class Restore_Database {
    var $host;
    var $username;
    var $passwd;
    var $dbName;
    var $charset;
    var $conn;
    var $disableForeignKeyChecks;

    function __construct($host, $username, $passwd, $dbName, $charset = 'utf8') {
        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = defined('BACKUP_DIR') ? BACKUP_DIR : '.';
        $this->backupFile              = defined('BACKUP_FILE') ? BACKUP_FILE : null;
    }

    function __destructor() {

        if ($this->disableForeignKeyChecks === true) {
            mysqli_query($this->conn, 'SET foreign_key_checks = 1');
        }
    }
    protected function initializeDatabase() {
        try {
            $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
            if (mysqli_connect_errno()) {
                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                die();
            }
            if (!mysqli_set_charset($conn, $this->charset)) {
                mysqli_query($conn, 'SET NAMES '.$this->charset);
            }

            if ($this->disableForeignKeyChecks === true) {
                mysqli_query($conn, 'SET foreign_key_checks = 0');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $conn;
    }

    public function restoreDb() {
        try {
            $sql = '';
            $multiLineComment = false;
            $backupDir = $this->backupDir;
            $backupFile = $this->backupFile;
            /**
             * Gunzip file if gzipped
             */
            $backupFileIsGzipped = substr($backupFile, -3, 3) == '.gz' ? true : false;
            if ($backupFileIsGzipped) {
                if (!$backupFile = $this->gunzipBackupFile()) {
                    throw new Exception("ERROR: couldn't gunzip backup file " . $backupDir . '/' . $backupFile);
                }
            }

            $handle = fopen($backupDir . '/' . $backupFile, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $line = ltrim(rtrim($line));
                    if (strlen($line) > 1) { // avoid blank lines
                        $lineIsComment = false;
                        if (preg_match('/^\/\*/', $line)) {
                            $multiLineComment = true;
                            $lineIsComment = true;
                        }
                        if ($multiLineComment or preg_match('/^\/\//', $line)) {
                            $lineIsComment = true;
                        }
                        if (!$lineIsComment) {
                            $sql .= $line;
                            if (preg_match('/;$/', $line)) {
                                // execute query
                                if(mysqli_query($this->conn, $sql)) {
                                    if (preg_match('/^CREATE TABLE `([^`]+)`/i', $sql, $tableName)) {
                                        $this->obfPrint("Table succesfully created: `" . $tableName[1] . "`");
                                    }
                                    $sql = '';
                                } else {
                                    throw new Exception("ERROR: SQL execution error: " . mysqli_error($this->conn));
                                }
                            }
                        } else if (preg_match('/\*\/$/', $line)) {
                            $multiLineComment = false;
                        }
                    }
                }
                fclose($handle);
            } else {
                throw new Exception("ERROR: couldn't open backup file " . $backupDir . '/' . $backupFile);
            } 
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        if ($backupFileIsGzipped) {
            unlink($backupDir . '/' . $backupFile);
        }
        return true;
    }

    protected function gunzipBackupFile() {
        // Raising this value may increase performance
        $bufferSize = 4096; // read 4kb at a time
        $error = false;
        $source = $this->backupDir . '/' . $this->backupFile;
        $dest = $this->backupDir . '/' . date("Ymd_His", time()) . '_' . substr($this->backupFile, 0, -3);
        $this->obfPrint('Gunzipping backup file ' . $source . '... ', 1, 1);
        // Remove $dest file if exists
        if (file_exists($dest)) {
            if (!unlink($dest)) {
                return false;
            }
        }
 
        // Open gzipped and destination files in binary mode
        if (!$srcFile = gzopen($this->backupDir . '/' . $this->backupFile, 'rb')) {
            return false;
        }
        if (!$dstFile = fopen($dest, 'wb')) {
            return false;
        }
        while (!gzeof($srcFile)) {
            // Read buffer-size bytes
            // Both fwrite and gzread are binary-safe
            if(!fwrite($dstFile, gzread($srcFile, $bufferSize))) {
                return false;
            }
        }
        fclose($dstFile);
        gzclose($srcFile);
        // Return backup filename excluding backup directory
        return str_replace($this->backupDir . '/', '', $dest);
    }

    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }
        $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        $output = '';
        if (php_sapi_name() != "cli") {
            $lineBreak = "<br />";
        } else {
            $lineBreak = "\n";
        }
        if ($lineBreaksBefore > 0) {
            for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                $output .= $lineBreak;
            }                
        }
        $output .= $msg;
        if ($lineBreaksAfter > 0) {
            for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                $output .= $lineBreak;
            }                
        }
        if (php_sapi_name() == "cli") {
            $output .= "\n";
        }
        echo $output;
        if (php_sapi_name() != "cli") {
            ob_flush();
        }
        flush();
    }
}

// Report all errors
error_reporting(E_ALL);
// Set script max execution time
set_time_limit(900); // 15 minutes
if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}
$restoreDatabase = new Restore_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$result = $restoreDatabase->restoreDb(BACKUP_DIR, BACKUP_FILE) ? 'OK' : 'KO';
$restoreDatabase->obfPrint("Restoration result: ".$result, 1);
if (php_sapi_name() != "cli") {
    echo '</div>';
}
?>

<?php 

if (isset($_POST['restore'])) {
    // -------------------perencanaan----------------
    // RPJMDES
    $files =glob('../perencanaan/rpjmdes/file/rpjmdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/rpjmdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    //RKPDES
    $files =glob('../perencanaan/rkpdes/file/rkpdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/rkpdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // APBDES
    $files =glob('../perencanaan/apbdes/file/apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/apbdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/apbdes/file/perkades/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // APBDES_PERUB
    $files =glob('../perencanaan/apbdes_perub/file/apbdes_perub/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/apbdes_perub/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../perencanaan/apbdes_perub/file/perkades/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // -------------------pelaksanaan----------------
    // RPD
    $files =glob('../pelaksanaan/rpd/file/rpd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI DD
    $files =glob('../pelaksanaan/dd/file/p_dd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/dd/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/dd/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/dd/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/dd/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI ADD
    $files =glob('../pelaksanaan/add/file/add/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/add/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/add/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/add/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/add/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI PAD
    $files =glob('../pelaksanaan/pad/file/pad/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/pad/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/pad/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/pad/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/pad/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI APBDES
    $files =glob('../pelaksanaan/apbdes/file/apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/apbdes/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/apbdes/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/apbdes/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/apbdes/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // RETRIBUSI
    $files =glob('../pelaksanaan/retribusi/file/retribusi/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/retribusi/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/retribusi/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/retribusi/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaksanaan/retribusi/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SK
    $files =glob('../pelaksanaan/sk/file/sk/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // -------------------pelaporan----------------
    // BULANAN
    $files =glob('../pelaporan/bulanan/file/bulanan/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SEMESTER 1
    $files =glob('../pelaporan/semester_1/file/smt_1/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SEMESTER 2
    $files =glob('../pelaporan/semester_2/file/smt_2/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LPPD
    $files =glob('../pelaporan/lppd/file/lppd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // IPPD
    $files =glob('../pelaporan/ippd/file/ippd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LKPJ
    $files =glob('../pelaporan/lkpj/file/lkpj/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // OMSPAN
    $files =glob('../pelaporan/omspan/file/omspan/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // PERTANGGUNGJAWABAN
    $files =glob('../pelaporan/tanggungjawab/file/tanggungjawab/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../pelaporan/tanggungjawab/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // BA_KAS
    $files =glob('../pelaporan/ba_kas/file/ba_kas/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // HABIS PAKAI
    $files =glob('../pelaporan/habis_pakai/file/habis_pakai/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REKAP APBDES
    $files =glob('../pelaporan/rekap_apbdes/file/rekap_apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REKAP SUMBER DANA
    $files =glob('../pelaporan/rekap_sumberdana/file/rekap_sumberdana/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REGISTER KAS
    $files =glob('../pelaporan/register_kas/file/register_kas/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LAIN-LAIN
    $files =glob('../pelaporan/lain_lain/file/lain_lain/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }


    // .....................................PERENCANAAN...........................
include_once("../../asset/inc/config.php");
// --------RPJMDes----------
$query= "SELECT * FROM tb_rpjmdes ORDER BY id_rpjmdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/perencanaan/rpjmdes/file/rpjmdes/'.$data['rpjmdes'],'../perencanaan/rpjmdes/file/rpjmdes/'.$data['rpjmdes']);
        copy('../../backup/file/perencanaan/rpjmdes/file/perdes/'.$data['perdes'],'../perencanaan/rpjmdes/file/perdes/'.$data['perdes']);
    }

// --------RKPDes----------
$query= "SELECT * FROM tb_rkpdes ORDER BY id_rkpdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/perencanaan/rkpdes/file/rkpdes/'.$data['rkpdes'],'../perencanaan/rkpdes/file/rkpdes/'.$data['rkpdes']);
        copy('../../backup/file/perencanaan/rkpdes/file/perdes/'.$data['perdes'],'../perencanaan/rkpdes/file/perdes/'.$data['perdes']);
    }

// --------APBDes----------
$query= "SELECT * FROM tb_apbdes ORDER BY id_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/perencanaan/apbdes/file/apbdes/'.$data['apbdes'],'../perencanaan/apbdes/file/apbdes/'.$data['apbdes']);
        copy('../../backup/file/perencanaan/apbdes/file/perdes/'.$data['perdes'],'../perencanaan/apbdes/file/perdes/'.$data['perdes']);
        copy('../../backup/file/perencanaan/apbdes/file/perkades/'.$data['perkades'],'../perencanaan/apbdes/file/perkades/'.$data['perkades']);
    }

// --------APBDes_Perubahan----------
$query= "SELECT * FROM tb_apbdes_perub ORDER BY id_apbdes_perub DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/perencanaan/apbdes_perub/file/apbdes_perub/'.$data['apbdes_perub'],'../perencanaan/apbdes_perub/file/apbdes_perub/'.$data['apbdes_perub']);
        copy('../../backup/file/perencanaan/apbdes_perub/file/perdes/'.$data['perdes'],'../perencanaan/apbdes_perub/file/perdes/'.$data['perdes']);
        copy('../../backup/file/perencanaan/apbdes_perub/file/perkades/'.$data['perkades'],'../perencanaan/apbdes_perub/file/perkades/'.$data['perkades']);
    }

// .....................................PELAKSANAAN...........................

// --------RPD----------
$query= "SELECT * FROM tb_rpd ORDER BY id_rpd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/rpd/file/rpd/'.$data['rpd'],'../pelaksanaan/rpd/file/rpd/'.$data['rpd']);
    }

// --------REALISASI DD----------
$query= "SELECT * FROM tb_realisasi_dd ORDER BY id_realisasi_dd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/dd/file/p_dd/'.$data['realisasi_dd'],'../pelaksanaan/dd/file/p_dd/'.$data['realisasi_dd']);
        copy('../../backup/file/pelaksanaan/dd/file/foto/foto1/'.$data['foto_dd_1'],'../pelaksanaan/dd/file/foto/foto1/'.$data['foto_dd_1']);
        copy('../../backup/file/pelaksanaan/dd/file/foto/foto2/'.$data['foto_dd_2'],'../pelaksanaan/dd/file/foto/foto2/'.$data['foto_dd_2']);
        copy('../../backup/file/pelaksanaan/dd/file/foto/foto3/'.$data['foto_dd_3'],'../pelaksanaan/dd/file/foto/foto3/'.$data['foto_dd_3']);
        copy('../../backup/file/pelaksanaan/dd/file/foto/foto4/'.$data['foto_dd_4'],'../pelaksanaan/dd/file/foto/foto4/'.$data['foto_dd_4']);
    }

// --------REALISASI ADD----------
$query= "SELECT * FROM tb_realisasi_add ORDER BY id_realisasi_add DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/add/file/add/'.$data['realisasi_add'],'../pelaksanaan/add/file/add/'.$data['realisasi_add']);
        copy('../../backup/file/pelaksanaan/add/file/foto/foto1/'.$data['foto_add_1'],'../pelaksanaan/add/file/foto/foto1/'.$data['foto_add_1']);
        copy('../../backup/file/pelaksanaan/add/file/foto/foto2/'.$data['foto_add_2'],'../pelaksanaan/add/file/foto/foto2/'.$data['foto_add_2']);
        copy('../../backup/file/pelaksanaan/add/file/foto/foto3/'.$data['foto_add_3'],'../pelaksanaan/add/file/foto/foto3/'.$data['foto_add_3']);
        copy('../../backup/file/pelaksanaan/add/file/foto/foto4/'.$data['foto_add_4'],'../pelaksanaan/add/file/foto/foto4/'.$data['foto_add_4']);
    }

// --------REALISASI PAD----------
$query= "SELECT * FROM tb_realisasi_pad ORDER BY id_realisasi_pad DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/pad/file/pad/'.$data['realisasi_pad'],'../pelaksanaan/pad/file/pad/'.$data['realisasi_pad']);
        copy('../../backup/file/pelaksanaan/pad/file/foto/foto1/'.$data['foto_pad_1'],'../pelaksanaan/pad/file/foto/foto1/'.$data['foto_pad_1']);
        copy('../../backup/file/pelaksanaan/pad/file/foto/foto2/'.$data['foto_pad_2'],'../pelaksanaan/pad/file/foto/foto2/'.$data['foto_pad_2']);
        copy('../../backup/file/pelaksanaan/pad/file/foto/foto3/'.$data['foto_pad_3'],'../pelaksanaan/pad/file/foto/foto3/'.$data['foto_pad_3']);
        copy('../../backup/file/pelaksanaan/pad/file/foto/foto4/'.$data['foto_pad_4'],'../pelaksanaan/pad/file/foto/foto4/'.$data['foto_pad_4']);
    }

// --------REALISASI APBDes----------
$query= "SELECT * FROM tb_realisasi_apbdes ORDER BY id_realisasi_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/apbdes/file/apbdes/'.$data['realisasi_apbdes'],'../pelaksanaan/apbdes/file/apbdes/'.$data['realisasi_apbdes']);
        copy('../../backup/file/pelaksanaan/apbdes/file/foto/foto1/'.$data['foto_apbdes_1'],'../pelaksanaan/apbdes/file/foto/foto1/'.$data['foto_apbdes_1']);
        copy('../../backup/file/pelaksanaan/apbdes/file/foto/foto2/'.$data['foto_apbdes_2'],'../pelaksanaan/apbdes/file/foto/foto2/'.$data['foto_apbdes_2']);
        copy('../../backup/file/pelaksanaan/apbdes/file/foto/foto3/'.$data['foto_apbdes_3'],'../pelaksanaan/apbdes/file/foto/foto3/'.$data['foto_apbdes_3']);
        copy('../../backup/file/pelaksanaan/apbdes/file/foto/foto4/'.$data['foto_apbdes_4'],'../pelaksanaan/apbdes/file/foto/foto4/'.$data['foto_apbdes_4']);
    }

// --------RETRIBUSI----------
$query= "SELECT * FROM tb_retribusi ORDER BY id_retribusi DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/retribusi/file/retribusi/'.$data['retribusi'],'../pelaksanaan/retribusi/file/retribusi/'.$data['retribusi']);
        copy('../../backup/file/pelaksanaan/retribusi/file/foto/foto1/'.$data['foto1'],'../pelaksanaan/retribusi/file/foto/foto1/'.$data['foto1']);
        copy('../../backup/file/pelaksanaan/retribusi/file/foto/foto2/'.$data['foto2'],'../pelaksanaan/retribusi/file/foto/foto2/'.$data['foto2']);
        copy('../../backup/file/pelaksanaan/retribusi/file/foto/foto3/'.$data['foto3'],'../pelaksanaan/retribusi/file/foto/foto3/'.$data['foto3']);
        copy('../../backup/file/pelaksanaan/retribusi/file/foto/foto4/'.$data['foto4'],'../pelaksanaan/retribusi/file/foto/foto4/'.$data['foto4']);
    }

// --------SK----------
$query= "SELECT * FROM tb_sk ORDER BY id_sk DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaksanaan/sk/file/sk/'.$data['sk'],'../pelaksanaan/sk/file/sk/'.$data['sk']);
    }

// .....................................PELAPORAN...........................

// --------BULANAN----------
$query= "SELECT * FROM tb_bulanan ORDER BY id_bulanan DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/bulanan/file/bulanan/'.$data['bulanan'],'../pelaporan/bulanan/file/bulanan/'.$data['bulanan']);
    }

// --------SEMESTER 1----------
$query= "SELECT * FROM tb_smt_1 ORDER BY id_smt_1 DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/semester_1/file/smt_1/'.$data['smt_1'],'../pelaporan/semester_1/file/smt_1/'.$data['smt_1']);
    }

// --------SEMESTER 2----------
$query= "SELECT * FROM tb_smt_2 ORDER BY id_smt_2 DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/semester_2/file/smt_2/'.$data['smt_2'],'../pelaporan/semester_2/file/smt_2/'.$data['smt_2']);
    }

// --------LPPD----------
$query= "SELECT * FROM tb_lppd ORDER BY id_lppd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/lppd/file/lppd/'.$data['lppd'],'../pelaporan/lppd/file/lppd/'.$data['lppd']);
    }

// --------IPPD----------
$query= "SELECT * FROM tb_ippd ORDER BY id_ippd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/ippd/file/ippd/'.$data['ippd'],'../pelaporan/ippd/file/ippd/'.$data['ippd']);
    }

// --------lkpj----------
$query= "SELECT * FROM tb_lkpj ORDER BY id_lkpj DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/lkpj/file/lkpj/'.$data['lkpj'],'../pelaporan/lkpj/file/lkpj/'.$data['lkpj']);
    }

// --------OMSPAN----------
$query= "SELECT * FROM tb_omspan ORDER BY id_omspan DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/omspan/file/omspan/'.$data['omspan'],'../pelaporan/omspan/file/omspan/'.$data['omspan']);
    }

// --------PERTANGGUNGJAWABAN----------
$query= "SELECT * FROM tb_tanggung_jawab ORDER BY id_tanggung_jawab DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/tanggungjawab/file/tanggungjawab/'.$data['tanggung_jawab'],'../pelaporan/tanggungjawab/file/tanggungjawab/'.$data['tanggung_jawab']);
        copy('../../backup/file/pelaporan/tanggungjawab/file/perdes/'.$data['perdes'],'../pelaporan/tanggungjawab/file/perdes/'.$data['perdes']);
    }

// --------BA_KAS----------
$query= "SELECT * FROM tb_ba_kas ORDER BY id_ba_kas DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/ba_kas/file/ba_kas/'.$data['ba_kas'],'../pelaporan/ba_kas/file/ba_kas/'.$data['ba_kas']);
    }

// --------HABIS PAKAI----------
$query= "SELECT * FROM tb_habis_pakai ORDER BY id_habis_pakai DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/habis_pakai/file/habis_pakai/'.$data['habis_pakai'],'../pelaporan/habis_pakai/file/habis_pakai/'.$data['habis_pakai']);
    }

// --------REKAP APBDES----------
$query= "SELECT * FROM tb_rekap_realisasi_apbdes ORDER BY id_rekap_realisasi_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/rekap_apbdes/file/rekap_apbdes/'.$data['rekap_realisasi_apbdes'],'../pelaporan/rekap_apbdes/file/rekap_apbdes/'.$data['rekap_realisasi_apbdes']);
    }

// --------REKAP SUMBER DANA----------
$query= "SELECT * FROM tb_realisasi_apbdes_dana ORDER BY id_realisasi_apbdes_dana DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/rekap_sumberdana/file/rekap_sumberdana/'.$data['realisasi_apbdes_dana'],'../pelaporan/rekap_sumberdana/file/rekap_sumberdana/'.$data['realisasi_apbdes_dana']);
    }

// --------TUTUP KAS----------
$query= "SELECT * FROM tb_tutup_kas ORDER BY id_tutup_kas DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/register_kas/file/register_kas/'.$data['tutup_kas'],'../pelaporan/register_kas/file/register_kas/'.$data['tutup_kas']);
    }

// --------LAIN-LAIN----------
$query= "SELECT * FROM tb_lain ORDER BY id_lain_lain DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../../backup/file/pelaporan/lain_lain/file/lain_lain/'.$data['lain_lain'],'../pelaporan/lain_lain/file/lain_lain/'.$data['lain_lain']);
    }
} 
?>
<script type="text/javascript">
  alert("Data berhasil direstore!");
  window.location = "../../index.php?page=backup";
</script>