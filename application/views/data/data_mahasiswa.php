<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?= $this->session->flashdata('message'); ?>

<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newsiswaModal">Tambah data mahasiswa</a>



<!-- dosen: Table List -->
<div class="table-responsive">
  <table id="datatable-datasiswa" class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">NIM</th>
        <th scope="col">Nama mahasiswa</th>
        <th scope="col">Prodi</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  </div>

</div>

<!-- Modal: Tambah -->
<div class="modal fade" id="newsiswaModal" tabindex="-1" role="dialog" aria-labelledby="newsiswaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newsiswaModalLabel">Tambah data mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAddsiswa" action="<?= site_url('data/datasiswa') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="o_nim">NIM</label>
            <input type="text" class="form-control" id="o_nim" name="nim" required>
            <small class="text-danger pl-1" id="err_o_nim"></small>
          </div>
          <div class="form-group">
            <label for="o_nama_siswa">Nama mahasiswa</label>
            <input type="text" class="form-control" id="o_nama_siswa" name="nama" required>
            <small class="text-danger pl-1" id="err_o_nama_siswa"></small>
          </div>
          <div class="form-group">
            <label for="o_prodi_id">Prodi</label>
            <select class="form-control" id="o_prodi_id" name="prodi_id" required>
              <option value="">-- Pilih Prodi --</option>
              <?php
                if (isset($prodi_list) && is_array($prodi_list)) {
                  foreach ($prodi_list as $p) {
                    echo '<option value="'.htmlspecialchars($p['id_prodi']).'">'.htmlspecialchars($p['nama_prodi']).'</option>';
                  }
                }
              ?>
            </select>
            <small class="text-danger pl-1" id="err_o_prodi_id"></small>
          </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal: Edit Prodi -->
    <div class="modal fade" id="editsiswaModal" tabindex="-1" role="dialog" aria-labelledby="editsiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editsiswaModalLabel">Edit Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formEditSiswa" action="<?= site_url('data/updatemahasiswa') ?>" method="post">
            <input type="hidden" name="id_mahasiswa" id="e_id_siswa">
            <div class="modal-body">
            <div class="form-group">
                <label for="e_nim">NIM</label>
                <input type="text" class="form-control" id="e_nim" name="nim" required>
                <small class="text-danger pl-1" id="err_e_nim"></small>
            </div>
            <div class="form-group">
                <label for="e_nama_siswa">Nama mahasiswa</label>
                <input type="text" class="form-control" id="e_nama_siswa" name="nama" required>
                <small class="text-danger pl-1" id="err_e_nama_siswa"></small>
            </div>
            <div class="form-group">
                <label for="e_prodi_id">Prodi</label>
                <select class="form-control" id="e_prodi_id" name="prodi_id" required>
                  <option value="">-- Pilih Prodi --</option>
                  <?php
                    if (isset($prodi_list) && is_array($prodi_list)) {
                      foreach ($prodi_list as $p) {
                        echo '<option value="'.htmlspecialchars($p['id_prodi']).'">'.htmlspecialchars($p['nama_prodi']).'</option>';
                      }
                    }
                  ?>
                </select>
                <small class="text-danger pl-1" id="err_e_prodi_id"></small>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    </div>
