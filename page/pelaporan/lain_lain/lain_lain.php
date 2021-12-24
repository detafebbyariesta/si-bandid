<h1 class="h3 mb-4 text-gray-800">Halaman Laporan Lain-lain</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_lain_lainModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Lain-lain</th>
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
               $query = "SELECT * FROM tb_lain
                        INNER JOIN tb_user ON tb_lain.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_lain_lain DESC";
              $result = mysqli_query($koneksi, $query);
            }
            if ($_SESSION['level']=="user") {
              $id_user = $_SESSION['id_user'];
              $query= "SELECT * FROM tb_lain
                        INNER JOIN tb_user ON tb_lain.id_user = tb_user.id_user AND tb_lain.id_user=$id_user AND tahun='$tahun' ORDER BY id_lain_lain DESC";
              $result = mysqli_query($koneksi, $query);
            }  
              //mengecek apakah ada error ketika menjalankan query
              if(!$result){
                die ("Query Error: ".mysqli_errno($koneksi).
                   " - ".mysqli_error($koneksi));
              }
              //buat perulangan untuk element tabel dari data lain_lain
              $no = 1;
              while($data = mysqli_fetch_assoc($result))
              {
              ?>        
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaporan/lain_lain/file/lain_lain/<?php echo $data['lain_lain']; ?>">
              <i class="fas fa-download" id="downloadlain_lain">&nbsp;&nbsp;</i></a><?php echo $data['lain_lain']; ?>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#p_lain_lainModal"
                      data-idlain_lain="<?php echo $data["id_lain_lain"];?>"
                      data-valid="<?php echo $data["validasi"];?>"
                      data-catat="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_lain_lainModal"data-id_lain_lain="<?php echo $data['id_lain_lain'];?>"
              data-keterangan="<?php echo $data['keterangan'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaporan/lain_lain/hapus.php?id_lain_lain=<?php echo $data['id_lain_lain'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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
<div class="modal fade" id="add_lain_lainModal" tabindex="-1" aria-labelledby="lain_lainModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lain_lainModalLabel">Form Add Lain-lain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/lain_lain/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Lain-lain</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="lain_lain" name="lain_lain" required="" onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          <span class="text-danger"><small>* File Lain-lain ekstensi Excel, Word & pdf </small></span>
          </div>
          <div class="form-group">
            <label for="ket">Keterangan</label>
            <textarea class="form-control" id="ket" name="ket" rows="3" placeholder="Anggaran DD, ADD, dll"></textarea>
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
var uploadField = document.getElementById("lain_lain");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('lain_lain');
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
<div class="modal fade" id="edit_lain_lainModal" tabindex="-1" aria-labelledby="lain_lainModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lain_lainModalLabel">Form Edit Lain-lain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaporan/lain_lain/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_lain_lain" id="id_lain_lain">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
            <label for="">Lain-lain</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="lain_lain" id="lain"  onchange="return validasiFile()"/>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <span class="text-danger"><small>* File ekstensi Excel, Word & pdf </small></span>
          </div>
          <div class="form-group">
            <label for="ket">Keterangan</label>
            <textarea class="form-control" id="keterang" name="keterang" rows="3"></textarea>
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
    $('#edit_lain_lainModal').modal();
    var id_lain_lain = $(this).attr('data-id_lain_lain')
    var id_user = $(this).attr('data-iduser')
    var ket = $(this).attr('data-keterangan')

    $('#id_lain_lain').val(id_lain_lain)
    $('#iduser').val(id_user)
    $('#keterang').val(ket)

  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("lain");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('lain');
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
<div class="modal fade" id="validasi_lain_lainModal" tabindex="-1" aria-labelledby="lain_lainModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lain_lainModalLabel">Form Validasi Lain-lain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/lain_lain/validasi.php">
          <input type="hidden" name="idlain_lain" id="idlain_lain">
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
    $('#validasi_lain_lainModal').modal();
    var idlain_lain = $(this).attr('data-idlain_lain')
    var valid = $(this).attr('data-valid')
    var catat = $(this).attr('data-catat')
    $('#idlain_lain').val(idlain_lain)
    $('#valid').val(valid)
    $('#catat').val(catat)
  })
</script>