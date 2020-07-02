<!DOCTYPE html>
<html>

<!-- Head PHP -->
<?php $this->load->view('user/_partials/header.php'); ?>
<script src="<?php echo base_url('aset/vendor/jquery/dist/jquery.min.js') ?>"></script>
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
	<div class="container-fluid mt--6">
		<!-- Card -->
		<div class="header-body">
			<!-- Card stats -->
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="card">
						<div class="card-header">
						</div>
						<div class="card-body">
							<p class="h4 bold m-0 mb-4">Approval Peserta Seminar sesuai Bimbingan</p>
							<?php if ($this->session->flashdata('status')): ?>
								<?php $status = $this->session->flashdata('status'); ?>
								<div class="alert alert-<?php echo $status->alert ?> alert-dismissible fade show"
									 role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<strong><?php echo $status->status ?></strong>&nbsp;<?php echo $status->message ?>
								</div>
							<?php endif; ?>
							<div class="accordion" id="accordionBimbingan">
								<?php $peserta_app = $peserta_app ? $peserta_app : array();
								if ($peserta_app): ?>
									<?php foreach ($peserta_app as $mahasiswa): ?>
										<div class="card"
											 style="box-shadow: rgba(0,0,0,.1) 0 0 0 1px, rgba(0,0,0,.1) 0 4px 16px;">
											<div class="card-header" id="headingOne" data-toggle="collapse"
												 data-target="#<?php echo $mahasiswa->nim ?>" aria-expanded="true"
												 aria-controls="<?php echo $mahasiswa->nim ?>">
												<h5 class="mb-0"><?php echo $mahasiswa->nama_mahasiswa ?></h5>
											</div>
											
											<div id="<?php echo $mahasiswa->nim ?>" class="collapse"
												 aria-labelledby="headingOne"
												 data-parent="#accordionBimbingan">
												<div class="card-body">
													
													<form method="POST" action="<?php echo site_url('seminarpeserta?m=approvepes&q=u')?>" id="form-acc" enctype="multipart/form-data">
													<button type="submit" name="accept" class="btn btn-success btn-sm">Terima</button>
													</br>
													</br>
													<table class="table table-bordered">
														<tr>
															<th style="width:5%">Pilih</th>
															<th style="width:5%">No</th>
															<th style="width:5%">NIM</th>
															<th>Nama</th>
															<th>Jurusan</th>
															<th>Status</th>
															<th>Aksi</th>
														</tr>
														<?php
														$select = 'tb_peserta_lihat_seminar.id_lihat, tb_peserta_lihat_seminar.nimpes, tb_peserta.namapes, tb_program_studi.nama_program_studi, tb_peserta_lihat_seminar.status, tb_seminar_jadwal.id_dosen_bimbingan_mhs, tb_dosen_bimbingan_mhs.nip_nik';
														$join = array(
															array('tb_peserta', 'tb_peserta.nimpes=tb_peserta_lihat_seminar.nimpes', 'INNER'),
															array('tb_seminar_jadwal', 'tb_seminar_jadwal.id=tb_peserta_lihat_seminar.id', 'INNER'),
															array('tb_dosen_bimbingan_mhs', 'tb_dosen_bimbingan_mhs.id_dosen_bimbingan_mhs=tb_seminar_jadwal.id_dosen_bimbingan_mhs', 'INNER'),
															array('tb_program_studi', 'tb_program_studi.id_program_studi = tb_peserta.id_program_studi', 'INNER')
														);
														$where = array('nim' => $mahasiswa->nim);
														$listpes= datajoin('tb_peserta_lihat_seminar', $where, $select, $join, null, 'tb_peserta_lihat_seminar.id_lihat');?>
														
														<?php if (count($listpes) == 0): ?>
															<tr>
																<td colspan="6">
																	<h4 class="text-center">Peserta belum melakukan
																		Join Lihat Seminar</h4>
																</td>
															</tr>
														<?php endif ?>
														<?php foreach ($listpes as $key => $listpeserta): ?>
															<tr>
																<td><input type="checkbox" class="check-item" name="id_lihat[]" value="<?php echo $listpeserta->id_lihat ?>"></td>
																<td><?php echo $key + 1 ?></td>
																<td><?php echo $listpeserta->nimpes ?></td>
																<td><?php echo $listpeserta->namapes ?></td>
																<td><?php echo $listpeserta->nama_program_studi ?></td>
																<td>
																	<?php if ($listpeserta->status == "waiting"): ?>
																		<p class="btn btn-sm btn-warning"> Menunggu </p>
																	<?php elseif ($listpeserta->status == "accept"): ?>
																		<p class="btn btn-sm btn-success"> Diterima </p>
																	<?php else: ?>
																		<p class="btn btn-sm btn-danger">Ditolak</p>
																	<?php endif; ?>
																</td>
																<td>
																	<?php if ($listpeserta->status == "waiting"): ?>
																		<a class="btn btn-sm btn-success"
																		   href="<?php echo site_url('seminarpeserta?m=approvepes&a=accept&id=' . $listpeserta->id_lihat) ?>">Terima</a>
																		<a class="btn btn-sm btn-danger"
																		   href="<?php echo site_url('seminarpeserta?m=approvepes&a=decline&id=' . $listpeserta->id_lihat) ?>">Tolak</a>
																	<?php else: ?>
																		<p class="btn btn-sm btn-primary">Telah Dikonfirmasi</p>
																	<?php endif; ?>
																</td>

															</tr>
														<?php endforeach; ?>
													</table>
													</form>
												</div>
											</div>
											
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
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
<?php $this->load->view('user/_partials/js.php'); ?>

</body>

</html>
