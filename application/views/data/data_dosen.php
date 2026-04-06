<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

<?= $this->session->flashdata('message'); ?>

<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newDosenModal">Tambah data dosen</a>



<!-- dosen: Table List -->
<div class="table-responsive">
  <table id="datatable-datados" class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">NIDN</th>
        <th scope="col">Nama dosen</th>
        <th scope="col">Gelar</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  </div>

</div>

<!-- Modal: Tambah -->
<div class="modal fade" id="newDosenModal" tabindex="-1" role="dialog" aria-labelledby="newDosenLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newDosenLabel">Tambah data dosen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAddDosen">
        <div class="modal-body">
          <div class="form-group">
            <label for="o_nidn">NIDN</label>
            <input type="text" class="form-control" id="o_nidn" name="nidn" required>
            <small class="text-danger pl-1" id="err_o_nidn"></small>
          </div>
          <div class="form-group">
            <label for="o_nama_dos">Nama dosen</label>
            <input type="text" class="form-control" id="o_nama_dos" name="nama_dos" required>
            <small class="text-danger pl-1" id="err_o_nama_dos"></small>
          </div>
          <div class="form-group">
            <label for="o_gelar">Gelar</label>
            <input type="text" class="form-control" id="o_gelar" name="gelar" required>
            <small class="text-danger pl-1" id="err_o_gelar"></small>
          </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-simpan-dosen">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal: Edit Prodi -->
    <div class="modal fade" id="editdosModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Dosen</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formEditDos">
                <input type="hidden" name="e_id_dosen" id="e_id_dosen">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIDN</label>
                        <input type="text" class="form-control" name="e_nidn" id="e_nidn" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Dosen</label>
                        <input type="text" class="form-control" name="e_nama_dos" id="e_nama_dos" required>
                    </div>
                    <div class="form-group">
                        <label>Gelar</label>
                        <input type="text" class="form-control" name="e_gelar" id="e_gelar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-update-dosen">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>