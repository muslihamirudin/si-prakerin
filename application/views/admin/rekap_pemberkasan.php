<!DOCTYPE html>
<html>

<!-- Head PHP -->
<?php $this->load->view('admin/_partials/header.php'); ?>

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
		<!-- Card -->
		<div class="header-body">
			<!-- Card stats -->
			<div class="card">
				<div class="card-header">
					<h4 class="font-weight-600">Status Pemberkasan Mahasiswa</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="pemberkasan-table">
							<thead>
							<tr>
								<th>NIM</th>
								<th>Nama Mahasiswa</th>
								<th>Status Pemberkasan</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th>NIM</th>
								<th>Nama Mahasiswa</th>
								<th>Status Pemberkasan</th>
								<th>Aksi</th>
							</tr>
							</tfoot>
							<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer PHP -->
		<?php $this->load->view('admin/_partials/footer.php'); ?>
	</div>
</div>
<!-- Scripts PHP-->
<div id="modal-preview"></div>
<?php //$this->load->view('admin/_partials/modal_preview.php'); ?>
<?php $this->load->view('admin/_partials/js.php'); ?>
<?php
//	require APPPATH."libraries/hotreloader.php";
//	$reloader = new HotReloader();
//	$reloader->setRoot(__DIR__);
//	$reloader->currentConfig();
//	$reloader->init();
?>
<script>
	Date.prototype.workingDaysFrom = function (fromDate) {
		// ensure that the argument is a valid and past date
		if (!fromDate || isNaN(fromDate) || this < fromDate) {
			return -1;
		}

		// clone date to avoid messing up original date and time
		let frD = new Date(fromDate.getTime()),
			toD = new Date(this.getTime()),
			numOfWorkingDays = 1;

		// reset time portion
		frD.setHours(0, 0, 0, 0);
		toD.setHours(0, 0, 0, 0);

		while (frD < toD) {
			frD.setDate(frD.getDate() + 1);
			let day = frD.getDay();
			if (day != 0 && day != 6) {
				numOfWorkingDays++;
			}
		}
		return numOfWorkingDays;
	};
	$('#pemberkasan-table')
		.on('init.dt', function () {
			$('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
		})
		.dataTable({
			responsive: true,
			language: {
				paginate: {
					previous: "<i class='fas fa-angle-left'>",
					next: "<i class='fas fa-angle-right'>"
				}
			},
			ajax: {
				url: "<?php echo site_url('seminar?m=pemberkasan') ?>",
				data: {
					ajax: true
				},
				type: "POST"
			},
			columns: [
				{"data": "nim"},
				{"data": "nama_mahasiswa"},
				{
					"data": "tanggal_upload",
					"render": function (data, type, row) {
						let status_pemberkasan = "";
						let countDay = 0;
						let addtional_status = "";
						let date_upload = new Date(data);
						let date_seminar = new Date(row.tanggal_seminar);
						let date_now = new Date();
						let countdown = 0;
						if (row.tanggal_upload === "belum" && (row.terakhir_revisi !== "belum revisi" || row.terakhir_revisi !== "belum revisi")) {
							status_pemberkasan = "Belum Pemberkasan";
							let date_revisi = new Date(row.terakhir_revisi);
							countdown = date_now.workingDaysFrom(date_revisi);
							let sisa = 8 - countdown;
							addtional_status = " Kurang " + sisa + " Hari sebelum terlambat"
						}
						if (row.terakhir_revisi === "belum seminar") {
							status_pemberkasan = "Nilai seminar belum lengkap";
							addtional_status = ''
						}
						if (row.terakhir_revisi === "belum revisi") {
							status_pemberkasan = "Nilai Revisi belum lengkap";
							addtional_status = ''
						}
						if (date_upload != "Invalid Date") {
							let revisi = new Date(row.terakhir_revisi);
							countdown = date_upload.workingDaysFrom(revisi);
							status_pemberkasan = countdown < 8 ? "Tepat Waktu" : "Terlambat";
						}
						return "<div>Status Pemberkasan : " + status_pemberkasan + "</div>" + (addtional_status !== '' ? "<div> Keterangan :" + addtional_status + "</div>" : "")
					}
				},
				{
					"data": "file",
					"render": function (data, type, row) {
						return data !== "belum" ? "<button id='btn-preview' class='btn btn-sm btn-primary' data-file='" + data + "'>Lihat Berkas</button>" : "Belum ada aksi"
					}
				},
			]
		})
	;

	$(document).on('click', "#btn-preview", function () {
		let file = $(this).data('file');
		$.ajax({
			url: "<?php echo site_url('seminar?m=pemberkasan&q=preview')?>",
			method: 'POST',
			data:{
				file:file
			},
			success: function (res) {
				$('#modal-preview').html(res);
				$('#previewModal').modal('show')
			}

		})
	})
</script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
