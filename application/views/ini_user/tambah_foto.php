      <div class="layout-content">
        <div class="layout-content-body">
          <div class="row gutter-xs">
            <div class="col-xs-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                    <button type="button" class="card-action card-reload" title="Reload"></button>
                  </div>
                  <h5><strong><?php echo $form_nama;?></strong></h5>
                </div>
                <div class="card-body">
                <form data-toggle="md-validator"  method="POST" action="<?php echo base_url('users/foto/add_foto')?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Name Foto</label>
                        <input class="form-control" type="text" name="nama_foto" required>  
                      </div>
                      <div class="form-group label-floating">
                        <label class="control-label">Deskripsi Foto</label>
                        <input class="form-control" type="text" name="deskripsi_foto" required>  
                      </div>
                      <div class="form-group label-floating">
                        <label class="control-label">Konten</label>
                        <input class="form-control" type="file" name="file" required>
                      </div>
                      <div class="form-group label-floating">
                        <button type="submit" class="btn btn-primary btn-block" name="Upload">Ubah</button>
                      </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>