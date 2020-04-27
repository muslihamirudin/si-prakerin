<!DOCTYPE html>
<html>
<!-- Head PHP -->
<?php $this->load->view('user/_partials/header.php'); ?>
<body class="g-sidenav-hidden">
<!-- Sidenav PHP-->
<?php $this->load->view('user/_partials/sidenav.php'); ?>
<!-- Main content -->
<div class="main-content" id="panel">
	<!-- Topnav PHP-->
	<?php $this->load->view('user/_partials/topnav.php');
	?>
	<!-- Header -->
	<!-- BreadCrumb PHP -->
	<?php $this->load->view('user/_partials/breadcrumb.php'); ?>
	<!-- Page content -->
	<div class="container-fluid mt--6" data-step="1"
		 data-intro="Selamat datang di SIMP (Sistem Informasi Manajemen Prakerin)!">
		<div class="row">
			<div class="col-xl-4">
				<!-- Members list group card -->
				<?php foreach ($menus as $menu): ?>
					<div class="row">
						<div class="col-xl-12 col-lg-12">
							<div class="card card-stats mb-4 mb-xl-2" data-step="<?php echo $menu['step_intro'] ?>"
								 data-intro="<?php echo $menu['message_intro'] ?>">
								<a href="<?php echo $menu['href'] ?>">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<h5 class="card-title text-uppercase text-muted mb-0"><?php echo $this->session->userdata('level') ?></h5>
												<span
													class="h2 font-weight-bold mb-0"><?php echo $menu['name'] ?></span>
											</div>
											<div class="col-auto">
												<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
													<i class="<?php echo $menu['icon'] ?>"></i>
												</div>
											</div>
										</div>
										<p class="mt-3 mb-0 text-muted text-sm">
											<span class="text-wrap"><?php echo $menu['desc'] ?></span>
										</p>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-xl-8">
				<div class="card">
					<div class="card-header"><h3>Pengingatmu</h3></div>
					<div class="card-body">
					</div>
				</div>
				<div class="card">
					<div class="card-header"><h3>Informasimu</h3></div>
					<div class="card-body">
						<?php if(isset($informasi)): ?>
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong>Informasi</strong>
								<h5><?php echo $informasi->pesan ?> <a href="<?php echo $informasi->uri ?>"><b>Klik disini untuk mengisi</b></a></h5>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
	
		</div>
		<div class="row">
			<div class="col-xl-4"></div>
			<div class="col-xl-8">
				<!-- Checklist -->
				<div class="card" data-step="4"
					 data-intro="Tampilan ini merupakan daftar bimbingan terakhir anda. Bimbingan anda akan di konfirmasi terlebih dahulu oleh dosen pembimbing. Perlu anda ketahui bahwa setidaknya 4 kali bimbingan valid (terkonfirmasi) untuk bisa mengajukan sidang Prakerin">
					<!-- Card header -->
					<div class="card-header">
						<!-- Title -->
						<?php $level = $this->session->userdata('level'); ?>
						<?php if ($level === 'mahasiswa') : //mahasiswa?>
							<h5 class="h3 mb-0">Bimbinganmu</h5>
						<?php else: //dosen?>
							<h5 class="h3 mb-0">Daftar Mahasiswa Bimbingan</h5>
						<?php endif; ?>
					</div>
					<!-- Card body -->
					<div class="card-body p-0">
						<!-- List group -->
						<?php if ($level === 'mahasiswa') : //mahasiswa?>
							<p class="text-center text-sm">Berikut daftar bimbingan terakhirmu</p>
							<div id="div-mode-bimbingan" class="text-md-center text-warning font-weight-bold"></div>
							<?php if (isset($latest_bimbingan)): ?>
								<?php if (count($latest_bimbingan) == 0) : ?>
									<div class="alert alert-primary alert-dismissible fade show m-3" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											<span class="sr-only">Close</span>
										</button>
										<strong>Informasi</strong> Kalian bisa mengajukan sidang
										setelah <?php echo isset($latest_bimbingan) ? 4 - count($latest_bimbingan) : 0 ?>
										konsultasi
										lagi. <br>
										<small>Kalian harus konsultasi minimal <b>4 Kali</b> untuk bisa mengajukan
											sidang</small>
									</div>
								<?php endif; ?>
								<div style="max-height: 400px;overflow-x: scroll;-ms-overflow-x: scroll">
									<ul class="list-group list-group-flush" data-toggle="checklist">
										<?php foreach ($latest_bimbingan as $bimbingan): ?>
											<li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
												<div
													class="checklist-item checklist-item-<?php echo substr($bimbingan->tag, 3) ?> checklist-item-checked">
													<div class="checklist-info">
														<h5 class="checklist-title mb-0"><?php echo $bimbingan->title ?></h5>
														<small><?php echo $bimbingan->start ?></small>
														<small
															class="text-<?php echo $bimbingan->status !== null ? ($bimbingan->status == 'accept' ? 'success' : 'red') : 'warning' ?>"><b><?php echo $bimbingan->status !== null ? ($bimbingan->status == 'accept' ? 'Konsultasi Dikonfirmasi' : 'Konsultasi Ditolak') : 'Belum dikonsultasikan' ?></b></small>
													</div>
													<div>
														<div
															class="custom-control custom-checkbox custom-checkbox-success">
															<input class="custom-control-input" id="chk-todo-task-1"
																   disabled
																   type="checkbox" <?php echo $bimbingan->status !== NULL ? "checked" : null ?>>
															<label class="custom-control-label"
																   for="chk-todo-task-1"></label>
														</div>
													</div>
												</div>
											</li>
										<?php endforeach; ?>
										<?php if (count($latest_bimbingan) == 0 and count($get_pembimbing) == 0) : ?>
											<li class="list-group-item"><p class="h3">Anda belum mempunyai
													pembimbing</p>
											</li>
										<?php elseif (count($latest_bimbingan) == 0 and count($get_pembimbing) != 0) : ?>
											<li id="belum-konsultasi" class="list-group-item"><p class="h3">Belum
													mengajukan konsultasi</p>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							<?php else: ?>
								<div id="belum-konsultasi" class="p-3"><p class="text-center text-lg">
										Belum mengajukan konsultasi</p></div>
							<?php endif; ?>
						<?php elseif ($level === 'dosen') : //dosen?>
							<?php if (isset($all_latest_bimbingan)): ?>
								<div style="max-height: 400px;overflow-x: scroll;-ms-overflow-x: scroll">
									<ul class="list-group list-group-flush" data-toggle="checklist">
										<?php foreach ($all_latest_bimbingan as $all_bimbingan): ?>
											<li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
												<div
													class="checklist-item checklist-item-<?php echo substr($all_bimbingan->tag, 3) ?> checklist-item-checked">
													<div class="checklist-info">
														<h5 class="checklist-title mb-0"><?php echo $all_bimbingan->title ?></h5>
														<small><?php echo $all_bimbingan->start ?></small>
														<small
															class="text-<?php echo $all_bimbingan->status !== null ? ($all_bimbingan->status == 'accept' ? 'success' : 'red') : 'warning' ?>"><b><?php echo $all_bimbingan->status !== null ? ($all_bimbingan->status == 'accept' ? 'Konsultasi Dikonfirmasi' : 'Konsultasi Ditolak') : 'Belum dikonsultasikan' ?></b></small>
													</div>
													<div>
														<h4 class="font-weight-400">Mahasiswa:
															<b><?php echo $all_bimbingan->nama_mahasiswa ?></b></h4>
													</div>
													<div>
														<div
															class="custom-control custom-checkbox custom-checkbox-success">
															<input class="custom-control-input" id="chk-todo-task-1"
																   disabled
																   type="checkbox" <?php echo $all_bimbingan->status !== NULL ? "checked" : null ?>>
															<label class="custom-control-label"
																   for="chk-todo-task-1"></label>
														</div>
													</div>
												</div>
											</li>
										<?php endforeach; ?>
										<?php if (count($all_latest_bimbingan) == 0) : ?>
											<li id="belum-konsultasi" class="list-group-item"><p class="h3">Belum
													mengajukan konsultasi</p>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('user/_partials/footer'); ?>
	</div>

</div>
<!-- Scripts PHP-->
<?php $this->load->view('user/_partials/modal.php'); ?>
<?php $this->load->view('user/_partials/js.php'); ?>
<script>
	$(document).ready(function () {
		if (!localStorage.getItem('wizard')) {
			introJs().start().oncomplete(function () {
				localStorage.setItem('wizard', 'yes')
			}).onexit(function () {
				localStorage.setItem('wizard', 'yes')
			})
		}
		<?php if ($level === 'mahasiswa'): ?>
		let checkBimbingan = $.ajax({
			url: '<?php echo site_url("ajax/check_bimbingan")?>',
			method: "GET",
			dataType: 'json',
			async: false
		}).done(function (res) {
			return res
		});
		let resJson = checkBimbingan.responseJSON;
		if (resJson.data.mode === 'offline') {
			$('#belum-konsultasi').remove();
			$('#div-mode-bimbingan').append('Anda sedang melakukan bimbingan offline')
		}
		<?php endif ?>
	})
</script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
