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
	<div class="container-fluid mt--6">
		<!-- Card -->
		<div class="header-body">
			<!-- Card stats -->
			<div class="row" id="row-calendar">
				<div class="col">
					<div class="card card-calendar"
						 data-step="<?php echo isset($intro) ? $intro[0]['step_intro'] : null ?>"
						 data-intro="<?php echo isset($intro) ? $intro[0]['message_intro'] : null ?>">
						<div class="card-header">
							<!-- Title -->
							<div class="row">
								<div class="col-md-8 col-sm-8">
									<h5 class="h3 mb-0">Kalender Jadwal</h5>
									<small>* Pilih untuk melihat detail jadwal</small><br>
								</div>
								<div class="col-md-4 col-sm-4 text-right">
									<h6 class="h3 d-inline-block mb-0 mr-2" id="fullcalendar-title"></h6>
									<a href="#" class="fullcalendar-btn-prev btn btn-sm btn-primary">
										<i class="fas fa-angle-left"></i>&nbsp;Previous
									</a>
									<a href="#" class="fullcalendar-btn-next btn btn-sm btn-primary">
										Next&nbsp;<i class="fas fa-angle-right"></i>
									</a><br>
								</div>
							</div>
							<div class="row">
								<div class="col-xm-12 col-sm-6 col-md-6 text-left">
									<div class="h5 mt-2">Lihat jadwal berdasarkan :</div>
									<div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-sm btn-primary"
												data-calendar-view="listWeek" id="btn-list">List
										</button>
										<button type="button" class="btn btn-sm btn-primary active"
												data-calendar-view="month" id="btn-bulan">Bulan
										</button>
										<button type="button" class="btn btn-sm btn-primary"
												data-calendar-view="timelineDay" id="btn-ruangan">Ruangan
										</button>
									</div>
								</div>
								<?php if ($this->session->userdata('level') == "mahasiswa"): ?>
									<div class="col-xm-12 col-sm-6 col-md-6 text-right">
										<div class="h5 mt-2">Lihat jadwal sendiri :</div>
										<button type="button" class="btn btn-sm btn-warning" id="btn-hari">Lihat
										</button>
										<?php var_dump($jadwalku) ?>
									</div>
								<?php endif; ?>
								<?php if ($this->session->userdata('level') == "dosen"): ?>
									<div class="col-xm-12 col-sm-6 col-md-6 text-right">
										<div class="h5 mt-2">Lihat jadwal berdasarkan :</div>
										<div class="btn-group" role="group" aria-label="Basic example">
											<a href="<?php echo site_url('sidang?m=jadwal&filter=semua') ?>"
											   class="btn btn-sm btn-info <?php echo (isset($_GET['filter']) and $_GET['filter'] == 'semua') ? 'active' : null ?> <?php echo !isset($_GET['filter']) ? 'active' : null ?>"
											   id="btn-semua">Semua
											</a>
											<a href="<?php echo site_url('sidang?m=jadwal&filter=penguji') ?>"
											   class="btn btn-sm btn-info <?php echo (isset($_GET['filter']) and $_GET['filter'] == 'penguji') ? 'active' : null ?>"
											   id="btn-penguji">
												Sebagai Penguji
											</a>
											<a href="<?php echo site_url('sidang?m=jadwal&filter=pembimbing') ?>"
											   class="btn btn-sm btn-info <?php echo (isset($_GET['filter']) and $_GET['filter'] == 'pembimbing') ? 'active' : null ?>"
											   id="btn-penguji">
												Sebagai Pembimbing
											</a>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="calendar" id="calendar" data-toggle="calendar-seminar"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer PHP -->
		<?php $this->load->view('user/_partials/footer.php'); ?>

	</div>
	<?php $this->load->view('user/_partials/modal_view_event.php') ?>
</div>
<!-- Scripts PHP-->
<?php $this->load->view('user/_partials/js.php'); ?>
<script src="<?php echo base_url('aset/vendor/fullcalendar/fullcalendar.min.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/fullcalendar/scheduler.min.js') ?>"></script>
<script src="<?php echo base_url('aset/vendor/fullcalendar/locale-all.js') ?>"></script>

