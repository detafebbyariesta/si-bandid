<h1 class="h3 mb-4 text-gray-800">Halaman Realisasi APBDES</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_p_apbdesModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Realisasi APBDES</th>
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
             $query = "SELECT * FROM tb_realisasi_apbdes
                      INNER JOIN tb_user ON tb_realisasi_apbdes.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_realisasi_apbdes DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_realisasi_apbdes
                      INNER JOIN tb_user ON tb_realisasi_apbdes.id_user = tb_user.id_user AND tb_realisasi_apbdes.id_user=$id_user AND tahun='$tahun' ORDER BY id_realisasi_apbdes DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data realisasi_apbdes
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaksanaan/apbdes/file/apbdes/<?php echo $data['realisasi_apbdes']; ?>">
              <i class="fas fa-download" id="downloadapbdes">&nbsp;&nbsp;</i></a><?php echo $data['realisasi_apbdes']; ?>
            </td>
            <td>
              <!-- foto kegiatan dengan gallery lightbox 1-->
              <a href="page/pelaksanaan/apbdes/file/foto/foto1/<?php echo $data['foto_apbdes_1']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/apbdes/file/foto/foto1/<?php echo $data['foto_apbdes_1']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 2-->
              <a href="page/pelaksanaan/apbdes/file/foto/foto2/<?php echo $data['foto_apbdes_2']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/apbdes/file/foto/foto2/<?php echo $data['foto_apbdes_2']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a> <br>

              <!-- foto kegiatan dengan gallery lightbox 3-->
              <a href="page/pelaksanaan/apbdes/file/foto/foto3/<?php echo $data['foto_apbdes_3']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/apbdes/file/foto/foto3/<?php echo $data['foto_apbdes_3']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 4-->
              <a href="page/pelaksanaan/apbdes/file/foto/foto4/<?php echo $data['foto_apbdes_4']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/apbdes/file/foto/foto4/<?php echo $data['foto_apbdes_4']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#p_apbdesModal"
                      data-idrealisasi_apbdes="<?php echo $data["id_realisasi_apbdes"];?>"
                      data-valid="<?php echo $data["validasi"];?>"
                      data-catat="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_p_apbdesModal"
              data-id_realisasi_apbdes="<?php echo $data['id_realisasi_apbdes'];?>"
              data-fotoapbdes1="<?php echo $data['foto_apbdes_1'];?>"
              data-fotoapbdes2="<?php echo $data['foto_apbdes_2'];?>"
              data-fotoapbdes3="<?php echo $data['foto_apbdes_3'];?>"
              data-fotoapbdes4="<?php echo $data['foto_apbdes_4'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaksanaan/apbdes/hapus.php?id_realisasi_apbdes=<?php echo $data['id_realisasi_apbdes'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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


<!-- Modal add p_apbdes -->
<div class="modal fade" id="add_p_apbdesModal" tabindex="-1" aria-labelledby="add_apbdesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_apbdesModalLabel">Form Add Realisasi APBDES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/apbdes/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Realisasi APBDES</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="p_apbdes" name="p_apbdes" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File APBDES ekstensi Excel, Word & pdf </small></span>
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
var uploadField = document.getElementById("p_apbdes");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('p_apbdes');
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

<!-- Modal edit p_apbdes -->
<div class="modal fade" id="edit_p_apbdesModal" tabindex="-1" aria-labelledby="p_apbdesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_apbdesModalLabel">Form Edit Realisasi APBDES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaksanaan/apbdes/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_realisasi_apbdes" id="id_realisasi_apbdes">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">File Realisasi APBDES</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="realisasi_apbdes" id="apbdesrealisasi"  onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <span class="text-danger"><small>* File APBDES ekstensi Excel, Word & pdf </small></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">Foto Kegiatan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoapbdes1" id="apbdesfoto1" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 1</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoapbdes1"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoapbdes2" id="apbdesfoto2" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 2</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoapbdes2"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoapbdes3" id="apbdesfoto3" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 3</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoapbdes3"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoapbdes4" id="apbdesfoto4" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 4</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoapbdes4"  alt="" width="100%">
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
    $('#edit_p_apbdesModal').modal();
    var id_realisasi_apbdes = $(this).attr('data-id_realisasi_apbdes')
    var fotoapbdes1 = $(this).attr('data-fotoapbdes1')
    var fotoapbdes2 = $(this).attr('data-fotoapbdes2')
    var fotoapbdes3 = $(this).attr('data-fotoapbdes3')
    var fotoapbdes4 = $(this).attr('data-fotoapbdes4')
    var id_user = $(this).attr('data-iduser')

    $('#id_realisasi_apbdes').val(id_realisasi_apbdes)
    $('#fotoapbdes1').attr("src","page/pelaksanaan/apbdes/file/foto/foto1/"+fotoapbdes1)
    $('#fotoapbdes2').attr("src","page/pelaksanaan/apbdes/file/foto/foto2/"+fotoapbdes2)
    $('#fotoapbdes3').attr("src","page/pelaksanaan/apbdes/file/foto/foto3/"+fotoapbdes3)
    $('#fotoapbdes4').attr("src","page/pelaksanaan/apbdes/file/foto/foto4/"+fotoapbdes4)
    $('#iduser').val(id_user)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("apbdesrealisasi");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('apbdesrealisasi');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("apbdesfoto1");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('apbdesfoto1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("apbdesfoto2");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('apbdesfoto2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("apbdesfoto3");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('apbdesfoto3');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("apbdesfoto4");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('apbdesfoto4');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi p_apbdes -->
<div class="modal fade" id="p_apbdesModal" tabindex="-1" aria-labelledby="p_apbdesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_apbdesModalLabel">Form Validasi Realisasi APBDES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/apbdes/validasi.php">
          <input type="hidden" name="idrealisasi_apbdes" id="idrealisasi_apbdes">
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
    $('#p_apbdesModal').modal();
    var idrealisasi_apbdes = $(this).attr('data-idrealisasi_apbdes')
    var valid = $(this).attr('data-valid')
    var catat = $(this).attr('data-catat')
    $('#idrealisasi_apbdes').val(idrealisasi_apbdes)
    $('#valid').val(valid)
    $('#catat').val(catat)
  })
</script>