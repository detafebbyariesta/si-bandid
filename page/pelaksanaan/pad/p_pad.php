<h1 class="h3 mb-4 text-gray-800">Halaman Realisasi PAD</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_p_padModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Realisasi PAD</th>
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
             $query = "SELECT * FROM tb_realisasi_pad
                      INNER JOIN tb_user ON tb_realisasi_pad.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_realisasi_pad DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_realisasi_pad
                      INNER JOIN tb_user ON tb_realisasi_pad.id_user = tb_user.id_user AND tb_realisasi_pad.id_user=$id_user AND tahun='$tahun' ORDER BY id_realisasi_pad DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data realisasi_pad
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaksanaan/pad/file/pad/<?php echo $data['realisasi_pad']; ?>">
              <i class="fas fa-download" id="downloadpad">&nbsp;&nbsp;</i></a><?php echo $data['realisasi_pad']; ?>
            </td>
            <td>
              <!-- foto kegiatan dengan gallery lightbox 1-->
              <a href="page/pelaksanaan/pad/file/foto/foto1/<?php echo $data['foto_pad_1']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/pad/file/foto/foto1/<?php echo $data['foto_pad_1']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 2-->
              <a href="page/pelaksanaan/pad/file/foto/foto2/<?php echo $data['foto_pad_2']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/pad/file/foto/foto2/<?php echo $data['foto_pad_2']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a> <br>

              <!-- foto kegiatan dengan gallery lightbox 3-->
              <a href="page/pelaksanaan/pad/file/foto/foto3/<?php echo $data['foto_pad_3']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/pad/file/foto/foto3/<?php echo $data['foto_pad_3']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 4-->
              <a href="page/pelaksanaan/pad/file/foto/foto4/<?php echo $data['foto_pad_4']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/pad/file/foto/foto4/<?php echo $data['foto_pad_4']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#p_padModal"
                      data-idrealisasi_pad="<?php echo $data["id_realisasi_pad"];?>"
                      data-valid="<?php echo $data["validasi"];?>"
                      data-catat="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_p_padModal"
              data-id_realisasi_pad="<?php echo $data['id_realisasi_pad'];?>"
              data-fotopad1="<?php echo $data['foto_pad_1'];?>"
              data-fotopad2="<?php echo $data['foto_pad_2'];?>"
              data-fotopad3="<?php echo $data['foto_pad_3'];?>"
              data-fotopad4="<?php echo $data['foto_pad_4'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaksanaan/pad/hapus.php?id_realisasi_pad=<?php echo $data['id_realisasi_pad'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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


<!-- Modal add p_pad -->
<div class="modal fade" id="add_p_padModal" tabindex="-1" aria-labelledby="add_padModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_padModalLabel">Form Add Realisasi PAD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/pad/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Realisasi PAD</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="p_pad" name="p_pad" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File PAD ekstensi Excel, Word & pdf </small></span>
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
var uploadField = document.getElementById("p_pad");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('p_pad');
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

<!-- Modal edit p_pad -->
<div class="modal fade" id="edit_p_padModal" tabindex="-1" aria-labelledby="p_padModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_padModalLabel">Form Edit Realisasi PAD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaksanaan/pad/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_realisasi_pad" id="id_realisasi_pad">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">File Realisasi PAD</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="realisasi_pad" id="padrealisasi"  onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <span class="text-danger"><small>* File pad ekstensi Excel, Word & pdf </small></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">Foto Kegiatan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotopad1" id="padfoto1" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 1</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotopad1"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotopad2" id="padfoto2" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 2</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotopad2"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotopad3" id="padfoto3" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 3</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotopad3"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotopad4" id="padfoto4" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 4</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotopad4"  alt="" width="100%">
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
    $('#edit_p_padModal').modal();
    var id_realisasi_pad = $(this).attr('data-id_realisasi_pad')
    var fotopad1 = $(this).attr('data-fotopad1')
    var fotopad2 = $(this).attr('data-fotopad2')
    var fotopad3 = $(this).attr('data-fotopad3')
    var fotopad4 = $(this).attr('data-fotopad4')
    var id_user = $(this).attr('data-iduser')

    $('#id_realisasi_pad').val(id_realisasi_pad)
    $('#fotopad1').attr("src","page/pelaksanaan/pad/file/foto/foto1/"+fotopad1)
    $('#fotopad2').attr("src","page/pelaksanaan/pad/file/foto/foto2/"+fotopad2)
    $('#fotopad3').attr("src","page/pelaksanaan/pad/file/foto/foto3/"+fotopad3)
    $('#fotopad4').attr("src","page/pelaksanaan/pad/file/foto/foto4/"+fotopad4)
    $('#iduser').val(id_user)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("padrealisasi");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('padrealisasi');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("padfoto1");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('padfoto1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("padfoto2");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('padfoto2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("padfoto3");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('padfoto3');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("padfoto4");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('padfoto4');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi p_pad -->
<div class="modal fade" id="p_padModal" tabindex="-1" aria-labelledby="p_padModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="p_padModalLabel">Form Validasi Realisasi PAD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/pad/validasi.php">
          <input type="hidden" name="idrealisasi_pad" id="idrealisasi_pad">
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
    $('#p_padModal').modal();
    var idrealisasi_pad = $(this).attr('data-idrealisasi_pad')
    var valid = $(this).attr('data-valid')
    var catat = $(this).attr('data-catat')
    $('#idrealisasi_pad').val(idrealisasi_pad)
    $('#valid').val(valid)
    $('#catat').val(catat)
  })
</script>