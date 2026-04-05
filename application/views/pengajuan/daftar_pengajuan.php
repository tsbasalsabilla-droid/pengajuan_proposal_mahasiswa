  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

  <?= $this->session->flashdata('message'); ?>


  <!-- dosen: Table List -->
  <div class="table-responsive">
    <table id="datatable-daftar" class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">NIM</th>
          <th scope="col">Judul</th>
          <th scope="col">Link</th>
          <th scope="col">Dosen 1</th>
          <th scope="col">Dosen 2</th>
          <th scope="col">Dosen 3</th>
          <th scope="col">Status</th>
          <th scope="col">Tanggal pengajuan</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>

  <!-- Modal: Edit Prodi -->
      <div class="modal fade" id="editdaftarModal" tabindex="-1" role="dialog" aria-labelledby="editdaftarModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editdaftarModalLabel">Edit Daftar Pengajuan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form id="formEditdaftar" action="<?= site_url('pengajuan/daftar') ?>" method="post">
              <input type="hidden" name="id" id="e_id">
              <div class="modal-body">
              <div class="form-group">
                  <label for="e_nim">NIM</label>
                  <input type="text" class="form-control" id="e_nim" name="nim" required>
                  <small class="text-danger pl-1" id="err_e_nim"></small>
              </div>
              <div class="form-group">
                  <label for="e_judul">Judul</label>
                  <input type="text" class="form-control" id="e_judul" name="judul" required>
                  <small class="text-danger pl-1" id="err_e_judul"></small>
              </div>
              <div class="form-group">
                  <label for="e_link">Link</label>
                  <input type="text" class="form-control" id="e_link" name="link" required>
                  <small class="text-danger pl-1" id="err_e_link"></small>
              </div>
              <div class="form-group">
                  <label for="e_dosen1_id">Dosen 1</label>
                  <select class="form-control" id="e_dosen1_id" name="dosen1_id" required>
                    <option value="">-- Pilih Dosen 1 --</option>
                    <?php
                      if (isset($dosen_list) && is_array($dosen_list)) {
                        foreach ($dosen_list as $d) {
                          echo '<option value="'.htmlspecialchars($d['id_dosen']).'">'.htmlspecialchars($d['nama_dos']).'</option>';
                        }
                      }
                    ?>
                  </select>
                  <small class="text-danger pl-1" id="err_e_dosen1_id"></small>
              </div>
              <div class="form-group">
                  <label for="e_dosen2_id">Dosen 2</label>
                  <select class="form-control" id="e_dosen2_id" name="dosen2_id" required>
                    <option value="">-- Pilih Dosen 2 --</option>
                    <?php
                      if (isset($dosen_list) && is_array($dosen_list)) {
                        foreach ($dosen_list as $d) {
                          echo '<option value="'.htmlspecialchars($d['id_dosen']).'">'.htmlspecialchars($d['nama_dos']).'</option>';
                        }
                      }
                    ?>
                  </select>
                  <small class="text-danger pl-1" id="err_e_dosen2_id"></small>
              </div>
              <div class="form-group">
                  <label for="e_dosen3_id">Dosen 3</label>
                  <select class="form-control" id="e_dosen3_id" name="dosen3_id" required>
                    <option value="">-- Pilih Dosen 3 --</option>
                    <?php
                      if (isset($dosen_list) && is_array($dosen_list)) {
                        foreach ($dosen_list as $d) {
                          echo '<option value="'.htmlspecialchars($d['id_dosen']).'">'.htmlspecialchars($d['nama_dos']).'</option>';
                        }
                      }
                    ?>
                  </select>
                  <small class="text-danger pl-1" id="err_e_dosen3_id"></small>
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