<script>
	$(document).ready(function () {
		let bimbinganMode = '';
		if (!localStorage.getItem('bimbingan_konsultasi')) {
			introJs().start().oncomplete(function () {
				localStorage.setItem('bimbingan_konsultasi', 'yes');
			}).onexit(function () {
				localStorage.setItem('bimbingan_konsultasi', 'yes');
			})
		}
	});
	var Fullcalendar = (function () {

		let $calendar = $('[data-toggle="calendar-seminar"]');
		let filter = '<?php echo isset($_GET['filter']) ? $_GET['filter'] : 'semua' ?>';

		function init($this) {

			options = {
				schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
				locale: 'id',
				header: {
					right: '',
					center: '',
					left: ''
				},
				buttonIcons: {
					prev: 'calendar--prev',
					next: 'calendar--next'
				},
				theme: false,
				selectable: true,
				selectHelper: true,
				editable: false,
				resourceColumns: [
					{
						labelText: 'Ruangan',
						field: 'title'
					}
				],
				resources: <?php echo json_encode(isset($tempat) ? $tempat : array()) ?>,
				eventLimit: true,
				events: {
					url: "<?php echo site_url('seminar?m=jadwal')?>",
					cache: true,
					type: "POST",
					data: {id: "<?php echo $this->session->userdata('id') ?>", view: "list", filter: filter},
					error: function () {
						alert('Gagal akses data jadwal');
					}
				},
				viewRender: function (view) {
					var calendarDate = $this.fullCalendar('getDate');
					var calendarMonth = calendarDate.month();

					//Set data attribute for header. This is used to switch header images using css
					// $this.find('.fc-toolbar').attr('data-calendar-month', calendarMonth);

					//Set title in page header
					$('#fullcalendar-title').text(view.title);
				},

				// Edit calendar event action

				eventClick: function (event, element) {
					console.log(event);
					$('#view-event').modal('show');
					let timeRange = moment(event.start._i).locale('id').format('HH:mm') + ' - ' + moment(event.end._i).format('HH:mm');
					let date = moment(event.start._i).locale('id').format('LL');
					$('#detail-jadwal').text('Detail jadwal ' + event.title);
					$('#detail-tanggal').text(date);
					$('#detail-ruangan').text(event.nama_tempat);
					$('#detail-waktu').text(timeRange);
					$('#detail-pembimbing').text(event.nama_pembimbing);
					$('#detail-p1').text(event.p1 ? event.p1 : '-');
					$('#detail-p2').text(event.p2 ? event.p2 : '-');
				}
			};

			// Initalize the calendar plugin
			$this.fullCalendar(options);

			//Calendar views switch
			$('body').on('click', '[data-calendar-view]', function (e) {
				e.preventDefault();

				$('[data-calendar-view]').removeClass('active');
				$(this).addClass('active');

				var calendarView = $(this).attr('data-calendar-view');
				$this.fullCalendar('changeView', calendarView);
			});
			window.mobilecheck = function () {
				var check = false;
				(function (a) {
					if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
				})(navigator.userAgent || navigator.vendor || window.opera);
				return check;
			};
			$(document).ready(function () {
				let viewCalendar = window.mobilecheck() ? 'listWeek' : 'month';
				$this.fullCalendar('changeView', viewCalendar);
			})

			//Calendar Next
			$('body').on('click', '.fullcalendar-btn-next', function (e) {
				e.preventDefault();
				$this.fullCalendar('next');
			});


			//Calendar Prev
			$('body').on('click', '.fullcalendar-btn-prev', function (e) {
				e.preventDefault();
				$this.fullCalendar('prev');
			});
			$('body').on('click', '#btn-hari', function (e) {
				e.preventDefault();
				let eventId = "<?php echo (isset($jadwalku) and count($jadwalku) != 0) ? $jadwalku[0]->id : null; ?>";
				let events = $this.fullCalendar('clientEvents', parseInt(eventId));
				console.log(events);
				if (events.length !== 0) {
					let event = events[0];
					let timeRange = moment(event.start._i).locale('id').format('HH:mm') + ' - ' + moment(event.end._i).format('HH:mm');
					let date = moment(event.start._i).locale('id').format('LL');
					$('#detail-jadwal').text('Detail jadwal ' + event.title);
					$('#detail-tanggal').text(date);
					$('#detail-waktu').text(timeRange);
					$('#detail-ruangan').text(event.nama_tempat);
					$('#detail-pembimbing').text(event.nama_pembimbing);
					$('#detail-p1').text(event.p1 ? event.p1 : '-');
					$('#detail-p2').text(event.p2 ? event.p2 : '-');
					$('#view-event').modal('show');
				} else {
					swal({
						title: "Jadwal anda belum tersedia",
						type: "warning",
						buttonsStyling: false,
						confirmButtonClass: 'btn btn-danger'
					})
				}
			})
		}


		//
		// Events
		//

		// Init
		if ($calendar.length) {
			init($calendar);
		}

	})();
</script>
<!-- Demo JS - remove this in your project -->
<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
