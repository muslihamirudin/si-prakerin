<!DOCTYPE html>
<html>
<!-- Head PHP -->
<?php  $this->load->view('admin/_partials/header.php');
$pegawais = isset($pegawais)?$pegawais:array();
$mahasiswas = isset($mahasiswas)?$mahasiswas:array();
$pesertas = isset($pesertas)?$pesertas:array();
$akuns = array_merge($pegawais,$mahasiswas,$pesertas);

?>

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
		<!-- Table -->
		<div class="row">
			<div class="col">
				<div class="card">
					<!-- Card header -->
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">Akun</h3>
								<p class="text-sm mb-0">
									Kelola akun user dan level dari user.
								</p>
							</div>
							<div class="col-4 text-right">
								<a href="<?php echo site_url('akun/tambah') ?>"
								   class="btn btn-sm btn-primary">Tambah Akun</a>
							</div>
						</div>
					</div>
					<div class="table-responsive py-4">
						<table class="table table-flush" id="datatable-buttons">
							<thead class="thead-light">
							<tr role="row">
								<th style="width:30px">Aksi</th>
								<th>No</th>
								<th>Username</th>
								<th>Nama</th>
								<th>Level</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th style="width:30px">Aksi</th>
								<th>No</th>
								<th>Username</th>
								<th>Nama</th>
								<th>Level</th>
							</tr>
							</tfoot>
							<tbody>
							<?php foreach ($akuns as $key => $akun): ?>
								<tr role="row" class="odd">
									<td>
										<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
											<a class="dropdown-item" href="<?php echo site_url('akun/edit/'.$akun->id) ?>">Edit</a>
											<a class="dropdown-item" href="#" onclick="deleteConfirm('<?php echo site_url('akun/hapus_akun/'.$akun->id) ?>')">Hapus Akun</a>
										</div>
									</td>
									<td class="sorting_1"><?php echo $key +1?></td>
									<td><?php echo $akun->username?></td>
									<td><?php echo $akun->nama?></td>
									<td><?php echo $akun->level?></td>
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

<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
