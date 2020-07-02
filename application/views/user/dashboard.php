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
		 data-intro="Selamat datang di SIMPKL (Sistem Informasi Manajemen Praktik Kerja Lapangan)!">
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
			<div class="col-xl-4">
				<div class="row">
					<div class="col-xl-12 col-lg-12"></div>
				</div>
			</div>
			<div class="col-xl-8">
				
				<div class="card">
					<?php error_reporting(0); ?>
					<?php $level = $this->session->userdata('level'); ?>
					<?php if ($level === 'mahasiswa') : //mahasiswa?>
						<div class="card-header">
							<h5 class="h3 mb-0">Pengingat! | Hari Ini: <?php echo nama_hari(date('Y-m-d')).', '. tgl_indo(date('Y-m-d')); ?></h5>
						</div>
						<div class="card-body">
							<h3 id="titel">Hari Seminar : <?php foreach ($jadwalku as $waktusem): ?>
							<?php echo nama_hari(explode('T',$waktusem->mulai)[0]).', '. tgl_indo(explode('T',$waktusem->mulai)[0]); ?>
							<?php endforeach ?></h3>
						
							</br>
							<h3 id="judcount">Waktu Menuju Seminar :</h3>
							<h1 id="count"></h1>

							<?php $tanggal_mulai= date('Y-m-d',strtotime(explode('T',$waktusem->mulai)[0]));?>
									
							<script>
							//Countdown Waktu Menuju Seminar
							// Set the date we're counting down to
							var countDownDate = new Date('<?= date("m/d/Y", strtotime($tanggal_mulai)); ?>').getTime();

							// Update the count down every 1 second
							var x = setInterval(function() {

							// Get today's date and time
							var now = new Date().getTime();

							// Find the distance between now and the count down date
							var distance = countDownDate - now;

							// Time calculations for days, hours, minutes and seconds
							var days = Math.floor(distance / (1000 * 60 * 60 * 24));
							var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);

							// Display the result in the element with id="demo"
							document.getElementById("count").innerHTML = days + " Hari : " + hours + " Jam : "
							+ minutes + " Menit : " + seconds + " Detik ";
							
							// If the count down is finished, write some text
							if (distance < 0) {
								clearInterval(x);
								$('#titel').hide();
								$('#count').hide();
								$('#judcount').hide();
								// document.getElementById("count").innerHTML = "Expired";
							}
							}, 1000);
							</script>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

