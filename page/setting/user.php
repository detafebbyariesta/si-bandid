<h1 class="h3 mb-4 text-gray-800">Halaman User</h1>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_userModal">Tambah</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="bg-dark text-white">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Desa</th>
            <th class="text-center">Username</th>
            <th class="text-center">Level</th>
            <th width="18%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "asset/inc/config.php";
            // jalankan query untuk menampilkan semua data diurutkan berdasarkan nim
            $query = "SELECT * FROM tb_user ORDER BY id_user ASC";
            $result = mysqli_query($koneksi, $query);
            //mengecek apakah ada error ketika menjalankan query
            if(!$result){
              die ("Query Error: ".mysqli_errno($koneksi).
                 " - ".mysqli_error($koneksi));
            }

            //buat perulangan untuk element tabel dari data rpjmdes
            $no = 1; //variabel untuk membuat nomor urut
            // hasil query akan disimpan dalam variabel $data dalam bentuk array
            // kemudian dicetak dengan perulangan while
            while($data = mysqli_fetch_assoc($result))
            {
            ?>
          <tr>
            <td class="text-center"><?php echo "$no"; ?></td>
            <td><?php echo $data['nama_user']; ?></td>
            <td><?php echo $data['username']; ?></td>
            <td><?php echo $data['level']; ?></td>
            <td>
              <a href="#" class="btn btn-sm btn-info edit" data-toggle="modal" data-target="#edit_userModal"
              data-iduser="<?php echo $data['id_user']; ?>"
              data-username="<?php echo $data['username']; ?>"
              data-password="<?php echo $data['password']; ?>"
              data-nmuser="<?php echo $data['nama_user']; ?>"
              data-level="<?php echo $data['level']; ?>"><i class="fas fa-edit"></i> edit</a>

              <a href="page/setting/hapus.php?id_user=<?php echo $data['id_user'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> delete</a>
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


<!-- Modal add user -->
<div class="modal fade" id="add_userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/setting/tambah.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" name="desa" id="desa" placeholder="Nama Desa">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="level">Level</label>
            <select class="form-control" name="level" id="level">
              <option>-- Pilih --</option>
              <option value="User">User</option>
              <option value="Admin">Admin</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="submit">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal edit user -->
<div class="modal fade" id="edit_userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="page/setting/edit.php" method="post">
          <input type="hidden" name="id_user" id="iduser">
          <div class="form-group">
            <input type="text" class="form-control" name="nama_user" id="nmuser">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="username" id="usernm">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary" name="edit">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="asset/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $('.edit').click(function(){
    $('#edit_userModal').modal();
    var id_user = $(this).attr('data-iduser')
    var username = $(this).attr('data-username')
    var password = $(this).attr('data-password')
    var nama_user = $(this).attr('data-nmuser')
    var level = $(this).attr('data-level')

    $('#iduser').val(id_user)
    $('#usernm').val(username)
    $('#password').val(password)
    $('#nmuser').val(nama_user)
    $('#level').val(level)
  })
</script>

<!-- Modal validasi user -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Form Validasi User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Validasi</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option>-- Pilih --</option>
              <option value="Revisi">Revisi</option>
              <option value="Diterima">Diterima</option>
            </select>
          </div>
          <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea class="form-control" id="catatan" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>