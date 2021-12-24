<h1 class="h3 mb-4 text-gray-800">Halaman Backup & Restore Database</h1>
<div class="card shadow mb-4">
  <!-- <div class="card-header py-3"></div> -->
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="backup-tab" data-toggle="tab" href="#backup" role="tab" aria-controls="backup" aria-selected="true">Backup</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="restore-tab" data-toggle="tab" href="#restore" role="tab" aria-controls="restore" aria-selected="false">Restore</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="backup" role="tabpanel" aria-labelledby="backup-tab">
        <div class="my-4">
          <p><b>Backup</b> semua data yang ada didalam database.</p>
           <form class="" method="post" action="./page/setting/proses_backup.php">
              <button type="submit" class="btn tbn-sm btn-info" name="backup">Start Backup</button>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="restore" role="tabpanel" aria-labelledby="restore-tab">
        <div class="my-4">
          <p><b>Restore</b> semua data yang ada didalam database.</p>
          <!-- <p>File Backup Database (*.sql)</p> -->
          <form action="./page/setting/proses_restore.php" method="post">
            <!-- <div class="form-row">
              <div class="form-group col-6">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
            </div> -->
            <button type="submit" class="btn tbn-sm btn-success" name="restore">Start Restore</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>