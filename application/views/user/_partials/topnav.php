<?php
$this->load->helper('notification_helper');
$nickname = 'User';
if ($_SESSION['level'] == 'mahasiswa') {
	$nim = $this->session->userdata('id');
	$user = masterdata('tb_mahasiswa', "nim = '$nim'", 'nama_mahasiswa');
	$exploded_user = explode(" ", $user->nama_mahasiswa);
	$nickname = $exploded_user[0];
}
if ($_SESSION['level'] == 'dosen') {
	$id = $this->session->userdata('nip_nik');
	$pegawai = masterdata('tb_pegawai', "nip_nik = '$id'", 'nama_pegawai', false);
	$nickname = $pegawai->nama_pegawai;
}
if ($_SESSION['level'] == 'peserta') {
	$nimpes = $this->session->userdata('id');
	$user = masterdata('tb_peserta', "nimpes = '$nimpes'", 'namapes');
	$exploded_user = explode(" ", $user->namapes);
	$nickname = $exploded_user[0];
}
$countNotification = count_notification($this->session->userdata('id'), 0);
$dataNotification = get_notification($this->session->userdata('id'), 0);
$level = $this->session->userdata('level');
?>
<nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom">
	<div class="container-fluid">
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Search form -->
			<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
				<div class="form-group mb-0">
					<div class="input-group input-group-alternative input-group-merge">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-search"></i></span>
						</div>
						<input class="form-control" placeholder="Search" type="text">
					</div>
				</div>
				<button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
						aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</form>
			<!-- Navbar links -->
			<ul class="navbar-nav align-items-center ml-md-auto">
				<li class="nav-item d-xl-none">
					<!-- Sidenav toggler -->
					<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
						 data-target="#sidenav-main">
						<div class="sidenav-toggler-inner">
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
						</div>
					</div>
				</li>
				<li class="nav-item d-sm-none">
					<a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
						<i class="ni ni-zoom-split-in"></i>
					</a>
				</li>
				<li class="nav-item d-none d-lg-block ml-lg-4">
					<!-- <a href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank" class="btn btn-neutral btn-icon">
                        <span class="btn-inner--icon">
                            <i class="fas fa-shopping-cart mr-2"></i>
                        </span>
                        <span class="nav-link-inner--text">Purchase now</span>
                    </a> -->
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
					   aria-expanded="false" <?php if (isset($intro_dashboard)) echo isset($intro) ? "data-step='" . $intro[0]['step_intro'] . "'" : null ?>
						<?php if (isset($intro_dashboard)) echo isset($intro) ? "data-intro='" . $intro[0]['message_intro'] . "'" : null ?>>
						<i class="ni ni-bell-55"></i>
						<?php $countNotif = isset($countNotification) ? $countNotification : 0;
						if ($countNotif > 0):?>
							<span
								class="pulsate badge badge-circle badge-floating badge-danger border-white badge-top-right"><?php echo $countNotif ?></span>
						<?php endif; ?>
					</a>

					<div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
						<!-- Dropdown header -->
						<div class="px-3 py-3 d-flex justify-content-between">
							<h6 class="text-sm text-muted m-0">You have <strong
									class="text-primary"><?php echo isset($countNotification) ? $countNotification : 0 ?></strong>
								notifications.</h6>
							<a href="<?php echo site_url('dashboard/clearnotif')?>" class="text-sm text-muted m-0">Clear All Notifications</a>
						</div>
						<!-- List group -->
						<div <?php echo count($dataNotification) > 3 ? 'style="height: 350px;overflow: scroll;"' : null ?>
							class="list-group list-group-flush">
							<?php foreach ($dataNotification as $notification): ?>
								<a href="<?php echo $notification->uri ? site_url($notification->uri) : '#' ?>"
								   class="list-group-item list-group-item-action">
									<div class="row align-items-center">
										<div class="col-auto">
											<!-- Avatar -->
										</div>
										<div class="col ml--2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<h4 class="mb-0 text-sm"><?php echo $notification->pengirim ?></h4>
												</div>
												<div class="text-right text-muted">
													<small><?php echo timediff_notification($notification->waktu) ?></small>
												</div>
											</div>
											<p class="text-sm mb-0"><?php echo $notification->pesan ?></p>
										</div>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
						<!-- View all
						<a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a> -->
					</div>
				</li>
				<!--				<li class="nav-item dropdown">-->
				<!--					<a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"-->
				<!--						aria-expanded="false">-->
				<!--						<i class="ni ni-ungroup"></i>-->
				<!--					</a>-->
				<!--					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">-->
				<!--						<div class="row shortcuts px-4">-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-red">-->
				<!--									<i class="ni ni-calendar-grid-58"></i>-->
				<!--								</span>-->
				<!--								<small>Calendar</small>-->
				<!--							</a>-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-orange">-->
				<!--									<i class="ni ni-email-83"></i>-->
				<!--								</span>-->
				<!--								<small>Email</small>-->
				<!--							</a>-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-info">-->
				<!--									<i class="ni ni-credit-card"></i>-->
				<!--								</span>-->
				<!--								<small>Payments</small>-->
				<!--							</a>-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-green">-->
				<!--									<i class="ni ni-books"></i>-->
				<!--								</span>-->
				<!--								<small>Reports</small>-->
				<!--							</a>-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-purple">-->
				<!--									<i class="ni ni-pin-3"></i>-->
				<!--								</span>-->
				<!--								<small>Maps</small>-->
				<!--							</a>-->
				<!--							<a href="#!" class="col-4 shortcut-item">-->
				<!--								<span class="shortcut-media avatar rounded-circle bg-gradient-yellow">-->
				<!--									<i class="ni ni-basket"></i>-->
				<!--								</span>-->
				<!--								<small>Shop</small>-->
				<!--							</a>-->
				<!--						</div>-->
				<!--					</div>-->
				<!--				</li>-->
			</ul>
			<ul class="navbar-nav align-items-center ml-auto ml-md-0">
				<li class="nav-item dropdown">
					<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
					   aria-expanded="false">
						<div
							class="media align-items-center" <?php if (isset($intro_dashboard)) echo isset($intro) ? "data-step='" . $intro[1]['step_intro'] . "'" : null ?>
							<?php if (isset($intro_dashboard)) echo isset($intro) ? "data-intro='" . $intro[0]['message_intro'] . "'" : null ?>>
							<span class="avatar avatar-sm rounded-circle">
								<img alt="Image placeholder" src="https://randomuser.me/api/portraits/lego/5.jpg">
							</span>
							<div class="media-body ml-2 d-none d-lg-block">
								<span class="mb-0 text-sm  font-weight-bold"><?php echo $nickname ?></span>
							</div>
						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="dropdown-header noti-title">
							<h6 class="text-overflow m-0">Welcome! <?php echo $nickname ?></h6>
						</div>
						<?php if ($level == 'mahasiswa'): ?>
							<a href="<?php echo site_url('user/profile') ?>" class="dropdown-item">
								<i class="ni ni-single-02"></i>
								<span>My profile</span>
							</a>
						<?php endif; ?>
						<!--						<a href="#!" class="dropdown-item">-->
						<!--							<i class="ni ni-settings-gear-65"></i>-->
						<!--							<span>Settings</span>-->
						<!--						</a>-->
						<!--						<a href="#!" class="dropdown-item">-->
						<!--							<i class="ni ni-calendar-grid-58"></i>-->
						<!--							<span>Activity</span>-->
						<!--						</a>-->
						<!--						<a href="#!" class="dropdown-item">-->
						<!--							<i class="ni ni-support-16"></i>-->
						<!--							<span>Support</span>-->
						<!--						</a>-->
						<div class="dropdown-divider"></div>
						<a href="<?php echo site_url('user/logout') ?>" class="dropdown-item">
							<i class="ni ni-user-run"></i>
							<span>Logout</span>
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
