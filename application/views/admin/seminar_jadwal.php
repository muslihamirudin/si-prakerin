<?php $section = isset($_GET['section']) ? $_GET['section'] : null ?>
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
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12">
					<div class="card card-calendar">
						<div class="card-header">
							<ul class="nav nav-pills">
								<li class="nav-item">
									<a href="<?php echo site_url('seminar?m=kelola&section=tempat') ?>"
									   class="nav-link <?php echo $section == 'tempat' ? 'active' : null ?>">Tempat</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo site_url('seminar?m=kelola&section=penguji') ?>"
									   class="nav-link <?php echo $section == 'penguji' ? 'active' : null ?>">Penguji</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo site_url('seminar?m=kelola&section=jadwal') ?>"
									   class="nav-link <?php echo $section == 'jadwal' ? 'active' : null ?>">Buat Jadwal
										Sidang</a>
								</li>
							</ul>
							<?php if ($section == 'jadwal'): ?>
								<!-- Title -->
								<div class="row pt-3">
									<div class="col-md-8 col-sm-12">
										<h5 class="h3 mb-0">Kalender Jadwal Seminar</h5>
										<small>* Klik untuk mengelola jadwal seminar prakerin</small><br>
									</div>
									<div class="col-md-4 col-sm-12 text-right">
										<a href="javascript:void(0)"
										   class="fullcalendar-btn-prev btn btn-sm btn-primary">
											<i class="fas fa-angle-left"></i>&nbsp;Previous
										</a>
										<a href="javascript:void(0)"
										   class="fullcalendar-btn-next btn btn-sm btn-primary">
											Next&nbsp;<i class="fas fa-angle-right"></i>
										</a><br>
										<h6 class="h5 d-inline-block mb-0 mr-2" id="fullcalendar-title"></h6>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-12 text-left">
										<p id="month-name" class="h1 font-weight-bold"></p>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										<a href="javascript:void(0)" class="btn btn-sm btn-primary" id="changeView"
										   data-month="true">
											Tampilkan per minggu
										</a>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="card-body">
							<?php if (isset($section)): ?>
								<?php switch ($section):
									case 'tempat': ?>
										<div class="row">
											<div class="col-12 d-flex justify-content-between">
												<h3 class="m-0 p-0 text-primary">Kelola Tempat Seminar</h3>
												<button id="button-tempat" class="btn btn-sm btn-primary"
														data-toggle="collapse" data-target="#form-ruangan"
														aria-expanded="false" aria-controls="form-ruangan">Tambah
												</button>
											</div>
										</div>
										<div class="row d-flex justify-content-end mt-3">
											<div class="col-lg-4 col-md-4 col-sm-12">
												<div class="form-group collapse" id="form-ruangan">
													<input class="form-control form-control-sm" name="ruangan" value=""
													  placeholder="Masukkan Nama Ruangan"/>
												</div>
											</div>
										</div>
										<div class="table-responsive py-4">
											<table class="table table-flush" id="datatable-tempat">
												<thead class="thead-light">
												<tr role="row">
													<th>No</th>
													<th>Ruangan</th>
													<th>Aksi</th>
												</tr>
												</thead>
												<tfoot>
												<tr>
													<th>No</th>
													<th>Ruangan</th>
													<th>Aksi</th>
												</tr>
												</tfoot>
												<tbody>

												</tbody>
											</table>
										</div>
										<?php break ?>
									<?php case 'penguji': ?>
										<h3 class="m-0 p-0 text-primary mb-2">Kelola Dosen Penguji</h3>
										<ul class="nav nav-tabs">
											<?php if (isset($prodies)):
												foreach ($prodies as $prody):
													?>
													<li class="nav-item">
														<a href="<?php echo site_url("seminar?m=kelola&section=penguji&prodi=$prody->id_program_studi") ?>"
														   class="nav-link <?php echo isset($_GET['prodi']) && $_GET['prodi'] == $prody->id_program_studi ? 'active' : null ?>"><?php echo $prody->nama_program_studi ?></a>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										</ul>
										<?php if (isset($_GET['prodi'])): ?>
											<div class="table-responsive">
												<table class="table" id="table-penguji">
													<thead>
													<tr>
														<th>Nama Dosen</th>
														<th>Penguji 1</th>
														<th>Penguji 2</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td></td>
														<td class="p-0">
															<div class="custom-control custom-checkbox mt-1">
																<input class="custom-control-input" id="check-all-p1"
																	   type="checkbox">
																<label class="custom-control-label" for="check-all-p1">Pilih
																	Semua</label>
															</div>
														</td>
														<td class="p-0">
															<div class="custom-control custom-checkbox mt-1">
																<input class="custom-control-input" id="check-all-p2"
																	   type="checkbox">
																<label class="custom-control-label" for="check-all-p2">Pilih
																	Semua</label>
															</div>
														</td>
													</tr>
													<?php if (isset($dosens)): ?>
														<?php foreach ($dosens[$_GET['prodi']] as $dosen): ?>
															<tr>
																<td><?php echo $dosen->nama_pegawai; ?></td>
																<?php
																$penguji = isset($penguji) ? $penguji : array();
																$pengujis = $penguji[$dosen->id] ? $penguji[$dosen->id] : array();
																$keys_penguji = array('p1', 'p2');
																if (count($pengujis) == 1 and isset($pengujis[0]->status)) {
																	$status = $pengujis[0]->status;
																	if ($status == 'p2') {
																		array_unshift($pengujis, (object)array("id" => null, 'status' => null));
																	} else {
																		array_push($pengujis, (object)array("id" => null, 'status' => null));
																	}
																}
																foreach ($keys_penguji as $key => $peng):?>
																	<td id="checkbox-<?php echo $peng ?>">
																		<label
																			class="custom-toggle custom-toggle-primary">
																			<input class="checkbox-<?php echo $peng ?>"
																				   type="checkbox"
																				   data-id="<?php echo $dosen->id ?>"
																				   id="<?php echo isset($pengujis[$key]->id) ? $pengujis[$key]->id : null ?>" <?php echo (isset($pengujis[$key]->status) and $pengujis[$key]->status != null) ? 'checked' : null ?>
																				   data-mode="<?php echo $peng ?>">
																			<span
																				class="custom-toggle-slider rounded-circle"
																				data-label-off="No"
																				data-label-on="Yes"></span>
																		</label>
																	</td>
																<?php endforeach; ?>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
													</tbody>
												</table>
											</div>
										<?php endif; ?>
										<?php break; ?>
									<?php case 'jadwal': ?>
										<div id="calendar" class="calendar"></div>
										<?php break; ?>
									<?php endswitch; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer PHP -->
		<?php $this->load->view('admin/_partials/modal_add_event.php') ?>
		<?php $this->load->view('admin/_partials/modal_edit_event.php') ?>
		<?php $this->load->view('admin/_partials/footer.php'); ?>
	</div>
	<!-- Scripts PHP-->
	<?php $this->load->view('admin/_partials/modal.php'); ?>
	<?php $this->load->view('admin/_partials/js.php'); ?>
	<!--	<script src="--><?php //echo base_url('aset/vendor/fullcalendar/fullcalendar.min.js') ?><!--"></script>-->
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/core/main.min.js') ?>"></script>
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/daygrid/main.min.js') ?>"></script>
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/timegrid/main.min.js') ?>"></script>
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/interaction/main.min.js') ?>"></script>
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/locales-all.min.js') ?>"></script>
	<script src="<?php echo base_url('aset/vendor/fullcalendar/4/google-calendar/main.min.js') ?>"></script>
	<script>
		<?php if($section == 'tempat'):?>
		function data_tempat() {
			$('#datatable-tempat').dataTable({
				ajax: '<?php echo site_url('seminar?m=tempat') ?>',
				language: {
					paginate: {
						previous: "<i class='fas fa-angle-left'>",
						next: "<i class='fas fa-angle-right'>"
					}
				},
				columns: [
					{'data': 'id'},
					{'data': 'nama'},
					{
						"data": null,
						"defaultContent": '' +
							'<div class="btn-group">' +
							'<button id="btn-tempat-edit" class="btn btn-sm btn-primary">Edit</button>' +
							'<button id="btn-tempat-delete" class="btn btn-sm btn-danger">Delete</button>' +
							'</div>'
					}
				],
			})
		}
		<?php endif?>

		$(document).ready(function () {
			//tempat
			<?php if($section == 'tempat'):?>
			data_tempat();
			$('#button-tempat').on('click', function () {
				let isCollapse = $(this).attr('aria-expanded');
				if (isCollapse === "false") {
					//it mean expand
					$(this).text('Simpan').removeClass('btn-primary').removeClass('btn-danger').addClass('btn-success');
				} else {
					let inputValue = $('input[name="ruangan"]').val();
					if (inputValue !== '') {
						let buttonName = $(this).text();
						switch (buttonName) {
							case 'Simpan':
								$.ajax({
									url: '<?php echo site_url('seminar?m=tempat&q=i') ?>',
									data: {tempat: inputValue},
									method: "POST",
									success: function (res) {
										alert('Tempat telah disimpan');
										window.location.reload();
									}
								})
								$(this).text('Tambah').removeClass('btn-success').addClass('btn-primary');
								break;
							case 'Edit':
								let idInput = $('input[name="ruangan"]').data('id');
								$.ajax({
									url: '<?php echo site_url('seminar?m=tempat&q=u') ?>',
									data: {tempat: inputValue, id: idInput},
									method: "POST",
									success: function (res) {
										alert('Tempat telah update');
										window.location.reload();
									}
								})
								$(this).text('Tambah').removeClass('btn-success').addClass('btn-primary');
								break;
							default:
								return;
						}

					} else {
						$(this).text('Error').removeClass('btn-success').addClass('btn-danger');
					}

				}
			})
			$(document).on('click', '#btn-tempat-edit', function () {
				let row = $(this).parents('tr');
				let id = $(row).children('td.sorting_1').text();
				let name = $(row).children('td:nth-child(2)').text();
				$('#form-ruangan').collapse('show');
				$('input[name="ruangan"]').val(name).data('id', id);
				$('#button-tempat').text('Edit').removeClass('btn-primary').addClass('btn-success');
			})
			$(document).on('click', '#btn-tempat-delete', function () {
				if (confirm('Apakah yakin ingin menghapus data ini?')) {
					let row = $(this).parents('tr');
					let id = $(row).children('td.sorting_1').text();
					$.ajax({
						url: '<?php echo site_url('seminar?m=tempat&q=d') ?>',
						data: {id: id},
						method: "POST",
						success: function (res) {
							alert('Data berhasil di hapus');
							window.location.reload();
						}
					})
				}

			})
			<?php endif?>
			<?php if($section == 'penguji'): ?>
			if ($('input.checkbox-p1').not(':checked').length === 0) {
				$('#check-all-p1').prop('checked', true);
			}
			if ($('input.checkbox-p2').not(':checked').length === 0) {
				$('#check-all-p2').prop('checked', true);
			}
			$(document).on('change', 'input[type="checkbox"]', function () {
				//mean that user select one by one;
				let data_bulk = [];
				let mode = '';
				let query = '';
				let input_checked = '';
				switch (this.id) {
					case "check-all-p1":
						input_checked = $('input.checkbox-p1');
						mode = 'p1';
						let not_checked = $('input.checkbox-p1').not(':checked');
						let are_checked = $('input.checkbox-p1:checked');
						if (!not_checked.length || !are_checked.length) {
							input_checked.map(function () {
								if (this.checked) {
									this.checked = false;
									data_bulk.push(this.id);
									query = 'd_bulk';
								} else {
									this.checked = true;
									data_bulk.push($(this).data('id'));
									query = 'i_bulk';
								}
							});
						} else {
							if (this.checked) {
								not_checked.prop('checked', true);
								data_bulk.push($(not_checked).data('id'));
								query = 'i_bulk';
							}
						}
						console.log(data_bulk);
						$.ajax({
							url: '<?php echo site_url('seminar?m=penguji&q=') ?>' + query,
							method: "POST",
							data: {mode: mode, ids: data_bulk},
							dataType: 'json',
							success: function (res) {
								console.log(res)
							}
						})
						break;
					case "check-all-p2":
						input_checked = $('input.checkbox-p2');
						mode = 'p2';
						input_checked.map(function () {
							if (this.checked) {
								this.checked = false;
								query = 'd_bulk';
								data_bulk.push(this.id);
							} else {
								this.checked = true;
								query = 'i_bulk';
								data_bulk.push($(this).data('id'));
							}
						});
						$.ajax({
							url: '<?php echo site_url('seminar?m=penguji&q=') ?>' + query,
							method: "POST",
							data: {mode: mode, ids: data_bulk},
							dataType: 'json',
							success: function (res) {
								console.log(res)
							}
						})
						break;
					default:
						if (!this.checked) {
							let id = this.id;
							let query = 'd';
							$.ajax({
								url: '<?php echo site_url('seminar?m=penguji&q=') ?>' + query,
								method: "POST",
								data: {id: id},
								dataType: 'json',
								success: function (res) {
									console.log(res)
								}
							})
						} else {
							let id = $(this).data('id');
							let query = 'i';
							let mode = $(this).data('mode');
							$.ajax({
								url: '<?php echo site_url('seminar?m=penguji&q=') ?>' + query,
								method: "POST",
								data: {id: id, mode: mode},
								dataType: 'json',
								success: function (res) {
									console.log(res)
								}
							})
						}
						break;

				}
			})
			<?php endif; ?>
		})

	</script>
	<?php if ($section == 'jadwal'): ?>
		<script>
			$('.clockpicker').clockpicker();
			$('#tanggal-seminar').datepicker({
				startDate: "-60y",
				format: "yyyy-mm-dd"
			});
			$('#select-penguji1,#select-penguji1-edit').empty().select2({
				placeholder: "Penguji 1",
				ajax: {
					url: '<?php echo site_url("seminar?m=penguji") ?>',
					dataType: 'json',
					data: {status: "p1"},
					processResults: function (res) {
						// Transforms the top-level key of the response object from 'items' to 'results'
						return {
							results: $.map(res.data, function (item) {
								return {
									text: item.nama_pegawai,
									id: item.id
								}
							})
						};
					},
					cache:true,
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			}).on('select2:select', function ({params}) {
				$('#id_p1,#id_p1_edit').val(params.data.id)
			});
			$('#select-penguji2,#select-penguji2-edit').empty().select2({
				placeholder: "Penguji 2",
				ajax: {
					url: '<?php echo site_url("seminar?m=penguji") ?>',
					dataType: 'json',
					data: {status: "p2"},
					processResults: function (res) {
						// Transforms the top-level key of the response object from 'items' to 'results'
						return {
							results: $.map(res.data, function (item) {
								return {
									text: item.nama_pegawai,
									id: item.id,
								}
							})
						};
					},
					cache:true,
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			}).on('select2:select', function ({params}) {
				$('#id_p2,#id_p2_edit').val(params.data.id)
			})
			$('#select-mahasiswa,#select-mahasiswa-edit').empty().select2({
				placeholder: 'Mahasiswa seminar',
				ajax: {
					url: '<?php echo site_url("seminar?m=mahasiswa") ?>',
					dataType: 'json',
					processResults: function (res) {
						// Transforms the top-level key of the response object from 'items' to 'results'
						return {
							results: $.map(res.data, function (item) {
								return {
									text: item.nama_mahasiswa,
									id: item.id_dosen_bimbingan_mhs,
									laporan: item.judul_laporan_mhs,
									pembimbing: item.nama_pembimbing
								}
							})
						};
					},
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
					cache:true
				}
			}).on('select2:select', function ({params}) {
				$('#id_dosen_bimbingan_mhs,#id_dosen_bimbingan_mhs_edit').val(params.data.id)
				$('#input-laporan').val(params.data.laporan ? params.data.laporan : "Belum ada judul");
				$('#input-pembimbing').val(params.data.pembimbing)
			});
			$('#select-ruangan, #select-ruangan-edit').empty().select2({
				placeholder: 'Ruang seminar',
				ajax: {
					url: '<?php echo site_url("seminar?m=tempat") ?>',
					dataType: 'json',
					processResults: function (res) {
						// Transforms the top-level key of the response object from 'items' to 'results'
						return {
							results: $.map(res.data, function (item) {
								return {
									text: item.nama,
									id: item.id
								}
							})
						};
					},
					// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
				}
			}).on('select2:select', function ({params}) {
				$('#id_ruangan,#id_ruangan_edit').val(params.data.id)
			});

			document.addEventListener('DOMContentLoaded', function () {
				let monthName = "Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember".split('_');
				var calendarEl = document.getElementById('calendar');
				var calendar = new FullCalendar.Calendar(calendarEl, {
					locale: 'id',
					plugins: ['timeGrid', 'dayGrid', 'interaction','googleCalendarPlugin'],
					googleCalendarApiKey: "AIzaSyBb6zaTEuiQnWNcFbo1eY4YhyOoqD9UxBA",
					defaultView: 'dayGridMonth',
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'timeGridWeek,dayGridMonth'
					},
					loading: function (isLoading) {
						console.log(isLoading ? "Sedang meload jadwal" : "Sukses")
					},
					selectable: true,
					selectHelper: true,
					editable: true,
					eventLimit: true,
					eventSources: [
						{
							url: "<?php echo site_url('seminar?m=jadwal') ?>",
							cache: true,
							type: "POST",
							data: {events: true},
							error: function () {
								alert('Gagal akses jadwal seminar');
							}
						},
						{
							googleCalendarId: 'id.indonesian#holiday@group.v.calendar.google.com',
							className: 'bg-warning disabled'
						}
					],
					//events: {
					//	url: "<?php //echo site_url('seminar?m=jadwal') ?>//",
					//	cache: true,
					//	type: "POST",
					//	data: {events: true},
					//	error: function () {
					//		alert('Gagal akses jadwal seminar');
					//	}
					//},
					select: function (info) {
						console.log(info);
					},
					eventRender: function (info) {
						let monthIndex = moment(calendar.getDate()).format('M');
						$('#month-name').text(monthName[monthIndex - 1]);
					},
					dateClick: function (info, jsEvent, view) {
						// if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {
						// This allows today and future date
						let isoDate = info.date.toISOString();
						$('#tanggal-seminar').val(moment(isoDate).format('YYYY-MM-DD'));
						//ajax to update current data
						$.ajax({
							url: '<?php echo site_url("seminar?m=mahasiswa") ?>',
							dataType: 'json',
							success: function ({data}) {
								let parsedData = data;
								if (parsedData.length !== 0) {
									$('#new-event').modal('show');
								} else {
									swal({
										title: 'Error',
										text: 'Semua mahasiswa sudah mendapatkan jadwal seminar',
										type: 'error',
										buttonsStyling: false,
										confirmButtonClass: 'btn btn-primary btn-sm'
									});
								}
							},
							error: function (e) {
								console.log(e)
							}
						});
						// } else {
						//     Else part is for past dates
						// alert('Tidak bisa mengajukan konsultasi pada tanggal ini');
						// }

					},
					eventClick: function (info, element) {
						let {event} = info;
						let mulai = moment(event.start).format('HH:mm:ss');
						let selesai = moment(event.end).format('HH:mm:ss');
						let tanggal = moment(event.start).format('YYYY-MM-DD');
						// $('#edit-event input[value=' + event.tag + ']').prop('checked', true);
						$('#edit-event').modal('show');
						$('.edit-event--id').val(event.id);
						$('#select-mahasiswa-edit').empty().prepend('<option value=' + event.id + '>' + event.title + '</option>');
						$('#select-ruangan-edit').empty().prepend('<option value=' + event.extendedProps.id_tempat + '>' + event.extendedProps.nama_tempat + '</option>');
						$('#select-penguji1-edit').empty().prepend('<option value=' + event.extendedProps.id_penguji_1 + '>' + event.extendedProps.p1 + '</option>');
						$('#select-penguji2-edit').empty().prepend('<option value=' + event.extendedProps.id_penguji_2 + '>' + event.extendedProps.p2 + '</option>');
						$('#id_dosen_bimbingan_mhs_edit').val(event.extendedProps.id_dosen_bimbingan_mhs);
						$('#id_ruangan_edit').val(event.extendedProps.id_tempat);
						$('#id_p1_edit').val(event.extendedProps.id_penguji_1);
						$('#id_p2_edit').val(event.extendedProps.id_penguji_2);
						$('#tanggal-seminar-edit').val(tanggal);
						$('#input-pembimbing-edit').val(event.extendedProps.nama_pembimbing);
						$('#waktu-mulai-edit').val(mulai);
						$('#waktu-selesai-edit').val(selesai);
					},
					eventDrop: function (info) {
						swal({
							title: 'Apakah anda yakin memindah ' + info.event.title + ' ?',
							text: "Pemindahan jadwal bisa di batalkan",
							type: 'warning',
							showCancelButton: true,
							buttonsStyling: false,
							confirmButtonClass: 'btn btn-warning btn-sm',
							confirmButtonText: 'Ya, pindah!',
							cancelButtonClass: 'btn btn-secondary btn-sm'
						}).then((result) => {
							if (result.value) {
								let {event} = info;
								let eventDate = moment(event.start).format('YYYY-MM-DD');
								let eventStart = moment(event.start).format('HH:mm:ss');
								let eventEnd = moment(event.end).format('HH:mm:ss');
								let updateEvent = {
									id: event.id,
									id_dosen_bimbingan_mhs: event.extendedProps.id_dosen_bimbingan_mhs,
									id_seminar_ruangan: event.extendedProps.id_tempat,
									mulai: eventDate + "T" + eventStart,
									berakhir: eventDate + "T" + eventEnd,
									id_penguji: [event.extendedProps.id_penguji_1, event.extendedProps.id_penguji_2]
								};
								$.ajax({
									url: "<?php echo site_url('seminar?m=jadwal&q=u')?>",
									method: "POST",
									data: updateEvent,
									success: function () {
										swal({
											title: 'Success',
											text: 'Jadwal ' + event.title + ' berhasil dibuat',
											type: 'success',
											buttonsStyling: false,
											confirmButtonClass: 'btn btn-primary btn-sm'
										});
									},
									error: function () {
										swal({
											title: 'Error',
											text: 'Jadwal ' + event.title + ' gagal dibuat',
											type: 'error',
											buttonsStyling: false,
											confirmButtonClass: 'btn btn-primary btn-sm'
										});
									}
								});
							} else {
								info.revert();
							}

						})
					},
					eventResize: function (info) {
						swal({
							title: 'Apakah anda yakin mengubah waktu ' + info.event.title + ' ?',
							text: "Pemindahan waktu bisa di batalkan",
							type: 'warning',
							showCancelButton: true,
							buttonsStyling: false,
							confirmButtonClass: 'btn btn-warning btn-sm',
							confirmButtonText: 'Ya, ubah!',
							cancelButtonClass: 'btn btn-secondary btn-sm'
						}).then((result) => {
							if (result.value) {
								let {event} = info;
								let eventDate = moment(event.start).format('YYYY-MM-DD');
								let eventStart = moment(event.start).format('HH:mm:ss');
								let eventEnd = moment(event.end).format('HH:mm:ss');
								let updateEvent = {
									id: event.id,
									id_dosen_bimbingan_mhs: event.extendedProps.id_dosen_bimbingan_mhs,
									id_seminar_ruangan: event.extendedProps.id_tempat,
									mulai: eventDate + "T" + eventStart,
									berakhir: eventDate + "T" + eventEnd,
									id_penguji: [event.extendedProps.id_penguji_1, event.extendedProps.id_penguji_2]
								};
								$.ajax({
									url: "<?php echo site_url('seminar?m=jadwal&q=u')?>",
									method: "POST",
									data: updateEvent,
									success: function () {
										swal({
											title: 'Success',
											text: 'Jadwal ' + event.title + ' berhasil diubah',
											type: 'success',
											buttonsStyling: false,
											confirmButtonClass: 'btn btn-primary btn-sm'
										});
									},
									error: function () {
										swal({
											title: 'Error',
											text: 'Jadwal ' + event.title + ' gagal diubah',
											type: 'error',
											buttonsStyling: false,
											confirmButtonClass: 'btn btn-primary btn-sm'
										});
									}
								});
							} else {
								info.revert();
							}

						})
					}
				});
				calendar.render();
				//Insert an Event
				$('body').on('click', '.new-event--add', function () {
					let eventDate = $('#tanggal-seminar').val();
					let eventStart = $('#waktu-mulai').val();
					let eventEnd = $('#waktu-selesai').val();
					let eventId = $('#id_dosen_bimbingan_mhs').val();
					let eventRuangan = $('#id_ruangan').val();
					let eventPembimbing = $('#input-pembimbing').val();
					let eventPenguji1 = $('#id_p1').val();
					let eventPenguji2 = $('#id_p2').val();
					let mahasiswa = $('#select-mahasiswa').text();
					let ruangan = $('#select-ruangan-edit').text();
					let p1 = $('#select-penguji1-edit').text();
					let p2 = $('#select-penguji2-edit').text();

					// Generate ID
					let GenRandom = {
						Stored: [],
						/**
						 * @return {string}
						 */
						Job: function () {
							let newId = Date.now().toString().substr(6); // or use any method that you want to achieve this string

							if (!this.Check(newId)) {
								this.Stored.push(newId);
								return newId;
							}
							return this.Job();
						},
						/**
						 * @return {boolean}
						 */
						Check: function (id) {
							for (let i = 0; i < this.Stored.length; i++) {
								if (this.Stored[i] === id) return true;
							}
							return false;
						}
					};

					if (eventDate !== '' && eventEnd !== '' && eventStart !== '') {
						let createdEvent = {
							id: GenRandom.Job(),
							id_dosen_bimbingan_mhs: eventId,
							id_seminar_ruangan: eventRuangan,
							mulai: eventDate + "T" + eventStart,
							berakhir: eventDate + "T" + eventEnd,
							id_penguji: [eventPenguji1, eventPenguji2]
						};
						//render event to calendar
						calendar.addEvent({
							title: mahasiswa,
							start: createdEvent.mulai,
							end: createdEvent.berakhir,
							extendedProps: {
								id_tempat: eventRuangan,
								id_penguji_1: eventPenguji1,
								id_penguji_2: eventPenguji2,
								nama_tempat: ruangan,
								nama_pembimbing: eventPembimbing,
								p1: p1,
								p2: p2,
							}
						});
						//push to database
						$.ajax({
							url: "<?php echo site_url('seminar?m=jadwal&q=i')?>",
							method: "POST",
							data: createdEvent,
							success: function () {
								swal({
									title: 'Success',
									text: 'Jadwal ' + mahasiswa + ' berhasil dibuat',
									type: 'success',
									buttonsStyling: false,
									confirmButtonClass: 'btn btn-primary btn-sm'
								});
							},
							error: function () {
								swal({
									title: 'Error',
									text: 'Jadwal ' + mahasiswa + ' gagal dibuat',
									type: 'error',
									buttonsStyling: false,
									confirmButtonClass: 'btn btn-primary btn-sm'
								});
							}
						});
						$('.new-event--form')[0].reset();
						$('.new-event--title').closest('.form-group').removeClass('has-danger');
						$('#new-event').modal('hide');
					} else if (eventDate !== '' || eventEnd !== '' || eventStart !== '') {
						console.log('Lengkapi data');
						$('#tanggal-seminar').closest('.form-group').addClass('has-danger').focus();
						$('#waktu-mulai').closest('.form-group').addClass('has-danger').focus();
						$('#waktu-selesai').closest('.form-group').addClass('has-danger').focus();
						$('#select-ruangan').closest('.form-group').addClass('has-danger').focus();
						$('#select-mahasiswa').closest('.form-group').addClass('has-danger').focus();
						$('#select-penguji1').closest('.form-group').addClass('has-danger').focus();
						$('#select-penguji2').closest('.form-group').addClass('has-danger').focus();
					} else {
						$('.new-event--title').closest('.form-group').addClass('has-danger').focus();
					}
				});


				//Update/Delete an Event
				$('body').on('click', '[data-calendar]', function () {
					let calendarAction = $(this).data('calendar');
					let currentId = $('.edit-event--id').val();
					let eventDate = $('#tanggal-seminar-edit').val();
					let eventStart = $('#waktu-mulai-edit').val();
					let eventEnd = $('#waktu-selesai-edit').val();
					let eventBimbingan = $('#id_dosen_bimbingan_mhs_edit').val();
					let eventRuangan = $('#id_ruangan_edit').val();
					let eventPembimbing = $('#input-pembimbing-edit').val();
					let eventRuanganName = $('#select-ruangan-edit option:selected').text();
					let eventPenguji1 = $('#id_p1_edit').val();
					let eventPenguji2 = $('#id_p2_edit').val();
					let eventPenguji1Name = $('#select-penguji1-edit option:selected').text();
					let eventPenguji2Name = $('#select-penguji2-edit option:selected').text();
					let mahasiswa = $('#select-mahasiswa-edit').text();
					let currentEvent = calendar.getEventById(currentId);
					//Update
					if (calendarAction === 'update') {
						if (currentId !== '') {
							// let data = {"title":currentTitle,"masalah":currentMasalah,"solusi":currentSolusi,"tag":[currentClass]};
							// currentEvent.push(data);
							let updateEvent = {
								id: currentId,
								id_dosen_bimbingan_mhs: eventBimbingan,
								id_seminar_ruangan: eventRuangan,
								mulai: eventDate + "T" + eventStart,
								berakhir: eventDate + "T" + eventEnd,
								id_penguji: [eventPenguji1, eventPenguji2]
							};
							//render event to calendar
							currentEvent.setProp('title', mahasiswa);
							currentEvent.setStart(updateEvent.mulai);
							currentEvent.setEnd(updateEvent.berakhir);
							currentEvent.setExtendedProp('id_tempat', updateEvent.id_seminar_ruangan);
							currentEvent.setExtendedProp('nama_tempat', eventRuanganName);
							currentEvent.setExtendedProp('nama_pembimbing', eventPembimbing);
							currentEvent.setExtendedProp('id_penguji_1', updateEvent.id_penguji[0]);
							currentEvent.setExtendedProp('id_penguji_2', updateEvent.id_penguji[1]);
							currentEvent.setExtendedProp('p1', eventPenguji1Name);
							currentEvent.setExtendedProp('p2', eventPenguji2Name);
							console.log(currentEvent);
							//update rendered item
							//push to database
							$.ajax({
								url: "<?php echo site_url('seminar?m=jadwal&q=u')?>",
								method: "POST",
								data: updateEvent,
								success: function () {
									swal({
										title: 'Success',
										text: 'Jadwal ' + mahasiswa + ' berhasil diupdate',
										type: 'success',
										buttonsStyling: false,
										confirmButtonClass: 'btn btn-primary btn-sm'
									});
								},
								error: function () {
									swal({
										title: 'Error',
										text: 'Jadwal ' + mahasiswa + ' gagal diupdate',
										type: 'error',
										buttonsStyling: false,
										confirmButtonClass: 'btn btn-primary btn-sm'
									});
								}
							});
							$('.edit-event--form')[0].reset();
							$('.edit-event--title').closest('.form-group').removeClass('has-danger');
							$('#edit-event').modal('hide');
						} else {
							$('.edit-event--title').closest('.form-group').addClass('has-error').focus();
						}
					}

					////Delete
					if (calendarAction === 'delete') {
						$('#edit-event').modal('hide');

						// Show confirm dialog
						setTimeout(function () {
							swal({
								title: 'Apakah anda yakin menghapus ini?',
								text: "Jadwal sidang yang sudah hapus tidak bisa dikembalikan lagi",
								type: 'warning',
								showCancelButton: true,
								buttonsStyling: false,
								confirmButtonClass: 'btn btn-danger btn-sm',
								confirmButtonText: 'Yes, hapus!',
								cancelButtonClass: 'btn btn-secondary btn-sm'
							}).then((result) => {
								if (result.value) {
									// Delete event
									currentEvent.remove();
									console.log(currentId);

									// Delete from database
									$.ajax({
										url: "<?php echo site_url('seminar?m=jadwal&q=d')?>",
										method: "POST",
										data: {id: currentId},
										success: function (res) {
											console.log(res);
											swal({
												title: 'Success',
												text: 'Jadwal berhasil dihapus',
												type: 'success',
												buttonsStyling: false,
												confirmButtonClass: 'btn btn-primary btn-sm'
											});
										},
										error: function () {
											swal({
												title: 'Error',
												text: 'Jadwal Gagal dihapus',
												type: 'error',
												buttonsStyling: false,
												confirmButtonClass: 'btn btn-primary btn-sm'
											});
										}
									})
								}
							})
						}, 200);
					}
				});

				//Calendar Next
				$('body').on('click', '.fullcalendar-btn-next', function (e) {
					e.preventDefault();
					calendar.next();
					let monthIndex = moment(calendar.getDate()).format('M');
					$('#month-name').text(monthName[monthIndex - 1])
				});
				//Calendar Prev
				$('body').on('click', '.fullcalendar-btn-prev', function (e) {
					e.preventDefault();
					calendar.prev();
					let monthIndex = moment(calendar.getDate()).format('M');
					$('#month-name').text(monthName[monthIndex - 1])
				});

				$('body').on('click', '#changeView', function () {
					let toggle = $(this).data('view');
					$(this).text(toggle ? "Tampilkan per minggu" : "Tampilkan per bulan");
					let view = !toggle ? 'timeGridWeek' : 'dayGridMonth';
					calendar.changeView(view);
					$(this).data('view', !toggle);
				})

			})
		</script>
	<?php endif; ?>
</body>
</html>
