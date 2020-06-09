<!DOCTYPE html>
<html>

<!-- Head PHP -->
<?php $this->load->view('user/_partials/header.php'); ?>
<!-- Custom Helper -->

<body>
<!-- Sidenav PHP-->
<?php $this->load->view('user/_partials/sidenav.php'); ?>
<!-- Main content -->
<div class="main-content" id="panel">
	<!-- Topnav PHP-->
	<?php $this->load->view('user/_partials/topnav.php');
	?>
	<!-- Header -->
	<!-- BreadCrumb PHP -->
	<?php $this->load->view('user/_partials/breadcrumb.php');
	?>
	<!-- Page content -->
	<div class="container-fluid mt--6">
		<!-- Export -->
		<!-- Table -->
		<div class="row">
			<div class="col">
				<div class="card">
					<!-- Card header -->
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">Jadwal Seminar</h3>
								<p class="text-sm mb-0">
									Berikut daftar jadwal seminar
								</p>
							</div>
						</div>
					</div>
					<div class="table-responsive py-4">
						<table class="table table-flush" id="datatable-magang">
							<thead class="thead-light">
							<tr role="row">
								<th>No</th>
								<th>NIM</th>
								<th>Nama Mahasiswa</th>
								<th>Judul</th>
                                <th>Perusahaan</th>
                                <th>Ruangan</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>No</th>
								<th>NIM</th>
								<th>Nama Mahasiswa</th>
								<th>Judul</th>
                                <th>Perusahaan</th>
                                <th>Ruangan</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
							</tr>
							</tfoot>
							<tbody>
							<?php foreach ($sempes as $key => $sempe): ?>
								<tr role="row" class="odd">
									<td class="sorting_1"><?php echo $key + 1 ?></td>
									<td><?php echo $sempe->nim ?></td>
									<td><?php echo $sempe->nama_mahasiswa ?></td>
									<td><?php echo $sempe->judul_laporan_mhs ?></td>
                                    <td><?php echo $sempe->nama_perusahaan ?></td>
                                    <td><?php echo $sempe->nama ?></td>
                                    <td><?php echo $sempe->mulai ?></td>
                                    <td><?php echo $sempe->berakhir ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer PHP -->
		<?php $this->load->view('user/_partials/footer.php'); ?>
	</div>

</div>
<!-- Scripts PHP-->
<?php $this->load->view('user/_partials/modal.php'); ?>
<?php $this->load->view('user/_partials/loading.php'); ?>
<?php $this->load->view('user/_partials/js.php'); ?>
<script src="<?php echo base_url('aset/vendor/js-xlsx/dist/xlsx.full.min.js') ?>"></script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
