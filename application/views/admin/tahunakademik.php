<!DOCTYPE html>
<html>

<!-- Head PHP -->
<?php  $this->load->view('admin/_partials/header.php');?>
<?php $currentTahunAkademik = getCurrentTahun()?>

<body>
	<!-- Sidenav PHP-->
	<?php $this->load->view('admin/_partials/sidenav.php');?>
	<!-- Main content -->
	<div class="main-content" id="panel">
		<!-- Topnav PHP-->
		<?php $this->load->view('admin/_partials/topnav.php');
         ?>
		<!-- Header -->
		<!-- BreadCrumb PHP -->
		<?php $this->load->view('admin/_partials/breadcrumb.php');
         ?>
		<!-- Page content -->
		<div class="container-fluid mt--6">
			<!-- Setting Tahun Akademik -->
			<div class="row">

			</div>
			<!-- Table -->
			<div class="row">
				<div class="col-md-3 col-lg-md-3 col-sm-12 col-xs-12">
					<div class="card">
						<div class="card-header">
							<h3>Atur Tahun Akademik</h3>
						</div>
						<div class="card-body">
							<p class="text-sm mb-0">Tahun akademik saat ini :</p>
							<h2><?php echo isset($currentTahunAkademik->now)?$currentTahunAkademik->now:"Belum di Atur" ?></h2>
							<span>
								<h4>Atur</h4>
							</span>
							<span>
								<label class="custom-toggle" id="checkboxAturTahun">
									<input type="checkbox">
									<span class="custom-toggle-slider rounded-circle"></span>
								</label>
							</span>

							<form action="<?php echo site_url('tahunakademik/set') ?>" method="POST">
								<div class="form-group">
									<input type="hidden" name="id" value="<?php echo isset($currentTahunAkademik->id)?$currentTahunAkademik->id:"" ?>">
									<label class="form-control-label" for="tahun_akademik">Tentukan Tahun
										Akademik</label>
									<select class="form-control" disabled name="id_tahun_akademik" id="select_tahun_akademik">
										<?php foreach ($tahunakademiks as $tahun): ?>
										<option value="<?php echo $tahun->id_tahun_akademik ?>">
											<?php echo $tahun->tahun_akademik ?></option>
										<?php endforeach; ?>
									</select>
									<div class="text-md-right align-content-end mt-3 mb--4">
										<button disabled id="btn_atur_tahun" type="submit" class="btn btn-success">Simpan</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-9 col-lg-md-9 col-sm-12 col-xs-12">
					<div class="card">
						<!-- Card header -->
						<div class="card-header">
							<div class="row align-items-center">
								<div class="col-8">
									<h3 class="mb-0">Tahun Akademik</h3>
									<p class="text-sm mb-0">
										Berikut Merupakan Data Tahun Akademik. Admin dapat menambahkannya pada tombol "Add Tahun Akademik"
									</p>
								</div>
								<div class="col-4 text-right">
									<a href="<?php echo site_url('tahunakademik/create') ?>"
										class="btn btn-sm btn-primary">Add Tahun Akademik</a>
								</div>
							</div>
						</div>
						<div class="table-responsive py-4">
							<table class="table table-flush" id="datatable-buttons">
								<thead class="thead-light">
									<tr role="row">
										<th style="width:30px">Aksi</th>
										<th>No</th>
										<th>ID</th>
										<th>Tahun Akademik</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th style="width:30px">Aksi</th>
										<th>No</th>
										<th>ID</th>
										<th>Tahun Akademik</th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach ($tahunakademiks as $key => $tahunakademik): ?>
									<tr role="row" class="odd">
										<td>
											<a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
												data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
												<a class="dropdown-item"
													href="<?php echo site_url('tahunakademik/edit/'.$tahunakademik->id_tahun_akademik) ?>">Edit</a>
												<a class="dropdown-item" href="#"
													onclick="deleteConfirm('<?php echo site_url('tahunakademik/remove/'.$tahunakademik->id_tahun_akademik) ?>')">Hapus</a>
											</div>
										</td>
										<td class="sorting_1"><?php echo $key +1?></td>
										<td><?php echo $tahunakademik->id_tahun_akademik?></td>
										<td><?php echo $tahunakademik->tahun_akademik?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer PHP -->
			<?php $this->load->view('admin/_partials/footer.php');?>
		</div>

	</div>
	<!-- Scripts PHP-->
	<?php $this->load->view('admin/_partials/modal.php');?>
	<?php $this->load->view('admin/_partials/js.php');?>
	<!-- custom script -->
	<script>
		$('#checkboxAturTahun :checkbox').change(function () {
			// this will contain a reference to the checkbox   
			if (this.checked) {
				$('#select_tahun_akademik').prop('disabled',false)
				$('#btn_atur_tahun').prop('disabled',false)
				// the checkbox is now checked 
			} else {
				$('#select_tahun_akademik').prop('disabled',true)
				$('#btn_atur_tahun').prop('disabled',true)
				// the checkbox is now no longer checked
			}
		});

	</script>
	<!-- Demo JS - remove this in your project -->
	<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
