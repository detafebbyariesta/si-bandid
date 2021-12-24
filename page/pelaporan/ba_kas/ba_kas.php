<h1 class="h3 mb-4 text-gray-800">Halaman Berita Acara Pemeriksaan Kas</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_ba_kasModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th width="3%" class="text-center align-middle">No</th>
            <th width="5%" class="text-center  align-middle">Desa</th>
            <th class="text-center  align-middle">Berita Acara Pemeriksaan Kas</th>
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
             $query = "SELECT * FROM tb_ba_kas
                      INNER JOIN tb_user ON tb_ba_kas.id_user = tb_user.id_user AND tahun='$tahun' ORDER BY id_ba_kas DESC";
            $result = mysqli_query($koneksi, $query);
          }
          if ($_SESSION['level']=="user") {
            $id_user = $_SESSION['id_user'];
            $query= "SELECT * FROM tb_ba_kas
                      INNER JOIN tb_user ON tb_ba_kas.id_user = tb_user.id_user AND tb_ba_kas.id_user=$id_user AND tahun='$tahun' ORDER BY id_ba_kas DESC";
            $result = mysqli_query($koneksi, $query);
          }  
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }
            //buat perulangan untuk element tabel dari data ba_kas
            $no = 1;
            while($data = mysqli_fetch_assoc($result))
            {
            ?>      
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <!-- Bisa di download untuk di koreksi, muncul link jika user sudah login jika belum login jangan tampilkan linknya-->
            <td>
              <a href="page/pelaporan/ba_kas/file/ba_kas/<?php echo $data['ba_kas']; ?>">
              <i class="fas fa-download" id="downloadba_kas">&nbsp;&nbsp;</i></a><?php echo $data['ba_kas']; ?>
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
                 echo ''?> <a href="#" class="btn btn-sm btn-success validasi" data-toggle="modal" data-target="#validasi_ba_kasModal"
                      data-idba_kas="<?php echo $data["id_ba_kas"];?>"
                      data-validasi="<?php echo $data["validasi"];?>"
                      data-catatan="<?php echo $data["catatan"];?>"
                      ><i class="fas fa-check"></i> validasi</a>
                <?php  ;
                }else{
                 echo '';
                }
               ?>

              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_ba_kasModal"
              data-id_ba_kas="<?php echo $data['id_ba_kas'];?>"
              data-ba_kas="<?php echo $data['ba_kas'];?>"
              data-bulan="<?php echo $data['bulan'];?>"
              ><i class="fas fa-edit"></i> edit</a>

              <a href="page/pelaporan/ba_kas/hapus.php?id_ba_kas=<?php echo $data['id_ba_kas'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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
<div class="modal fade" id="add_ba_kasModal" tabindex="-1" aria-labelledby="ba_kasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ba_kasModalLabel">Form Add BA Pemeriksaan Kas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/ba_kas/tambah.php" enctype="multipart/form-data" >
          <input type="hidden" name="valid" id="valid" value="Menunggu Validasi">
          <input type="hidden" name="id_user" id="iduser" value="<?= $_SESSION['id_user']; ?>">
          <input type="hidden" name="tahun" id="tahun" value="<?= date("Y"); ?>">
          <div class="form-group">
            <label for="">BA Pemeriksaan Kas</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="ba_kas" name="ba_kas" required="" onchange="return validasiFile()"/>
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
var uploadField = document.getElementById("ba_kas");
uploadField.onchange = function() {
    if(this.files[0].size > 5000000){ // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
       alert("Maaf. File Terlalu Besar ! Maksimal Upload 5 MB");
       this.value = "";
    };
        var inputFile = document.getElementById('ba_kas');
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
<div class="modal fade" id="edit_ba_kasModal" tabindex="-1" aria-labelledby="ba_kasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ba_kasModalLabel">Form Edit BA Pemeriksaan Kas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/pelaporan/ba_kas/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_ba_kas" id="id_blnn">
          <input type="hidden" name="validasi" value="Menunggu Revisi Divalidasi">
          <input type="hidden" name="catatan">
          <div class="form-group">
            <label for="">BA Pemeriksaan Kas</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="ba_kas" id="blnn"  onchange="return validasiFile()"/>
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
    $('#edit_ba_kasModal').modal();
    var id_ba_kas = $(this).attr('data-id_ba_kas')
    var ba_kas = $(this).attr('data-ba_kas')
    var bulan = $(this).attr('data-bulan')
    var id_user = $(this).attr('data-iduser')

    $('#id_blnn').val(id_ba_kas)
    $('#blnn').val(ba_kas)
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
<div class="modal fade" id="validasi_ba_kasModal" tabindex="-1" aria-labelledby="ba_kasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ba_kasModalLabel">Form Validasi BA Pemeriksaan Kas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="page/pelaporan/ba_kas/validasi.php">
          <input type="hidden" name="id_ba_kas" id="idba_kas">
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
    $('#validasi_ba_kasModal').modal();
    var id_ba_kas = $(this).attr('data-idba_kas')
    var validasi = $(this).attr('data-validasi')
    var catatan = $(this).attr('data-catatan')
    $('#idba_kas').val(id_ba_kas)
    $('#validasi').val(validasi)
    $('#catatan').val(catatan)
  })
</script>