<?php 

define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_NAME", 'db_sibandid');
define("DB_HOST", 'localhost');
define("BACKUP_DIR", '../../backup/db'); // Comment this line to use same script's directory ('.')
define("TABLES", '*'); // Full backup
//define("TABLES", 'table1, table2, table3'); // Partial backup
define("CHARSET", 'utf8');
define("GZIP_BACKUP_FILE", true); // Set to false if you want plain SQL backup files (not gzipped)
define("DISABLE_FOREIGN_KEY_CHECKS", true); // Set to true if you are having foreign key constraint fails
define("BATCH_SIZE", 1000); // Batch size when selecting rows from database in order to not exhaust system memory
                            // Also number of rows per INSERT statement in backup file

class Backup_Database {

    var $host;
    var $username;
    var $passwd;
    var $dbName;
    var $charset;
    var $conn;
    var $backupDir;
    var $backupFile;
    var $gzipBackupFile;
    var $output;
    var $disableForeignKeyChecks;
    var $batchSize;

    public function __construct($host, $username, $passwd, $dbName, $charset = 'utf8') {
        $this->host                    = $host;
        $this->username                = $username;
        $this->passwd                  = $passwd;
        $this->dbName                  = $dbName;
        $this->charset                 = $charset;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = BACKUP_DIR ? BACKUP_DIR : '.';
        $this->backupFile              = $this->dbName.'.sql';
        $this->gzipBackupFile          = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
        $this->disableForeignKeyChecks = defined('DISABLE_FOREIGN_KEY_CHECKS') ? DISABLE_FOREIGN_KEY_CHECKS : true;
        $this->batchSize               = defined('BATCH_SIZE') ? BATCH_SIZE : 1000; // default 1000 rows
        $this->output                  = '';
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
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }
        return $conn;
    }

    public function backupTables($tables = '*') {
        try {
            /**
             * Tables to export
             */
            if($tables == '*') {
                $tables = array();
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
            }
            $sql = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbName."`;\n\n";
            $sql .= 'USE `'.$this->dbName."`;\n\n";
            /**
             * Disable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 0;\n\n";
            }
            /**
             * Iterate tables
             */
            foreach($tables as $table) {
                $this->obfPrint("Backing up `".$table."` table...".str_repeat('.', 50-strlen($table)), 0, 0);
                /**
                 * CREATE TABLE
                 */
                $sql .= 'DROP TABLE IF EXISTS `'.$table.'`;';
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `'.$table.'`'));
                $sql .= "\n\n".$row[1].";\n\n";
                /**
                 * INSERT INTO
                 */
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `'.$table.'`'));
                $numRows = $row[0];
                // Split table in batches in order to not exhaust system memory 
                $numBatches = intval($numRows / $this->batchSize) + 1; // Number of while-loop calls to perform
                for ($b = 1; $b <= $numBatches; $b++) {
 
                    $query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($b * $this->batchSize - $this->batchSize) . ',' . $this->batchSize;
                    $result = mysqli_query($this->conn, $query);
                    $realBatchSize = mysqli_num_rows ($result); // Last batch size can be different from $this->batchSize
                    $numFields = mysqli_num_fields($result);
                    if ($realBatchSize !== 0) {
                        $sql .= 'INSERT INTO `'.$table.'` VALUES ';
                        for ($i = 0; $i < $numFields; $i++) {
                            $rowCount = 1;
                            while($row = mysqli_fetch_row($result)) {
                                $sql.='(';
                                for($j=0; $j<$numFields; $j++) {
                                    if (isset($row[$j])) {
                                        $row[$j] = addslashes($row[$j]);
                                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                                        $row[$j] = str_replace("\r","\\r",$row[$j]);
                                        $row[$j] = str_replace("\f","\\f",$row[$j]);
                                        $row[$j] = str_replace("\t","\\t",$row[$j]);
                                        $row[$j] = str_replace("\v","\\v",$row[$j]);
                                        $row[$j] = str_replace("\a","\\a",$row[$j]);
                                        $row[$j] = str_replace("\b","\\b",$row[$j]);
                                        if ($row[$j] == 'true' or $row[$j] == 'false' or preg_match('/^-?[0-9]+$/', $row[$j]) or $row[$j] == 'NULL' or $row[$j] == 'null') {
                                            $sql .= $row[$j];
                                        } else {
                                            $sql .= '"'.$row[$j].'"' ;
                                        }
                                    } else {
                                        $sql.= 'NULL';
                                    }
 
                                    if ($j < ($numFields-1)) {
                                        $sql .= ',';
                                    }
                                }
 
                                if ($rowCount == $realBatchSize) {
                                    $rowCount = 0;
                                    $sql.= ");\n"; //close the insert statement
                                } else {
                                    $sql.= "),\n"; //close the row
                                }
 
                                $rowCount++;
                            }
                        }
 
                        $this->saveFile($sql);
                        $sql = '';
                    }
                }

                $sql.="\n\n";
                $this->obfPrint('OK');
            }
            /**
             * Re-enable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 1;\n";
            }
            $this->saveFile($sql);
            if ($this->gzipBackupFile) {
                $this->gzipBackupFile();
            } else {
                $this->obfPrint('Backup file succesfully saved to ' . $this->backupDir.'/'.$this->backupFile, 1, 1);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        return true;
    }
    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql) {
        if (!$sql) return false;
        try {
            if (!file_exists($this->backupDir)) {
                mkdir($this->backupDir, 0777, true);
            }
            file_put_contents($this->backupDir.'/'.$this->backupFile, $sql, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }
        return true;
    }

    protected function gzipBackupFile($level = 9) {
        if (!$this->gzipBackupFile) {
            return true;
        }
        $source = $this->backupDir . '/' . $this->backupFile;
        $dest =  $source . '.gz';
        $this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);
        $mode = 'wb' . $level;
        if ($fpOut = gzopen($dest, $mode)) {
            if ($fpIn = fopen($source,'rb')) {
                while (!feof($fpIn)) {
                    gzwrite($fpOut, fread($fpIn, 1024 * 256));
                }
                fclose($fpIn);
            } else {
                return false;
            }
            gzclose($fpOut);
            if(!unlink($source)) {
                return false;
            }
        } else {
            return false;
        }
 
        $this->obfPrint('OK');
        return $dest;
    }
    /**
     * Prints message forcing output buffer flush
     *
     */
    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }
        if ($msg != 'OK' and $msg != 'KO') {
            $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        }
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
        // Save output for later use
        $this->output .= str_replace('<br />', '\n', $output);
        echo $output;
        if (php_sapi_name() != "cli") {
            if( ob_get_level() > 0 ) {
                ob_flush();
            }
        }
        $this->output .= " ";
        flush();
    }
    /**
     * Returns full execution output
     *
     */
    public function getOutput() {
        return $this->output;
    }
}
/**
 * Instantiate Backup_Database and perform backup
 */
