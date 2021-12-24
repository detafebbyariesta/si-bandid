<h1 class="h3 mb-4 text-gray-800">Halaman Retribusi</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_retribusiModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Retribusi</th>
            <th class="text-center  align-middle">Foto Kegiatan</th>
            <th width="5%" class="text-center  align-middle">Validasi</th>
            <th class="text-center  align-middle">Catatan</th>
            <th class="text-center  align-middle">Keterangan</th>
            <!-- Kolom action tampil jika user sudah login -->
            <th width="18%" class="text-center  align-middle">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php  
            include "asset/inc/config.php";
            $tahun = $_SESSION['tahun'];
            if ($_SESSION['level']=="admin") {
               $query = "SELECT * FROM tb_retribusi
                        INNER JOIN tb_user ON tb_retribusi.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_retribusi DESC";
              $result = mysqli_query($koneksi, $query);
            }
            if ($_SESSION['level']=="user") {
              $id_user = $_SESSION['id_user'];
              $query= "SELECT * FROM tb_retribusi
                        INNER JOIN tb_user ON tb_retribusi.id_user = tb_user.id_user AND tb_retribusi.id_user=$id_user AND tahun='$tahun' ORDER BY id_retribusi DESC";
              $result = mysqli_query($koneksi, $query);
            }  
              //mengecek apakah ada error ketika menjalankan query
              if(!$result){
                die ("Query Error: ".mysqli_errno($koneksi).
                   " - ".mysqli_error($koneksi));
              }
              //buat perulangan untuk element tabel dari data retribusi
              $no = 1;
              while($data = mysqli_fetch_assoc($result))
              {
              ?>        
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaksanaan/retribusi/file/retribusi/<?php echo $data['retribusi']; ?>">
              <i class="fas fa-download" id="downloadretribusi">&nbsp;&nbsp;</i></a><?php echo $data['retribusi']; ?>
            </td>
            <td>
              <!-- foto kegiatan dengan gallery lightbox 1-->
              <a href="page/pelaksanaan/retribusi/file/foto/foto1/<?php echo $data['foto1']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/retribusi/file/foto/foto1/<?php echo $data['foto1']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 2-->
              <a href="page/pelaksanaan/retribusi/file/foto/foto2/<?php echo $data['foto2']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/retribusi/file/foto/foto2/<?php echo $data['foto2']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a> <br>

              <!-- foto kegiatan dengan gallery lightbox 3-->
              <a href="page/pelaksanaan/retribusi/file/foto/foto3/<?php echo $data['foto3']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/retribusi/file/foto/foto3/<?php echo $data['foto3']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>

              <!-- foto kegiatan dengan gallery lightbox 4-->
              <a href="page/pelaksanaan/retribusi/file/foto/foto4/<?php echo $data['foto4']; ?>" data-toggle="lightbox" data-title="Foto Kegiatan">        
              <img src="page/pelaksanaan/retribusi/file/foto/foto4/<?php echo $data['foto4']; ?>" width="30%" height="30%" class="img-fluid" alt="" ></a>
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
            <td><?php echo $data['keterangan']; ?></td>
            <td>
              <!-- tombol validasi muncul jika login level admin -->
              
              <?php 
                if ($_SESSION['level']=="admin") {
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#p_retribusiModal"
                      data-idretribusi="<?php echo $data["id_retribusi"];?>"
                      data-valid="<?php echo $data["validasi"];?>"
                      data-catat="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_retribusiModal"data-id_retribusi="<?php echo $data['id_retribusi'];?>"
              data-fotoretribusi1="<?php echo $data['foto1'];?>"
              data-fotoretribusi2="<?php echo $data['foto2'];?>"
              data-fotoretribusi3="<?php echo $data['foto3'];?>"
              data-fotoretribusi4="<?php echo $data['foto4'];?>"
              data-keterangan="<?php echo $data['keterangan'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaksanaan/retribusi/hapus.php?id_retribusi=<?php echo $data['id_retribusi'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
            </td>
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
<div class="modal fade" id="add_retribusiModal" tabindex="-1" aria-labelledby="retribusiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retribusiModalLabel">Form Add Retribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/retribusi/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Realisasi retribusi</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="retribusi" name="retribusi" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File retribusi ekstensi Excel, Word & pdf </small></span>
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
          <div class="form-group">
            <label for="ket">Keterangan</label>
            <input type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan">
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
var uploadField = document.getElementById("retribusi");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusi');
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

<!-- Modal edit -->
<div class="modal fade" id="edit_retribusiModal" tabindex="-1" aria-labelledby="retribusiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retribusiModalLabel">Form Edit Retribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaksanaan/retribusi/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_retribusi" id="id_retribusi">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">File Retribusi</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="retribusi" id="retribusi"  onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <span class="text-danger"><small>* File Retribusi ekstensi Excel, Word & pdf </small></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="">Foto Kegiatan</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoretribusi1" id="retribusifoto1" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 1</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoretribusi1"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoretribusi2" id="retribusifoto2" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 2</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoretribusi2"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoretribusi3" id="retribusifoto3" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 3</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoretribusi3"  alt="" width="100%">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="fotoretribusi4" id="retribusifoto4" onchange="return validasiFile()"/>
                <label class="custom-file-label" for="customFile">Foto 4</label>
              </div>
            </div>
            <div class="form-group col-6">
            <label for="">Preview</label>
              <img src="" id="fotoretribusi4"  alt="" width="100%">
            </div>          
          </div>
          <span class="text-danger"><small>* File foto ekstensi jpg, jpeg,& png </small></span><br>
          <span class="text-danger"><small>* Ukuran file maksimal 5mb</small></span>
          <div class="form-group">
            <label for="ket">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" id="keterang">
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
    $('#edit_retribusiModal').modal();
    var id_retribusi = $(this).attr('data-id_retribusi')
    var fotoretribusi1 = $(this).attr('data-fotoretribusi1')
    var fotoretribusi2 = $(this).attr('data-fotoretribusi2')
    var fotoretribusi3 = $(this).attr('data-fotoretribusi3')
    var fotoretribusi4 = $(this).attr('data-fotoretribusi4')
    var id_user = $(this).attr('data-iduser')
    var ket = $(this).attr('data-keterangan')

    $('#id_retribusi').val(id_retribusi)
    $('#fotoretribusi1').attr("src","page/pelaksanaan/retribusi/file/foto/foto1/"+fotoretribusi1)
    $('#fotoretribusi2').attr("src","page/pelaksanaan/retribusi/file/foto/foto2/"+fotoretribusi2)
    $('#fotoretribusi3').attr("src","page/pelaksanaan/retribusi/file/foto/foto3/"+fotoretribusi3)
    $('#fotoretribusi4').attr("src","page/pelaksanaan/retribusi/file/foto/foto4/"+fotoretribusi4)
    $('#iduser').val(id_user)
    $('#keterang').val(ket)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("retribusi");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusi');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("retribusifoto1");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusifoto1');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("retribusifoto2");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusifoto2');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("retribusifoto3");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusifoto3');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("retribusifoto4");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('retribusifoto4');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .jpg.jpeg.png');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi -->
<div class="modal fade" id="validasi_retribusiModal" tabindex="-1" aria-labelledby="retribusiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retribusiModalLabel">Form Validasi Retribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaksanaan/retribusi/validasi.php">
          <input type="hidden" name="idretribusi" id="idretribusi">
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
    $('#validasi_retribusiModal').modal();
    var idretribusi = $(this).attr('data-idretribusi')
    var valid = $(this).attr('data-valid')
    var catat = $(this).attr('data-catat')
    $('#idretribusi').val(idretribusi)
    $('#valid').val(valid)
    $('#catat').val(catat)
  })
</script>