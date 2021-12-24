<h1 class="h3 mb-4 text-gray-800">Halaman RKPDes</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_rkpdesModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center">No</th>
            <th width="5%" class="text-center">Desa</th>
            <th class="text-center">RKPDes</th>
            <th class="text-center">Perdes</th>
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
             $query = "SELECT * FROM tb_rkpdes
                      INNER JOIN tb_user ON tb_rkpdes.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_rkpdes DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_rkpdes
                      INNER JOIN tb_user ON tb_rkpdes.id_user = tb_user.id_user AND tb_rkpdes.id_user=$id_user AND tahun='$tahun' ORDER BY id_rkpdes DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data rkpdes
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/perencanaan/rkpdes/file/rkpdes/<?php echo $data['rkpdes']; ?>">
              <i class="fas fa-download" id="downloadrkpdes">&nbsp;&nbsp;</i></a><?php echo $data['rkpdes']; ?>
            </td>
            <td><a href="page/perencanaan/rkpdes/file/perdes/<?php echo $data['perdes']; ?>"><i class="fas fa-download" id="downloadperdes">&nbsp;&nbsp;</i></a><?php echo $data['perdes']; ?></td>

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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#rkpdesModal"
                      data-idrkpdes="<?php echo $data["id_rkpdes"];?>"
                      data-validasi="<?php echo $data["validasi"];?>"
                      data-catatan="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_rkpdesModal"
              data-id_rkpdes="<?php echo $data['id_rkpdes'];?>"
              data-rkpdes="<?php echo $data['rkpdes'];?>"
              data-perdes="<?php echo $data['perdes'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/perencanaan/rkpdes/hapus.php?id_rkpdes=<?php echo $data['id_rkpdes'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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

<!-- Modal add rkpdes -->
<div class="modal fade" id="add_rkpdesModal" tabindex="-1" aria-labelledby="rkpdesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rkpdesModalLabel">Form Add RKPDes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/perencanaan/rkpdes/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File RKPDes</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="rkpdes" name="rkpdes" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>
          <div class="form-group">
            <label for="">Perdes RKPDes</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="perdes" name="perdes" required="" onchange="return validasiFile()"/>
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
var uploadField = document.getElementById("rkpdes");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('rkpdes');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("perdes");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('perdes');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal edit rkpdes -->
<div class="modal fade" id="edit_rkpdesModal" tabindex="-1" aria-labelledby="rkpdesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rkpdesModalLabel">Form Edit RKPDes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <form action="page/perencanaan/rkpdes/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_rkpdes" id="id_rkpdes">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
          <label for="rkpdes">File rkpdes</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="rkpdes" id="rpjm" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>
          <div class="form-group">
          <label for="perdes">Perdes RKPDes</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="perdes" id="perd" onchange="return validasiFile()"/>
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
    $('#edit_rkpdesModal').modal();
    var id_rkpdes = $(this).attr('data-id_rkpdes')
    var rkpdes = $(this).attr('data-rkpdes')
    var perdes = $(this).attr('data-perdes')
    var id_user = $(this).attr('data-iduser')
    var tahun = $(this).attr('data-tahun')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#id_rkpdes').val(id_rkpdes)
    $('#rpjm').val(rkpdes)
    $('#perd').val(perdes)
    $('#iduser').val(id_user)
    $('#tahun').val(tahun)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("rpjm");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('rpjm');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };

  var uploadField = document.getElementById("perd");
  uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('perd');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi rkpdes -->
<div class="modal fade" id="rkpdesModal" tabindex="-1" aria-labelledby="rkpdesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rkpdesModalLabel">Form Validasi RKPDes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <div class="modal-body">
        <form method="POST" action="page/perencanaan/rkpdes/validasi.php">
          <input type="hidden" name="id_rkpdes" id="idrkpdes">
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
    $('#rkpdesModal').modal();
    var id_rkpdes = $(this).attr('data-idrkpdes')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#idrkpdes').val(id_rkpdes)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>