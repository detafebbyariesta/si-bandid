<div class="row">
  <div class="col-4 offset-4">
    <div class="card">
      <div class="card-header">
        Profile
      </div>
      <div class="card-body">
        <div class="text-center">
          <img src="asset/img/logo_demak.png" width="30%" alt="Logo">
        </div><hr class="mb-0">
      </div>
      <table class="ml-4 mb-4">
        <tr>
          <td>Kecamatan</td>
          <td>:</td>
          <td>Mranggen</td>
        </tr>
        <tr>
          <td>Desa</td>
          <td>:</td>
          <td><?= $_SESSION['nama_user']; ?></td>
        </tr>
        <tr>
          <td>Level</td>
          <td>:</td>
          <td>
            <?php 
            $level = $_SESSION['level'];
            if ($level == "user") {
              echo "User";
            } else {
              echo "Administrator";
            }
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>