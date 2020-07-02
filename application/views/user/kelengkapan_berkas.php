<!DOCTYPE html>
<?php $nim = $this->session->userdata('id');
$mhs = masterdata('tb_mahasiswa', "nim = '$nim'", 'nama_mahasiswa nama') ?>
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
			<div class="col-xl-12">
				<!-- Checklist -->
				<div class="card">
					<!-- Card header -->
					<div class="card-header">
						<!-- Title -->
						<div class="h2">Kelengkapan berkas</div>
						<?php error_reporting(0); ?>
						<?php foreach ($jadwalku as $waktusem): ?>
						<?php
						$select = 'tb_seminar_penilaian.id_seminar_jadwal, tb_seminar_penilaian.status_revisi, tb_history_seminar_penilaian.tanggal_revisi, tb_history_seminar_penilaian.update_time';
						$join = array('tb_history_seminar_penilaian','tb_seminar_penilaian.id = tb_history_seminar_penilaian.id_seminar_penilaian','INNER');
						$where="update_time IN (SELECT MAX(update_time) FROM tb_history_seminar_penilaian WHERE id_seminar_jadwal='$waktusem->id')";
						$query= datajoin('tb_seminar_penilaian', $where, $select, $join, null);?>
						<?php foreach ($query as $key => $querynya): ?>
						<?php $tglpem = $querynya->update_time ?>
						<?php endforeach; ?>
						<?php endforeach; ?>

						<h3 id="judcount">Waktu Pengumpulan Berkas :</h3>
							<h1 id="count"></h1>

							<?php $tanggal_mulai= date('Y-m-d',strtotime(explode('T',$tglpem)[0]));?>
									
							<script>
							//Countdown Waktu Menuju Seminar
							// Set the date we're counting down to
							var countDownDate = new Date('<?= date("m/d/Y", strtotime('+7 days',strtotime($tanggal_mulai))); ?>').getTime();

							// Update the count down every 1 second
							var z = setInterval(function() {

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
								clearInterval(z);
								document.getElementById("count").innerHTML = "Pemberkasan Anda Telat Lebih dari 7 Hari";
							}
							}, 1000);
							</script>
					</div>
					<!-- Card body -->
					<div class="card-body">
						
						<!-- List group -->
						<?php $allow = isset($allow) ? $allow : false; ?>
						<?php if (!$allow && !isset($status)): ?>
							<script>
							clearInterval(z);
							$('#judcount').hide();
							$('#count').hide();
							</script>
							<div class="h2">Anda belum bisa upload kelengkapan berkas</div>
						<?php elseif (!$allow && isset($status)): ?>
							<script>
							clearInterval(z);
							$('#judcount').hide();
							$('#count').hide();
							</script>
							<div class="h3">ANDA TELAH MENGUPLOAD FILE PEMBERKASAN</div>
						<?php else: ?>
							<div class="h5">Silahkan upload berkas anda disini</div>
							<input type="file" class="my-pond">
						<?php endif; ?>
						<?php
						if (isset($status->message)): ?>
							<div class="alert <?php echo $status->color ?> alert-dismissible fade show"
								 role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong><?php echo $status->message ?></strong>
							</div>
						<?php endif; ?>
						<div class="h5">* Catatan</div>
						<div class="h6 font-weight-normal">- Apabila berkas yang kalian upload kurang lengkap,
							koordinator akan mengintruksikan kalian untuk upload ulang
						</div>
						<script>
							$(".alert").alert();
						</script>
						<?php ?>
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
<script src="<?php echo base_url('aset/vendor/filepond/filepond-plugin-file-rename.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/filepond/filepond-plugin-file-validate-size.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/filepond/filepond-plugin-file-validate-type.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/filepond/filepond-plugin-image-preview.min.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/filepond/filepond.min.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/filepond/filepond.jquery.js') ?>"></script>
<script>
	$(document).ready(function () {
		if (!localStorage.getItem('wizard')) {
			introJs().start().oncomplete(function () {
				localStorage.setItem('wizard', 'yes')
			}).onexit(function () {
				localStorage.setItem('wizard', 'yes')
			})
		}
		FilePond.registerPlugin(FilePondPluginFileRename);
		FilePond.registerPlugin(FilePondPluginFileValidateSize);
		FilePond.registerPlugin(FilePondPluginFileValidateType);
		FilePond.setOptions({
			maxFileSize: '1MB',
			acceptedFileTypes: ['application/pdf'],
			fileRenameFunction: (file) => {
				console.log(file);
				return `<?php echo $nim . ' - ' . $mhs->nama ?>${file.extension}`;
			}
		})
		let pond = $('.my-pond').filepond({
			server: "<?php echo site_url('kelengkapan?m=upload') ?>"
		})
		$('.my-pond').on('FilePond:processfile', function (e) {
			window.location.reload();
		})
	})
</script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
