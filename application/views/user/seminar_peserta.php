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
					<div class="col-md-12">
						<?php if ($this->session->flashdata('status')): ?>
							<div
								class="alert alert-<?php echo $this->session->userdata('status')['type'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show"
								role="alert">
								<span class="alert-icon"><i class="ni ni-like-2"></i></span>
								<span
									class="alert-text"><strong><?php echo ucfirst($this->session->userdata('status')['type']) ?>!
									&nbsp;</strong><?php echo $this->session->flashdata('status')['message']; ?></span><br>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif; ?>
					</div>
				</div>
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
				
					<div class="card-body p-0">
						<div class="list-group list-group-flush">
							<div
								class="h4 bg-secondary p-3 m-0 font-weight-bold text-right d-flex justify-content-between">
								<div>Tanggal: <?php echo nama_hari(date('Y-m-d')).', '. tgl_indo(date('Y-m-d')); ?></div>
							</div>
							
						</div>
						<?php if (isset($sempes) and count($sempes) === 0): ?>
									<div class="col-12">
										<div class="card">
											<div class="card-body">
												<p class="h2 text-center font-weight-bold mt-3">Tidak
													Ada Jadwal Hari Ini</p>
											</div>
										</div>
									</div>
								<?php endif; ?>
						<?php foreach (isset($sempes) ? $sempes : array() as $key => $sempe): ?>
						<a class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
							<div
								class="d-flex row justify-content-between align-items-center">
								<div class="col col-xs-12">
									<small>Penyaji:</small>
									<h5 class="mb-0 h4"><?php echo $sempe->nama_mahasiswa ?></h5>
									<h5>(<?php echo $sempe->nim ?>)</h5>
								</div>
								<!-- <div class="col col-xs-12">
									<small>Pembimbing:</small>
									<h5 class="mb-0"><?php echo $sempe->nama_pegawai ?></h5>
								</div> -->
								<div class="col col-xs-12">
									<small>Ruangan:</small>
									<h5 class="mb-0"><?php echo $sempe->nama ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Waktu:</small>
									<h5 class="mb-0">
										Pukul <?php echo get_time_range($sempe->start, $sempe->end, 'time') ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Judul :</small>
									<h5 class="mb-0"><?php echo $sempe->judul_laporan_mhs ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Perusahaan:</small>
									<h5 class="mb-0"><?php echo $sempe->nama_perusahaan ?></h5>
								</div>
								<form method="POST" action="<?php echo site_url('seminarpeserta?m=seminarjadwalpes&q=i')?>">
								<!-- Input groups with icon -->
                                <input type="hidden" name="id" value="<?php echo $sempe->id?>" id="">
								<?php $id = $this->session->userdata('id'); ?>
								<input type="hidden" name="nimpes" value="<?php echo $id ?>" id="">
								<input type="hidden" name="status" value="waiting" id="">
								<div class="col col-xs-12">
								<!-- <button type="submit" name="gabung" class="m-1 btn btn-sm btn-primary">
									Gabung
								</button> -->
								<?php 
								$where="tb_dosen_bimbingan_mhs.nim= '$sempe->nim' AND tb_peserta_lihat_seminar.nimpes = '$id'";
								$join = array(
									array('tb_seminar_jadwal', 'tb_seminar_jadwal.id=tb_peserta_lihat_seminar.id', 'inner join'),
									array('tb_dosen_bimbingan_mhs', 'tb_dosen_bimbingan_mhs.id_dosen_bimbingan_mhs=tb_seminar_jadwal.id_dosen_bimbingan_mhs', 'inner join')
								);
								$stattamp = datajoin('tb_peserta_lihat_seminar', $where, 'tb_peserta_lihat_seminar.nimpes, tb_peserta_lihat_seminar.status, tb_seminar_jadwal.id_dosen_bimbingan_mhs, tb_dosen_bimbingan_mhs.nim', $join);
								?>

								
								<?php if (isset($stattamp) and count($stattamp) === 0): ?>
									<small>Gabung:</small>
									</br><button type="submit" name="gabung" class="m-1 btn btn-sm btn-primary">
									Gabung
								</button>
								<?php endif; ?>
								<?php foreach ($stattamp as $key => $tampils): ?>
								<small>Status:</small>
								<?php if ($tampils->status === 'waiting'): ?>
								</br><button type= "button" class="m-1 btn btn-sm btn-warning">
									Menunggu
								</button>
								<?php elseif ($tampils->status === 'accept'): ?>
									</br><button type= "button" class="m-1 btn btn-sm btn-success">
									Diterima
								</button>
								<?php else: ?>
								</br><button type="button" class="m-1 btn btn-warning btn-sm">
									Ditolak
								</button>
								<?php endif ?>
								<?php endforeach?>
								</div>
								</form>
							</div>
						</a>
						<?php endforeach; ?>
					</div>


					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="card">
					<!-- Card header -->
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">Jadwal Seminar Besok</h3>
								<p class="text-sm mb-0">
									Berikut daftar jadwal seminar besok
								</p>
								
							</div>
						</div>
					</div>
					
					<div class="card-body p-0">
						<div class="list-group list-group-flush">
							<div
								class="h4 bg-secondary p-3 m-0 font-weight-bold text-right d-flex justify-content-between">
								<?php
									$date = date('Y-m-d'); 
									$datetime = new DateTime($date);
									$datetime->modify('+1 day');
									$tomorrow = $datetime->format('Y-m-d');
								?>
								<div>Besok Tanggal: <?php echo nama_hari($tomorrow).', '. tgl_indo($tomorrow); ?></div>
							</div>
							<?php if (isset($besok) and count($besok) === 0): ?>
									<div class="col-12">
										<div class="card">
											<div class="card-body">
												<p class="h2 text-center font-weight-bold mt-3">Tidak
													Ada Jadwal Untuk Besok</p>
											</div>
										</div>
									</div>
								<?php endif; ?>
						</div>
						<?php foreach (isset($besok) ? $besok : array() as $key => $besoknya): ?>
						<a class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
							<div
								class="d-flex row justify-content-between align-items-center">
								<div class="col col-xs-12">
									<small>Penyaji:</small>
									<h5 class="mb-0 h4"><?php echo $besoknya->nama_mahasiswa ?></h5>
									<h5>(<?php echo $besoknya->nim ?>)</h5>
								</div>
								<!-- <div class="col col-xs-12">
									<small>Pembimbing:</small>
									<h5 class="mb-0"><?php echo $besoknya->nama_pegawai ?></h5>
								</div> -->
								<div class="col col-xs-12">
									<small>Ruangan:</small>
									<h5 class="mb-0"><?php echo $besoknya->nama ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Waktu:</small>
									<h5 class="mb-0">
										Pukul <?php echo get_time_range($besoknya->start, $besoknya->end, 'time') ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Judul :</small>
									<h5 class="mb-0"><?php echo $besoknya->judul_laporan_mhs ?></h5>
								</div>
								<div class="col col-xs-12">
									<small>Perusahaan:</small>
									<h5 class="mb-0"><?php echo $besoknya->nama_perusahaan ?></h5>
								</div>

							</div>
						</a>
						<?php endforeach; ?>
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
