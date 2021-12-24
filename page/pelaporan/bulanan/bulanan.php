<h1 class="h3 mb-4 text-gray-800">Halaman Laporan Bulanan</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_bulananModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Laporan Bulanan</th>
            <th width="5%" class="text-center  align-middle">Validasi</th>
            <th class="text-center  align-middle">Catatan</th>
            <th class="text-center  align-middle">Bulan</th>
            <!-- Kolom action tampil jika user sudah login -->
            <th width="18%" class="text-center  align-middle">Action</th>
          </tr>
        </thead>
        <tbody>   

        <?php  
          include "asset/inc/config.php";
          $tahun = $_SESSION['tahun'];
          if ($_SESSION['level']=="admin") {
             $query = "SELECT * FROM tb_bulanan
                      INNER JOIN tb_user ON tb_bulanan.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_bulanan DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_bulanan
                      INNER JOIN tb_user ON tb_bulanan.id_user = tb_user.id_user AND tb_bulanan.id_user=$id_user AND tahun='$tahun' ORDER BY id_bulanan DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data bulanan
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>      
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaporan/bulanan/file/bulanan/<?php echo $data['bulanan']; ?>">
              <i class="fas fa-download" id="downloadbulanan">&nbsp;&nbsp;</i></a><?php echo $data['bulanan']; ?>
            </td>

            <!-- Jika catatan "revisi" kolom berwarna merah kalau "diterima" warna hijau -->
            <?php 
              $validasi = $data['validasi'];
              $jumlah_karakter    =strlen($validasi);
              // revisi
              if ($jumlah_karakter == 6) {
              $color = "class='bg-danger text-white';";
              }
              // diterima
              elseif ($jumlah_karakter == 8){
              $color = "class='bg-success text-white';";
              }
              // menunggu validasi
              elseif ($jumlah_karakter == 17){
              $color = "class='bg-info text-white';";
              }
              // menunggu validasi revisi
              elseif ($jumlah_karakter ){
              $color = "class='bg-primary text-white';";
              }
              ?>
            <td <?= $color ?> ><?php echo $validasi; ?></td>
            <td><?php echo $data['catatan']; ?></td>
            <td><?php echo $data['bulan']; ?></td>
            <td>
              <!-- tombol validasi muncul jika login level admin -->
              
              <?php 
                if ($_SESSION['level']=="admin") {
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#validasi_bulananModal"
                      data-idbulanan="<?php echo $data["id_bulanan"];?>"
                      data-validasi="<?php echo $data["validasi"];?>"
                      data-catatan="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_bulananModal"
              data-id_bulanan="<?php echo $data['id_bulanan'];?>"
              data-bulanan="<?php echo $data['bulanan'];?>"
              data-bulan="<?php echo $data['bulan'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaporan/bulanan/hapus.php?id_bulanan=<?php echo $data['id_bulanan'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
            </td>
          </tr>
          <?php
          $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- Modal add -->
<div class="modal fade" id="add_bulananModal" tabindex="-1" aria-labelledby="bulananModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulananModalLabel">Form Add Laporan Bulanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/bulanan/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">Laporan Bulanan</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="bulanan" name="bulanan" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File Laporan ekstensi Excel, Word & pdf </small></span>
          </div>
          <div class="form-group">
            <label for="bln">Bulan</label>
            <select name="bln" class="form-control">
              <option selected="selected">-- Pilih --</option>
              <?php
              $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
              $jlh_bln=count($bulan);
              for($c=0; $c<$jlh_bln; $c+=1){
                echo"<option value=$bulan[$c]> $bulan[$c] </option>";
              }
              ?>
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="submit">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
var uploadField = document.getElementById("bulanan");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('bulanan');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal edit -->
<div class="modal fade" id="edit_bulananModal" tabindex="-1" aria-labelledby="bulananModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulananModalLabel">Form Edit Laporan Bulanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaporan/bulanan/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_bulanan" id="id_blnn">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
            <label for="">Laporan Bulanan</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="bulanan" id="blnn"  onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <span class="text-danger"><small>* File Laporan ekstensi Excel, Word & pdf </small></span>
          </div>
          <div class="form-group">
            <label for="bulan">Bulan</label>
            <select class="form-control" name="bulan" id="bln" tabindex="-1">
              <option selected="selected">-- Pilih --</option>
              <?php
              $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
              $jlh_bln=count($bulan);
              for($c=0; $c<$jlh_bln; $c+=1){
                echo"<option value=$bulan[$c]> $bulan[$c] </option>";
              }
              ?>
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="update">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.edit').click(function(){
    $('#edit_bulananModal').modal();
    var id_bulanan = $(this).attr('data-id_bulanan')
    var bulanan = $(this).attr('data-bulanan')
    var bulan = $(this).attr('data-bulan')
    var id_user = $(this).attr('data-iduser')

    $('#id_blnn').val(id_bulanan)
    $('#blnn').val(bulanan)
    $('#bln').val(bulan)
    $('#iduser').val(id_user)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("blnn");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('blnn');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>


<!-- Modal validasi -->
<div class="modal fade" id="validasi_bulananModal" tabindex="-1" aria-labelledby="bulananModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulananModalLabel">Form Validasi Laporan Bulanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/bulanan/validasi.php">
          <input type="hidden" name="id_bulanan" id="idbulanan">
          <div class="form-group">
            <label for="validasi">Validasi</label>
            <select class="form-control" name="debug" id="validasi" tabindex="-1">
              <option>-- Pilih --</option>
              <option value="Revisi">Revisi</option>
              <option value="Diterima">Diterima</option>
            </select>
              <script>
                $(function() {
                  $("#validasi").on("change", function() {
                    $("#debug").text($("#validasi").val());
                  }).trigger("change");
                });
              </script>
          </div>
          <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="validasi">Save changes</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.validasi').click(function(){
    $('#validasi_bulananModal').modal();
    var id_bulanan = $(this).attr('data-idbulanan')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#idbulanan').val(id_bulanan)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>