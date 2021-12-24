<h1 class="h3 mb-4 text-gray-800">Halaman Laporan Semester 2</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_smt_2Modal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center">No</th>
            <th width="5%" class="text-center">Desa</th>
            <th class="text-center">Laporan Semester 2</th>
            <th width="5%" class="text-center">Validasi</th>
            <th class="text-center">Catatan</th>
            <!-- Kolom action tampil jika user sudah login -->
            <th width="18%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  
          include "asset/inc/config.php";
          $tahun = $_SESSION['tahun'];
          if ($_SESSION['level']=="admin") {
             $query = "SELECT * FROM tb_smt_2
                      INNER JOIN tb_user ON tb_smt_2.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_smt_2 DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_smt_2
                      INNER JOIN tb_user ON tb_smt_2.id_user = tb_user.id_user AND tb_smt_2.id_user=$id_user AND tahun='$tahun' ORDER BY id_smt_2 DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data smt_2
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaporan/semester_2/file/smt_2/<?php echo $data['smt_2']; ?>">
              <i class="fas fa-download" id="downloadsmt_2">&nbsp;&nbsp;</i></a><?php echo $data['smt_2']; ?>
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
            <td>
              <!-- tombol validasi muncul jika login level admin -->
              <?php 
                if ($_SESSION['level']=="admin") {
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#smt_2Modal"
                      data-idsmt_2="<?php echo $data["id_smt_2"];?>"
                      data-validasi="<?php echo $data["validasi"];?>"
                      data-catatan="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_smt_2Modal"
              data-id_smt_2="<?php echo $data['id_smt_2'];?>"
              data-smt_2="<?php echo $data['smt_2'];?>"
              data-perdes="<?php echo $data['perdes'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaporan/semester_2/hapus.php?id_smt_2=<?php echo $data['id_smt_2'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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

<!-- Modal add smt_2 -->
<div class="modal fade" id="add_smt_2Modal" tabindex="-1" aria-labelledby="smt_2ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="smt_2ModalLabel">Form Add Laporan Semester 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/semester_2/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Laporan Semester 2</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="smt_2" name="smt_2" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>
          <span class="text-danger"><small>* File yang diperbolehkan Excel, Word & pdf </small></span><br>
          <span class="text-danger"><small>* Ukuran file maksimal 5mb</small></span>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="submit">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
var uploadField = document.getElementById("smt_2");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('smt_2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal edit smt_2 -->
<div class="modal fade" id="edit_smt_2Modal" tabindex="-1" aria-labelledby="smt_2ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="smt_2ModalLabel">Form Edit Laporan Semester 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <form action="page/pelaporan/semester_2/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_smt_2" id="id_smt_2">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
          <label for="smt_2">File Laporan Semester 2</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="smt_2" id="smt1" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>
          <span class="text-danger"><small>* File yang diperbolehkan Excel, Word & pdf </small></span><br>
          <span class="text-danger"><small>* Ukuran file maksimal 5mb</small></span>
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
    $('#edit_smt_2Modal').modal();
    var id_smt_2 = $(this).attr('data-id_smt_2')
    var smt_2 = $(this).attr('data-smt_2')
    var id_user = $(this).attr('data-iduser')
    var tahun = $(this).attr('data-tahun')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#id_smt_2').val(id_smt_2)
    $('#smt1').val(smt_2)
    $('#iduser').val(id_user)
    $('#tahun').val(tahun)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("smt1");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('smt1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi smt_2 -->
<div class="modal fade" id="smt_2Modal" tabindex="-1" aria-labelledby="smt_2ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="smt_2ModalLabel">Form Validasi Semester 2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/semester_2/validasi.php">
          <input type="hidden" name="id_smt_2" id="idsmt_2">
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
    $('#smt_2Modal').modal();
    var id_smt_2 = $(this).attr('data-idsmt_2')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#idsmt_2').val(id_smt_2)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>