<div class="row">
			<div class="col-xl-4">
				<div class="row">
					<div class="col-xl-12 col-lg-12"></div>
				</div>
			</div>
			<div class="col-xl-8">
				
				<div class="card">
					<?php error_reporting(0); ?>
					<?php $level = $this->session->userdata('level'); ?>
					<?php if ($level === 'mahasiswa') : //mahasiswa?>
						<div class="card-header">
							<h5 class="h3 mb-0">Pengingat Revisi</h5>
						</div>
						<div class="card-body">
							<h3 id="titel2">Hari Seminar : <?php foreach ($jadwalku as $waktusem2): ?>
							<?php echo nama_hari(explode('T',$waktusem2->berakhir)[0]).', '. tgl_indo(explode('T',$waktusem2->berakhir)[0]); ?>
							<?php endforeach ?></h3>
						
							</br>
							<h3 id="judcount2">Masa Revisi Anda Berakhir Pada :</h3>
							<h1 id="count2"></h1>
							<?php $tanggal_mulai2= date('Y-m-d', strtotime('+1 days', strtotime(explode('T',$waktusem2->berakhir)[0])));?>
									
							<script>
							//Countdown Waktu Menuju Seminar
							// Set the date we're counting down to
							var countDownDate2 = new Date('<?= date("m/d/Y", strtotime('+7 days', strtotime($tanggal_mulai2))); ?>').getTime();

							// Update the count down every 1 second
							var m = setInterval(function() {

							// Get today's date and time
							var now2 = new Date().getTime();

							// Find the distance between now and the count down date
							var distance2 = countDownDate2 - now2;

							// Time calculations for days, hours, minutes and seconds
							var days2 = Math.floor(distance2 / (1000 * 60 * 60 * 24));
							var hours2 = Math.floor((distance2 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes2 = Math.floor((distance2 % (1000 * 60 * 60)) / (1000 * 60));
							var seconds2 = Math.floor((distance2 % (1000 * 60)) / 1000);

							// Display the result in the element with id="demo"
							document.getElementById("count2").innerHTML = days2 + " Hari : " + hours2 + " Jam : "
							+ minutes2 + " Menit : " + seconds2 + " Detik ";
							
							// If the count down is finished, write some text
							if (distance2 < 0) {
								clearInterval(m);
								document.getElementById("count2").innerHTML = "Revisi Belum Selesai. Segera Selesaikan Revisi Anda!";
								} 
							}, 1000);
						
							</script>
						</div>

						<?php
						$select = 'tb_seminar_penilaian.id_seminar_jadwal, tb_seminar_penilaian.status_revisi, tb_history_seminar_penilaian.tanggal_revisi, tb_history_seminar_penilaian.update_time, COUNT(tb_seminar_penilaian.status_revisi) AS jumber';
						$join = array('tb_history_seminar_penilaian','tb_seminar_penilaian.id = tb_history_seminar_penilaian.id_seminar_penilaian','INNER');
						$where="tb_seminar_penilaian.id_seminar_jadwal='$waktusem->id'";
						$query= datajoin('tb_seminar_penilaian', $where, $select, $join, null);?>
						<?php foreach ($query as $key => $querynya): ?>
							<?php if ($querynya->jumber === '3'): ?>
								<script>
								$('#judcount').hide();
								clearInterval(m);
								document.getElementById("count2").innerHTML = "Revisi Anda Selesai. Silakan Pemberkasan!";
								</script>
								<?php else: ?>
								<h5></h5>
								<?php endif ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-4">
				<div class="row">
					<div class="col-xl-12 col-lg-12"></div>
				</div>
			</div>
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
						<?php elseif ($level === 'dosen'): ?>
							<h5 class="h3 mb-0">Daftar Mahasiswa Bimbingan</h5>
						<?php else: ?>
							<h5 class="h3 mb-0">Pengumuman</h5>
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
												<div class="checklist-item checklist-item-<?php echo substr($bimbingan->tag, 3) ?> checklist-item-checked">
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
										<?php else: ?>
										<div id="belum-konsultasi" class="p-3"><p class="text-center text-lg">
										Belum mengajukan konsultasi</p></div>
										<?php endif; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php elseif ($level === 'dosen') : //dosen?>
								<?php if (isset($all_latest_bimbingan)): ?>
									<div style="max-height: 400px;overflow-x: scroll;-ms-overflow-x: scroll">
										<ul class="list-group list-group-flush" data-toggle="checklist">
											<?php foreach ($all_latest_bimbingan as $all_bimbingan): ?>
												<li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
													<div class="checklist-item checklist-item-<?php echo substr($all_bimbingan->tag, 3) ?> checklist-item-checked">
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

						<?php else : //mahasiswa?>
						<p class="text-center text-sm"></p>
						<div id="div-mode-bimbingan" class="text-md-center text-warning font-weight-bold">
						
						</div>
						
						<div style="max-height: 400px;overflow-x: scroll;-ms-overflow-x: scroll">
						</div>			
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php $level = $this->session->userdata('level'); ?>
		<?php if ($level === 'peserta') : ?>					
		<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="card">
						<?php $lihat = $lihat ? $lihat : array();
						if ($lihat): ?>
						<?php foreach ($lihat as $lihatpes): ?>
						<div class="card-header">
						<h2 class="mb-0">Anda Mengikuti Seminar: <?php echo $lihatpes->jumlah ?> Kali</h2>
						<p class="text-sm mb-0">Berikut Detail Seminar yang Anda Ikuti </p>	
						</div>
						<div class="card-body">	
						<?php
						$select = 'tb_peserta_lihat_seminar.id_lihat, tb_peserta_lihat_seminar.nimpes, tb_peserta.namapes, tb_peserta_lihat_seminar.status, tb_seminar_jadwal.mulai, tb_dosen_bimbingan_mhs.nim, tb_mahasiswa.nama_mahasiswa, tb_dosen_bimbingan_mhs.judul_laporan_mhs, tb_program_studi.nama_program_studi, tb_dosen_bimbingan_mhs.nip_nik, tb_pegawai.nama_pegawai';
						$join = array(
							array('tb_seminar_jadwal', 'tb_seminar_jadwal.id = tb_peserta_lihat_seminar.id', 'INNER'),
							array('tb_dosen_bimbingan_mhs', 'tb_dosen_bimbingan_mhs.id_dosen_bimbingan_mhs= tb_seminar_jadwal.id_dosen_bimbingan_mhs', 'INNER'),
							array('tb_mahasiswa', 'tb_mahasiswa.nim = tb_dosen_bimbingan_mhs.nim', 'INNER'),
							array('tb_pegawai', 'tb_pegawai.nip_nik = tb_dosen_bimbingan_mhs.nip_nik', 'INNER'),
							array('tb_peserta', 'tb_peserta.nimpes = tb_peserta_lihat_seminar.nimpes', 'INNER'),
							array('tb_program_studi', 'tb_program_studi.id_program_studi = tb_mahasiswa.id_program_studi', 'INNER')
						);
						$where="tb_peserta_lihat_seminar.nimpes= '$lihatpes->nimpes' AND tb_peserta_lihat_seminar.status = 'accept'";
						$listpes= datajoin('tb_peserta_lihat_seminar', $where, $select, $join, null, 'tb_seminar_jadwal.mulai ');?>
															
						<?php if (count($listpes) == 0): ?>
						<h4 class="text-center">Anda Belum Mengkuti Seminar Sama Sekali</h4>
						<?php endif ?>
						<?php foreach ($listpes as $key => $listpeserta): ?>
						<a class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
							<div
								class="d-flex row justify-content-between align-items-center">
								<div class="col col-xs-12">
									<small>No:</small>
									<h5 class="mb-0"><?php echo $key+1 ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Tanggal:</small>
									<?php
									$tugl = explode('T', $listpeserta->mulai)[0];
									?>
									<h5 class="mb-0"><?php echo nama_hari($tugl).', '. tgl_indo($tugl); ?></h5>	
								</div>
								<div class="col col-xs-12">
									<small>Judul Seminar:</small>
									<h5 class="mb-0"><?php echo $listpeserta->judul_laporan_mhs ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Nama Penyaji:</small>
									<h5 class="mb-0">
										<?php echo $listpeserta->nama_mahasiswa ?> (<?php echo $listpeserta->nim?>)</h5>
								</div>
								<div class="col col-xs-12">
									<small>Jurusan Penyaji :</small>
									<h5 class="mb-0"><?php echo $listpeserta->nama_program_studi ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Pembimbing :</small>
									<h5 class="mb-0"><?php echo $listpeserta->nama_pegawai?></h5>
								</div>
							</div>
						</a>
						<?php endforeach; ?>	
						<?php endforeach; ?>
						<?php endif; ?>
						</div>
					</div>
				</div>
		</div>
		<?php endif; ?>
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