// Report all errors
error_reporting(E_ALL);
// Set script max execution time
set_time_limit(900); // 15 minutes
if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}
$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, CHARSET);
$result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
$backupDatabase->obfPrint('Backup result: ' . $result, 1);
// Use $output variable for further processing, for example to send it by email
$output = $backupDatabase->getOutput();
if (php_sapi_name() != "cli") {
    echo '</div>';
}
?>


<?php 

if (isset($_POST['backup'])) {
    // -------------------perencanaan----------------
    // RPJMDES
    $files =glob('../../backup/file/perencanaan/rpjmdes/file/rpjmdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/rpjmdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    //RKPDES
    $files =glob('../../backup/file/perencanaan/rkpdes/file/rkpdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/rkpdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // APBDES
    $files =glob('../../backup/file/perencanaan/apbdes/file/apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/apbdes/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/apbdes/file/perkades/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // APBDES_PERUB
    $files =glob('../../backup/file/perencanaan/apbdes_perub/file/apbdes_perub/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/apbdes_perub/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/perencanaan/apbdes_perub/file/perkades/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // -------------------pelaksanaan----------------
    // RPD
    $files =glob('../../backup/file/pelaksanaan/rpd/file/rpd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI DD
    $files =glob('../../backup/file/pelaksanaan/dd/file/p_dd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/dd/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/dd/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/dd/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/dd/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI ADD
    $files =glob('../../backup/file/pelaksanaan/add/file/add/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/add/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/add/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/add/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/add/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI PAD
    $files =glob('../../backup/file/pelaksanaan/pad/file/pad/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/pad/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/pad/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/pad/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/pad/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REALISASI APBDES
    $files =glob('../../backup/file/pelaksanaan/apbdes/file/apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/apbdes/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/apbdes/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/apbdes/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/apbdes/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // RETRIBUSI
    $files =glob('../../backup/file/pelaksanaan/retribusi/file/retribusi/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/retribusi/file/foto/foto1*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/retribusi/file/foto/foto2*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/retribusi/file/foto/foto3*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaksanaan/retribusi/file/foto/foto4*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SK
    $files =glob('../../backup/file/pelaksanaan/sk/file/sk/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // -------------------pelaporan----------------
    // BULANAN
    $files =glob('../../backup/file/pelaporan/bulanan/file/bulanan/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SEMESTER 1
    $files =glob('../../backup/file/pelaporan/semester_1/file/smt_1/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // SEMESTER 2
    $files =glob('../../backup/file/pelaporan/semester_2/file/smt_2/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LPPD
    $files =glob('../../backup/file/pelaporan/lppd/file/lppd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // IPPD
    $files =glob('../../backup/file/pelaporan/ippd/file/ippd/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LKPJ
    $files =glob('../../backup/file/pelaporan/lkpj/file/lkpj/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // OMSPAN
    $files =glob('../../backup/file/pelaporan/omspan/file/omspan/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // PERTANGGUNGJAWABAN
    $files =glob('../../backup/file/pelaporan/tanggungjawab/file/tanggungjawab/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    $files =glob('../../backup/file/pelaporan/tanggungjawab/file/perdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // BA_KAS
    $files =glob('../../backup/file/pelaporan/ba_kas/file/ba_kas/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // HABIS PAKAI
    $files =glob('../../backup/file/pelaporan/habis_pakai/file/habis_pakai/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REKAP APBDES
    $files =glob('../../backup/file/pelaporan/rekap_apbdes/file/rekap_apbdes/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REKAP SUMBER DANA
    $files =glob('../../backup/file/pelaporan/rekap_sumberdana/file/rekap_sumberdana/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // REGISTER KAS
    $files =glob('../../backup/file/pelaporan/register_kas/file/register_kas/*');
    foreach ($files as $file) {
        if (is_file($file))
        unlink($file);
    }
    // LAIN-LAIN
    $files =glob('../../backup/file/pelaporan/lain_lain/file/lain_lain/*');
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
        copy('../perencanaan/rpjmdes/file/rpjmdes/'.$data['rpjmdes'], '../../backup/file/perencanaan/rpjmdes/file/rpjmdes/'.$data['rpjmdes']);
        copy('../perencanaan/rpjmdes/file/perdes/'.$data['perdes'], '../../backup/file/perencanaan/rpjmdes/file/perdes/'.$data['perdes']);
    }

// --------RKPDes----------
$query= "SELECT * FROM tb_rkpdes ORDER BY id_rkpdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../perencanaan/rkpdes/file/rkpdes/'.$data['rkpdes'], '../../backup/file/perencanaan/rkpdes/file/rkpdes/'.$data['rkpdes']);
        copy('../perencanaan/rkpdes/file/perdes/'.$data['perdes'], '../../backup/file/perencanaan/rkpdes/file/perdes/'.$data['perdes']);
    }

// --------APBDes----------
$query= "SELECT * FROM tb_apbdes ORDER BY id_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../perencanaan/apbdes/file/apbdes/'.$data['apbdes'], '../../backup/file/perencanaan/apbdes/file/apbdes/'.$data['apbdes']);
        copy('../perencanaan/apbdes/file/perdes/'.$data['perdes'], '../../backup/file/perencanaan/apbdes/file/perdes/'.$data['perdes']);
        copy('../perencanaan/apbdes/file/perkades/'.$data['perkades'], '../../backup/file/perencanaan/apbdes/file/perkades/'.$data['perkades']);
    }

// --------APBDes_Perubahan----------
$query= "SELECT * FROM tb_apbdes_perub ORDER BY id_apbdes_perub DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../perencanaan/apbdes_perub/file/apbdes_perub/'.$data['apbdes_perub'], '../../backup/file/perencanaan/apbdes_perub/file/apbdes_perub/'.$data['apbdes_perub']);
        copy('../perencanaan/apbdes_perub/file/perdes/'.$data['perdes'], '../../backup/file/perencanaan/apbdes_perub/file/perdes/'.$data['perdes']);
        copy('../perencanaan/apbdes_perub/file/perkades/'.$data['perkades'], '../../backup/file/perencanaan/apbdes_perub/file/perkades/'.$data['perkades']);
    }

// .....................................PELAKSANAAN...........................

// --------RPD----------
$query= "SELECT * FROM tb_rpd ORDER BY id_rpd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/rpd/file/rpd/'.$data['rpd'], '../../backup/file/pelaksanaan/rpd/file/rpd/'.$data['rpd']);
    }

// --------REALISASI DD----------
$query= "SELECT * FROM tb_realisasi_dd ORDER BY id_realisasi_dd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/dd/file/p_dd/'.$data['realisasi_dd'], '../../backup/file/pelaksanaan/dd/file/p_dd/'.$data['realisasi_dd']);
        copy('../pelaksanaan/dd/file/foto/foto1/'.$data['foto_dd_1'], '../../backup/file/pelaksanaan/dd/file/foto/foto1/'.$data['foto_dd_1']);
        copy('../pelaksanaan/dd/file/foto/foto2/'.$data['foto_dd_2'], '../../backup/file/pelaksanaan/dd/file/foto/foto2/'.$data['foto_dd_2']);
        copy('../pelaksanaan/dd/file/foto/foto3/'.$data['foto_dd_3'], '../../backup/file/pelaksanaan/dd/file/foto/foto3/'.$data['foto_dd_3']);
        copy('../pelaksanaan/dd/file/foto/foto4/'.$data['foto_dd_4'], '../../backup/file/pelaksanaan/dd/file/foto/foto4/'.$data['foto_dd_4']);
    }

// --------REALISASI ADD----------
$query= "SELECT * FROM tb_realisasi_add ORDER BY id_realisasi_add DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/add/file/add/'.$data['realisasi_add'], '../../backup/file/pelaksanaan/add/file/add/'.$data['realisasi_add']);
        copy('../pelaksanaan/add/file/foto/foto1/'.$data['foto_add_1'], '../../backup/file/pelaksanaan/add/file/foto/foto1/'.$data['foto_add_1']);
        copy('../pelaksanaan/add/file/foto/foto2/'.$data['foto_add_2'], '../../backup/file/pelaksanaan/add/file/foto/foto2/'.$data['foto_add_2']);
        copy('../pelaksanaan/add/file/foto/foto3/'.$data['foto_add_3'], '../../backup/file/pelaksanaan/add/file/foto/foto3/'.$data['foto_add_3']);
        copy('../pelaksanaan/add/file/foto/foto4/'.$data['foto_add_4'], '../../backup/file/pelaksanaan/add/file/foto/foto4/'.$data['foto_add_4']);
    }

// --------REALISASI PAD----------
$query= "SELECT * FROM tb_realisasi_pad ORDER BY id_realisasi_pad DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/pad/file/pad/'.$data['realisasi_pad'], '../../backup/file/pelaksanaan/pad/file/pad/'.$data['realisasi_pad']);
        copy('../pelaksanaan/pad/file/foto/foto1/'.$data['foto_pad_1'], '../../backup/file/pelaksanaan/pad/file/foto/foto1/'.$data['foto_pad_1']);
        copy('../pelaksanaan/pad/file/foto/foto2/'.$data['foto_pad_2'], '../../backup/file/pelaksanaan/pad/file/foto/foto2/'.$data['foto_pad_2']);
        copy('../pelaksanaan/pad/file/foto/foto3/'.$data['foto_pad_3'], '../../backup/file/pelaksanaan/pad/file/foto/foto3/'.$data['foto_pad_3']);
        copy('../pelaksanaan/pad/file/foto/foto4/'.$data['foto_pad_4'], '../../backup/file/pelaksanaan/pad/file/foto/foto4/'.$data['foto_pad_4']);
    }

// --------REALISASI APBDes----------
$query= "SELECT * FROM tb_realisasi_apbdes ORDER BY id_realisasi_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/apbdes/file/apbdes/'.$data['realisasi_apbdes'], '../../backup/file/pelaksanaan/apbdes/file/apbdes/'.$data['realisasi_apbdes']);
        copy('../pelaksanaan/apbdes/file/foto/foto1/'.$data['foto_apbdes_1'], '../../backup/file/pelaksanaan/apbdes/file/foto/foto1/'.$data['foto_apbdes_1']);
        copy('../pelaksanaan/apbdes/file/foto/foto2/'.$data['foto_apbdes_2'], '../../backup/file/pelaksanaan/apbdes/file/foto/foto2/'.$data['foto_apbdes_2']);
        copy('../pelaksanaan/apbdes/file/foto/foto3/'.$data['foto_apbdes_3'], '../../backup/file/pelaksanaan/apbdes/file/foto/foto3/'.$data['foto_apbdes_3']);
        copy('../pelaksanaan/apbdes/file/foto/foto4/'.$data['foto_apbdes_4'], '../../backup/file/pelaksanaan/apbdes/file/foto/foto4/'.$data['foto_apbdes_4']);
    }

// --------RETRIBUSI----------
$query= "SELECT * FROM tb_retribusi ORDER BY id_retribusi DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/retribusi/file/retribusi/'.$data['retribusi'], '../../backup/file/pelaksanaan/retribusi/file/retribusi/'.$data['retribusi']);
        copy('../pelaksanaan/retribusi/file/foto/foto1/'.$data['foto1'], '../../backup/file/pelaksanaan/retribusi/file/foto/foto1/'.$data['foto1']);
        copy('../pelaksanaan/retribusi/file/foto/foto2/'.$data['foto2'], '../../backup/file/pelaksanaan/retribusi/file/foto/foto2/'.$data['foto2']);
        copy('../pelaksanaan/retribusi/file/foto/foto3/'.$data['foto3'], '../../backup/file/pelaksanaan/retribusi/file/foto/foto3/'.$data['foto3']);
        copy('../pelaksanaan/retribusi/file/foto/foto4/'.$data['foto4'], '../../backup/file/pelaksanaan/retribusi/file/foto/foto4/'.$data['foto4']);
    }

// --------SK----------
$query= "SELECT * FROM tb_sk ORDER BY id_sk DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaksanaan/sk/file/sk/'.$data['sk'], '../../backup/file/pelaksanaan/sk/file/sk/'.$data['sk']);
    }

// .....................................PELAPORAN...........................

// --------BULANAN----------
$query= "SELECT * FROM tb_bulanan ORDER BY id_bulanan DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/bulanan/file/bulanan/'.$data['bulanan'], '../../backup/file/pelaporan/bulanan/file/bulanan/'.$data['bulanan']);
    }

// --------SEMESTER 1----------
$query= "SELECT * FROM tb_smt_1 ORDER BY id_smt_1 DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/semester_1/file/smt_1/'.$data['smt_1'], '../../backup/file/pelaporan/semester_1/file/smt_1/'.$data['smt_1']);
    }

// --------SEMESTER 2----------
$query= "SELECT * FROM tb_smt_2 ORDER BY id_smt_2 DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/semester_2/file/smt_2/'.$data['smt_2'], '../../backup/file/pelaporan/semester_2/file/smt_2/'.$data['smt_2']);
    }

// --------LPPD----------
$query= "SELECT * FROM tb_lppd ORDER BY id_lppd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/lppd/file/lppd/'.$data['lppd'], '../../backup/file/pelaporan/lppd/file/lppd/'.$data['lppd']);
    }

// --------IPPD----------
$query= "SELECT * FROM tb_ippd ORDER BY id_ippd DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/ippd/file/ippd/'.$data['ippd'], '../../backup/file/pelaporan/ippd/file/ippd/'.$data['ippd']);
    }

// --------lkpj----------
$query= "SELECT * FROM tb_lkpj ORDER BY id_lkpj DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/lkpj/file/lkpj/'.$data['lkpj'], '../../backup/file/pelaporan/lkpj/file/lkpj/'.$data['lkpj']);
    }

// --------OMSPAN----------
$query= "SELECT * FROM tb_omspan ORDER BY id_omspan DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/omspan/file/omspan/'.$data['omspan'], '../../backup/file/pelaporan/omspan/file/omspan/'.$data['omspan']);
    }

// --------PERTANGGUNGJAWABAN----------
$query= "SELECT * FROM tb_tanggung_jawab ORDER BY id_tanggung_jawab DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/tanggungjawab/file/tanggungjawab/'.$data['tanggung_jawab'], '../../backup/file/pelaporan/tanggungjawab/file/tanggungjawab/'.$data['tanggung_jawab']);
        copy('../pelaporan/tanggungjawab/file/perdes/'.$data['perdes'], '../../backup/file/pelaporan/tanggungjawab/file/perdes/'.$data['perdes']);
    }

// --------BA_KAS----------
$query= "SELECT * FROM tb_ba_kas ORDER BY id_ba_kas DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/ba_kas/file/ba_kas/'.$data['ba_kas'], '../../backup/file/pelaporan/ba_kas/file/ba_kas/'.$data['ba_kas']);
    }

// --------HABIS PAKAI----------
$query= "SELECT * FROM tb_habis_pakai ORDER BY id_habis_pakai DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/habis_pakai/file/habis_pakai/'.$data['habis_pakai'], '../../backup/file/pelaporan/habis_pakai/file/habis_pakai/'.$data['habis_pakai']);
    }

// --------REKAP APBDES----------
$query= "SELECT * FROM tb_rekap_realisasi_apbdes ORDER BY id_rekap_realisasi_apbdes DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/rekap_apbdes/file/rekap_apbdes/'.$data['rekap_realisasi_apbdes'], '../../backup/file/pelaporan/rekap_apbdes/file/rekap_apbdes/'.$data['rekap_realisasi_apbdes']);
    }

// --------REKAP SUMBER DANA----------
$query= "SELECT * FROM tb_realisasi_apbdes_dana ORDER BY id_realisasi_apbdes_dana DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/rekap_sumberdana/file/rekap_sumberdana/'.$data['realisasi_apbdes_dana'], '../../backup/file/pelaporan/rekap_sumberdana/file/rekap_sumberdana/'.$data['realisasi_apbdes_dana']);
    }

// --------TUTUP KAS----------
$query= "SELECT * FROM tb_tutup_kas ORDER BY id_tutup_kas DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/register_kas/file/register_kas/'.$data['tutup_kas'], '../../backup/file/pelaporan/register_kas/file/register_kas/'.$data['tutup_kas']);
    }

// --------LAIN-LAIN----------
$query= "SELECT * FROM tb_lain ORDER BY id_lain_lain DESC";
$result = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_assoc($result)){
        copy('../pelaporan/lain_lain/file/lain_lain/'.$data['lain_lain'], '../../backup/file/pelaporan/lain_lain/file/lain_lain/'.$data['lain_lain']);
    }
} 
?>
<script type="text/javascript">
  alert("Data berhasil dibackup!");
  window.location = "../../index.php?page=backup";
</script>