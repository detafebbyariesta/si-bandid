<h1 class="h3 mb-4 text-gray-800">Halaman Rekap Realisasi APBDes Per SumberDana</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_realisasi_apbdes_danaModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center">No</th>
            <th width="5%" class="text-center">Desa</th>
            <th class="text-center">Rekap Realisasi APBDes Per SumberDana</th>
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
             $query = "SELECT * FROM tb_realisasi_apbdes_dana
                      INNER JOIN tb_user ON tb_realisasi_apbdes_dana.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_realisasi_apbdes_dana DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_realisasi_apbdes_dana
                      INNER JOIN tb_user ON tb_realisasi_apbdes_dana.id_user = tb_user.id_user AND tb_realisasi_apbdes_dana.id_user=$id_user AND tahun='$tahun' ORDER BY id_realisasi_apbdes_dana DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data realisasi_apbdes_dana
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaporan/rekap_sumberdana/file/rekap_sumberdana/<?php echo $data['realisasi_apbdes_dana']; ?>">
              <i class="fas fa-download" id="downloadrekap_sumberdana">&nbsp;&nbsp;</i></a><?php echo $data['realisasi_apbdes_dana']; ?>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#realisasi_apbdes_danaModal"
                      data-idrealisasi_apbdes_dana="<?php echo $data["id_realisasi_apbdes_dana"];?>"
                      data-validasi="<?php echo $data["validasi"];?>"
                      data-catatan="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_realisasi_apbdes_danaModal"
              data-id_realisasi_apbdes_dana="<?php echo $data['id_realisasi_apbdes_dana'];?>"
              data-realisasi_apbdes_dana="<?php echo $data['realisasi_apbdes_dana'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaporan/rekap_sumberdana/hapus.php?id_realisasi_apbdes_dana=<?php echo $data['id_realisasi_apbdes_dana'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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

<!-- Modal add realisasi_apbdes_dana -->
<div class="modal fade" id="add_realisasi_apbdes_danaModal" tabindex="-1" aria-labelledby="realisasi_apbdes_danaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="realisasi_apbdes_danaModalLabel">Form Add Rekap Realisasi APBDes Per SumberDana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/rekap_sumberdana/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">File Rekap Realisasi APBDes Per SumberDana</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="realisasi_apbdes_dana" name="realisasi_apbdes_dana" required="" onchange="return validasiFile()"/>
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
var uploadField = document.getElementById("realisasi_apbdes_dana");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('realisasi_apbdes_dana');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal edit realisasi_apbdes_dana -->
<div class="modal fade" id="edit_realisasi_apbdes_danaModal" tabindex="-1" aria-labelledby="realisasi_apbdes_danaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="realisasi_apbdes_danaModalLabel">Form Edit Rekap Realisasi APBDes Per SumberDana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <form action="page/pelaporan/rekap_sumberdana/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_realisasi_apbdes_dana" id="id_realisasi_apbdes_dana">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
          <label for="realisasi_apbdes_dana">File Rekap Realisasi APBDes Per SumberDana</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="realisasi_apbdes_dana" id="realisasi_apbdes_danaid" onchange="return validasiFile()"/>
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
    $('#edit_realisasi_apbdes_danaModal').modal();
    var id_realisasi_apbdes_dana = $(this).attr('data-id_realisasi_apbdes_dana')
    var realisasi_apbdes_dana = $(this).attr('data-realisasi_apbdes_dana')
    var id_user = $(this).attr('data-iduser')
    var tahun = $(this).attr('data-tahun')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#id_realisasi_apbdes_dana').val(id_realisasi_apbdes_dana)
    $('#realisasi_apbdes_danaid').val(realisasi_apbdes_dana)
    $('#iduser').val(id_user)
    $('#tahun').val(tahun)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>

<script type="text/javascript">
var uploadField = document.getElementById("realisasi_apbdes_danaid");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('realisasi_apbdes_danaid');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.pdf|\.xlsx|\.xls|\.doc|\.docx)$/i;
        if(!ekstensiOk.exec(pathFile)){
            alert('Silahkan upload file yang memiliki ekstensi .pdf.xlxs.docx');
            inputFile.value = '';
            return false;
        }
    };
</script>

<!-- Modal validasi realisasi_apbdes_dana -->
<div class="modal fade" id="realisasi_apbdes_danaModal" tabindex="-1" aria-labelledby="realisasi_apbdes_danaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="realisasi_apbdes_danaModalLabel">Form Validasi Rekap Realisasi APBDes Per SumberDana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>  
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/rekap_sumberdana/validasi.php">
          <input type="hidden" name="id_realisasi_apbdes_dana" id="idrealisasi_apbdes_dana">
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
    $('#realisasi_apbdes_danaModal').modal();
    var id_realisasi_apbdes_dana = $(this).attr('data-idrealisasi_apbdes_dana')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#idrealisasi_apbdes_dana').val(id_realisasi_apbdes_dana)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>