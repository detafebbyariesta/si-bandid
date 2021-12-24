<h1 class="h3 mb-4 text-gray-800">Halaman Realisasi DD</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_p_ddModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center  align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Realisasi DD</th>
            <th class="text-center  align-middle">Foto Kegiatan</th>
            <th width="5%" class="text-center  align-middle">Validasi</th>
            <th class="text-center  align-middle">Catatan</th>
            <!-- Kolom action tampil jika user sudah login -->
            <th width="18%" class="text-center  align-middle">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php  
          include "asset/inc/config.php";
          $tahun = $_SESSION['tahun'];
          if ($_SESSION['level']=="admin") {
             $query = "SELECT * FROM tb_realisasi_dd
                      INNER JOIN tb_user ON tb_realisasi_dd.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_realisasi_dd DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_realisasi_dd
                      INNER JOIN tb_user ON tb_realisasi_dd.id_user = tb_user.id_user AND tb_realisasi_dd.id_user=$id_user AND tahun='$tahun' ORDER BY id_realisasi_dd DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data realisasi_dd
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaksanaan/dd/file/p_dd/<?php echo $data['realisasi_dd']; ?>">
              <i class="fas fa-download" id="downloadp_dd">&nbsp;&nbsp;</i></a><?php echo $data['realisasi_dd']; ?>
            </td>
            <td>
              <!-- foto kegiatan dengan gallery lightbox 1-->
              <a href="page/pelaksanaan/dd/file/foto/foto1/<?php echo $data['foto_dd_1']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/dd/file/foto/foto1/<?php echo $data['foto_dd_1']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 2-->
              <a href="page/pelaksanaan/dd/file/foto/foto2/<?php echo $data['foto_dd_2']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/dd/file/foto/foto2/<?php echo $data['foto_dd_2']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a> <br>

              <!-- foto kegiatan dengan gallery lightbox 3-->
              <a href="page/pelaksanaan/dd/file/foto/foto3/<?php echo $data['foto_dd_3']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/dd/file/foto/foto3/<?php echo $data['foto_dd_3']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 4-->
              <a href="page/pelaksanaan/dd/file/foto/foto4/<?php echo $data['foto_dd_4']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/dd/file/foto/foto4/<?php echo $data['foto_dd_4']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#p_ddModal"
                      data-idrealisasi_dd="<?php echo $data["id_realisasi_dd"];?>"
                      data-valid="<?php echo $data["validasi"];?>"
                      data-catat="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_p_ddModal"
              data-id_realisasi_dd="<?php echo $data['id_realisasi_dd'];?>"
              data-fotodd1="<?php echo $data['foto_dd_1'];?>"
              data-fotodd2="<?php echo $data['foto_dd_2'];?>"
              data-fotodd3="<?php echo $data['foto_dd_3'];?>"
              data-fotodd4="<?php echo $data['foto_dd_4'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaksanaan/dd/hapus.php?id_realisasi_dd=<?php echo $data['id_realisasi_dd'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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


<!-- Modal add p_dd -->
<div class="modal fade" id="add_p_ddModal" tabindex="-1" aria-labelledby="p_ddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_ddModalLabel">Form Add Realisasi DD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/dd/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Realisasi DD</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="p_dd" name="p_dd" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File DD ekstensi Excel, Word & pdf </small></span>
          </div>
          <div class="form-group">
            <label for="">Foto Kegiatan</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto1" name="foto1" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Foto 1</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto2" name="foto2" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Foto 2</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto3" name="foto3" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Foto 3</label>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto4" name="foto4" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Foto 4 (opsional)</label>
            </div>
          <span class="text-danger"><small>* File foto ekstensi jpg, jpeg,& png </small></span><br>
          <span class="text-danger"><small>* Ukuran file maksimal 5mb</small></span>
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

<script type="text/javascript">
var uploadField = document.getElementById("p_dd");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('p_dd');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("foto1");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("foto2");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("foto3");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto3');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("foto4");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('foto4');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal edit p_dd -->
<div class="modal fade" id="edit_p_ddModal" tabindex="-1" aria-labelledby="p_ddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_ddModalLabel">Form Edit Realisasi DD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaksanaan/dd/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_realisasi_dd" id="id_realisasi_dd">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">File Realisasi DD</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="realisasi_dd" id="ddrealisasi"  onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <span class="text-danger"><small>* File DD ekstensi Excel, Word & pdf </small></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">Foto Kegiatan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotodd1" id="ddfoto1" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 1</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotodd1"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotodd2" id="ddfoto2" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 2</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotodd2"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotodd3" id="ddfoto3" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 3</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotodd3"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotodd4" id="ddfoto4" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 4</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotodd4"  alt="" width="100%">
            </div>          
          </div>
          <span class="text-danger"><small>* File foto ekstensi jpg, jpeg,& png </small></span><br>
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
    $('#edit_p_ddModal').modal();
    var id_realisasi_dd = $(this).attr('data-id_realisasi_dd')
    // var realisasi_dd = $(this).attr('data-realisasi_dd')
    var fotodd1 = $(this).attr('data-fotodd1')
    var fotodd2 = $(this).attr('data-fotodd2')
    var fotodd3 = $(this).attr('data-fotodd3')
    var fotodd4 = $(this).attr('data-fotodd4')
    var id_user = $(this).attr('data-iduser')

    $('#id_realisasi_dd').val(id_realisasi_dd)
    // $('#realisasi_dd').val(realisasi_dd)
    $('#fotodd1').attr("src","page/pelaksanaan/dd/file/foto/foto1/"+fotodd1)
    $('#fotodd2').attr("src","page/pelaksanaan/dd/file/foto/foto2/"+fotodd2)
    $('#fotodd3').attr("src","page/pelaksanaan/dd/file/foto/foto3/"+fotodd3)
    $('#fotodd4').attr("src","page/pelaksanaan/dd/file/foto/foto4/"+fotodd4)
    $('#iduser').val(id_user)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("ddrealisasi");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ddrealisasi');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("ddfoto1");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ddfoto1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("ddfoto2");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ddfoto2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("ddfoto3");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ddfoto3');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("ddfoto4");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ddfoto4');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi p_dd -->
<div class="modal fade" id="p_ddModal" tabindex="-1" aria-labelledby="p_ddModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_ddModalLabel">Form Validasi Realisasi DD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/dd/validasi.php">
          <input type="hidden" name="idrealisasi_dd" id="idrealisasi_dd">
          <div class="form-group">
            <label for="validasi">Validasi</label>
            <select class="form-control" name="debug" id="valid" tabindex="-1">
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
            <textarea class="form-control" name="catat" id="catat" rows="3"></textarea>
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
    $('#p_ddModal').modal();
    var idrealisasi_dd = $(this).attr('data-idrealisasi_dd')
    var valid = $(this).attr('data-valid')
    var catat = $(this).attr('data-catat')
    $('#idrealisasi_dd').val(idrealisasi_dd)
    $('#valid').val(valid)
    $('#catat').val(catat)
  })
</script>