<!DOCTYPE html>
<?php $levels = masterdata('tb_master_level'); ?>
<?php $ta = masterdata('tahun_akademik') ?>
<?php $prodi = masterdata('tb_program_studi') ?>
<html>
<!-- Head PHP -->
<?php $this->load->view('admin/_partials/header.php') ?>

<body>
<!-- Sidenav PHP-->
<?php $this->load->view('admin/_partials/sidenav.php'); ?>
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
						<div class="row align-items-center  mb-2">
							<div class="col-8">
								<h3 class="mb-0">Akun</h3>
								<p class="text-sm mb-0">
									Kelola akun user dan level dari user.
								</p>
							</div>
							<div class="col-4 text-right">
								<a href="<?php echo site_url('akun') ?>"
								   class="btn btn-sm btn-primary">Kembali</a>
							</div>
						</div>
						<form action="<?php echo site_url('akun/tambah') ?>" method="POST">
							<div class="row">
								<div class="col-6">
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<label for="">Username</label>
												<input type="text"
													   autocomplete="off"
													   class="form-control" name="username"
													   aria-describedby="username"
													   placeholder="">
												<small id="username" class="form-text text-muted">Masukkan username
													untuk
													pegawai atau
													mahasiswa</small>
												<small id="username" class="form-text text-muted">*Mahasiswa gunakan
													NIM</small>
												<small id="username" class="form-text text-muted">*Pegawai gunakan
													e-mail</small>
												<small id="username" class="form-text text-muted">*Peserta Seminar gunakan
													NIM</small>
												
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label for="">Password</label>
												<input type="password"
													   autocomplete="off"
													   class="form-control" name="password"
													   aria-describedby="password"
													   placeholder="">
												<small id="password" class="form-text text-muted">Masukkan
													password</small>
											</div>
											<div class="form-group">
												<label for="">ID</label>
												<input type="text"
													   autocomplete="off"
													   class="form-control" name="id"
													   aria-describedby="password"
													   placeholder="">
												<small id="password" class="form-text text-muted">*Masukkan
													NIP/ NIK untuk Pegawai</small>
												<small id="password" class="form-text text-muted">*Masukkan
													NIM untuk mahasiswa</small>
												<small id="password" class="form-text text-muted">*Masukkan
													NIM untuk Peserta Seminar</small>
											</div>
										</div>
									</div>
									<label for="">Akun untuk siapa? </label>
									<div class="custom-control custom-radio mb-3">
										<input name="mode" class="custom-control-input" id="customRadioM" type="radio"
											   value="mahasiswa">
										<label class="custom-control-label" for="customRadioM">Mahasiswa</label>
									</div>
									<div class="custom-control custom-radio mb-3">
										<input name="mode" class="custom-control-input" id="customRadioP" type="radio"
											   value="pegawai">
										<label class="custom-control-label" for="customRadioP">Pegawai</label>
									</div>
									<div class="custom-control custom-radio mb-3">
										<input name="mode" class="custom-control-input" id="customRadioPs" type="radio"
											   value="peserta">
										<label class="custom-control-label" for="customRadioPs">Peserta</label>
									</div>
								</div>
								<div class="col-6 d-flex flex-column align-content-end justify-content-between">
									<div class="form-group">
										<label for="">Nama Lengkap</label>
										<input type="text"
											   autocomplete="off"
											   class="form-control" name="nama" id="nama" aria-describedby="nama"
											   placeholder="">
										<small id="nama" class="form-text text-muted">Nama Lengkap Pengguna</small>
									</div>
									<div id="level_mahasiswa" style="display: none">
										<label for="">Pilih Program Studi</label>
										<select class="select_1_level" name="id_prodi">
											<?php foreach ($prodi as $key => $p): ?>
												<option
													value="<?php echo $p->id_program_studi ?>"><?php echo $p->nama_program_studi ?></option>
											<?php endforeach; ?>
										</select>
										<label for="">Pilih Tahun Akademik</label>
										<select class="select_3_level" name="id_ta">
											<?php foreach ($ta as $key => $t): ?>
												<option
													value="<?php echo $t->id_tahun_akademik ?>"><?php echo ucfirst($t->tahun_akademik) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div id="level_pegawai" style="display:none">
										<label for="">Pilih level untuk pegawai</label>
										<select class="select_2_level" name="level[]" multiple>
											<?php foreach ($levels as $key => $level): ?>
												<option
													value="<?php echo $level->id_master_level ?>"><?php echo ucfirst($level->nama_master_level) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div id="level_peserta" style="display:none">
										<label for="">Pilih Tahun Akademik</label>
										<select class="select_3_level" name="id_ta">
											<?php foreach ($ta as $key => $t): ?>
												<option
													value="<?php echo $t->id_tahun_akademik ?>"><?php echo ucfirst($t->tahun_akademik) ?></option>
											<?php endforeach; ?>
										</select>

										<label for="">Pilih level untuk peserta</label>
										<select class="select_4_level" name="level[]" multiple>
											<?php foreach ($levels as $key => $level): ?>
												<option
													value="<?php echo $level->id_master_level ?>"><?php echo ucfirst($level->nama_master_level) ?></option>
											<?php endforeach; ?>
										</select>
										
									</div>
									<div>
										<button class="mt-2 btn btn-sm btn-primary float-right text-right" name="submit"
												type="submit">
											Simpan
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer PHP -->
		<?php $this->load->view('admin/_partials/footer.php'); ?>
	</div>

</div>
<!-- Scripts PHP-->
<?php $this->load->view('admin/_partials/modal.php'); ?>
<?php $this->load->view('admin/_partials/js.php'); ?>
<script>
	$('[type="radio"]').on('change', function (e) {
		let val = e.target.value;
		if (val === 'pegawai') {
			$('#level_pegawai').css('display', 'block');
			$('#level_mahasiswa').css('display', 'none');
			$('#level_peserta').css('display', 'none');
		} else if (val === 'mahasiswa') {
			$('#level_pegawai').css('display', 'none');
			$('#level_mahasiswa').css('display', 'block');
			$('#level_peserta').css('display', 'none');
		} else {
			$('#level_pegawai').css('display', 'none');
			$('#level_mahasiswa').css('display', 'none');
			$('#level_peserta').css('display', 'block');
		}
	})
	$('.select_2_level').select2({
		maximumSelectionLength: 5,
		multiple: true,
		placeholder: "Pilih level (bisa lebih dari satu)"
	})
	$('.select_1_level').select2({
		placeholder: "Pilih Tahun Akademik (bisa lebih dari satu)"
	})
	$('.select_3_level').select2({
		placeholder: "Pilih Program Studi (bisa lebih dari satu)"
	})

	$('.select_4_level').select2({
		maximumSelectionLength: 5,
		multiple: true,
		placeholder: "Pilih level (bisa lebih dari satu)"
	})
</script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
