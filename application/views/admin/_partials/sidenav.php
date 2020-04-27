<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scroll-wrapper scrollbar-inner" style="position: relative;">
		<div class="scrollbar-inner scroll-content scroll-scrollx_visible scroll-scrolly_visible"
			 style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 140px;">
			<!-- Brand -->
			<div class="sidenav-header d-flex align-items-center">
				<a class="navbar-brand" href="<?php echo site_url('dashboard') ?>">
					<img src="<?php echo base_url('aset/img/brand/simblue.png') ?> " class="navbar-brand-img"
						 alt="...">
				</a>
				<div class="ml-auto">
					<!-- Sidenav toggler -->
					<div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
						 data-target="#sidenav-main">
						<div class="sidenav-toggler-inner">
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
							<i class="sidenav-toggler-line"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="navbar-inner">
				<!-- Collapse -->
				<div class="collapse navbar-collapse" id="sidenav-collapse-main">
					<!-- Nav items -->
					<ul class="navbar-nav">
						<?php if (!isset($development)): ?>
							<li class="nav-item">
								<a class="nav-link active" href="<?php echo site_url('dashboard') ?>">
									<i class="fas fa-tachometer-alt text-primary"></i>
									<span class="nav-link-text">Dashboards</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#navbar-master" data-toggle="collapse" role="button"
								   aria-expanded="false" aria-controls="navbar-master">
									<i class="fas fa-database text-orange"></i>
									<span class="nav-link-text">Master</span>
								</a>
								<div class="collapse" id="navbar-master">
									<ul class="nav nav-sm flex-column">
										<li class="nav-item">
											<a href="<?php echo site_url('tahunakademik') ?>" class="nav-link">Tahun
												Akademik</a>
										</li>
										<li class="nav-item">
											<a href="<?php echo site_url('prodi') ?>" class="nav-link">Program Studi</a>
										</li>
										<li class="nav-item">
											<a href="<?php echo site_url('surat') ?>" class="nav-link">Surat</a>
										</li>
										<li class="nav-item">
											<a href="<?php echo site_url('sync') ?>" class="nav-link">Sinkronasi
												Pegawai</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('perusahaan') ?>">
									<i class="fas fa-industry text-info"></i>
									<span class="nav-link-text">Perusahaan</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('mahasiswa') ?>">
									<i class="fas fa-user-graduate text-primary"></i>
									<span class="nav-link-text">Mahasiswa</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('dosen') ?>">
									<i class="fas fa-university text-danger"></i>
									<span class="nav-link-text">Dosen</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('seminar') ?>">
									<i class="fas fa-calendar-alt text-green"></i>
									<span class="nav-link-text">Seminar</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('rekap') ?>">
									<i class="fas fa-file-alt text-danger"></i>
									<span class="nav-link-text">Rekap</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('akun') ?>">
									<i class="fas fa-user text-primary"></i>
									<span class="nav-link-text">Akun</span>
								</a>
							</li>
						<?php endif; ?>
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button"-->
						<!--								aria-expanded="false" aria-controls="navbar-examples">-->
						<!--								<i class="ni ni-ungroup text-orange"></i>-->
						<!--								<span class="nav-link-text">Examples</span>-->
						<!--							</a>-->
						<!--							<div class="collapse" id="navbar-examples">-->
						<!--								<ul class="nav nav-sm flex-column">-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/pricing.html" class="nav-link">Pricing</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/login.html" class="nav-link">Login</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/register.html" class="nav-link">Register</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/lock.html" class="nav-link">Lock</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/timeline.html" class="nav-link">Timeline</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/examples/profile.html" class="nav-link">Profile</a>-->
						<!--									</li>-->
						<!--								</ul>-->
						<!--							</div>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button"-->
						<!--								aria-expanded="false" aria-controls="navbar-components">-->
						<!--								<i class="ni ni-ui-04 text-info"></i>-->
						<!--								<span class="nav-link-text">Components</span>-->
						<!--							</a>-->
						<!--							<div class="collapse" id="navbar-components">-->
						<!--								<ul class="nav nav-sm flex-column">-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/buttons.html" class="nav-link">Buttons</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/cards.html" class="nav-link">Cards</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/grid.html" class="nav-link">Grid</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/notifications.html"-->
						<!--											class="nav-link">Notifications</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/icons.html" class="nav-link">Icons</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/components/typography.html" class="nav-link">Typography</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="#navbar-multilevel" class="nav-link" data-toggle="collapse"-->
						<!--											role="button" aria-expanded="true" aria-controls="navbar-multilevel">Multi-->
						<!--											level</a>-->
						<!--										<div class="collapse show" id="navbar-multilevel" style="">-->
						<!--											<ul class="nav nav-sm flex-column">-->
						<!--												<li class="nav-item">-->
						<!--													<a href="#!" class="nav-link ">Third level menu</a>-->
						<!--												</li>-->
						<!--												<li class="nav-item">-->
						<!--													<a href="#!" class="nav-link ">Just another link</a>-->
						<!--												</li>-->
						<!--												<li class="nav-item">-->
						<!--													<a href="#!" class="nav-link ">One last link</a>-->
						<!--												</li>-->
						<!--											</ul>-->
						<!--										</div>-->
						<!--									</li>-->
						<!--								</ul>-->
						<!--							</div>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button"-->
						<!--								aria-expanded="false" aria-controls="navbar-forms">-->
						<!--								<i class="ni ni-single-copy-04 text-pink"></i>-->
						<!--								<span class="nav-link-text">Forms</span>-->
						<!--							</a>-->
						<!--							<div class="collapse" id="navbar-forms">-->
						<!--								<ul class="nav nav-sm flex-column">-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/forms/elements.html" class="nav-link">Elements</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/forms/components.html" class="nav-link">Components</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/forms/validation.html" class="nav-link">Validation</a>-->
						<!--									</li>-->
						<!--								</ul>-->
						<!--							</div>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button"-->
						<!--								aria-expanded="false" aria-controls="navbar-tables">-->
						<!--								<i class="ni ni-align-left-2 text-default"></i>-->
						<!--								<span class="nav-link-text">Tables</span>-->
						<!--							</a>-->
						<!--							<div class="collapse" id="navbar-tables">-->
						<!--								<ul class="nav nav-sm flex-column">-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/tables/tables.html" class="nav-link">Tables</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/tables/sortable.html" class="nav-link">Sortable</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/tables/datatables.html" class="nav-link">Datatables</a>-->
						<!--									</li>-->
						<!--								</ul>-->
						<!--							</div>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button"-->
						<!--								aria-expanded="false" aria-controls="navbar-maps">-->
						<!--								<i class="ni ni-map-big text-primary"></i>-->
						<!--								<span class="nav-link-text">Maps</span>-->
						<!--							</a>-->
						<!--							<div class="collapse" id="navbar-maps">-->
						<!--								<ul class="nav nav-sm flex-column">-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/maps/google.html" class="nav-link">Google</a>-->
						<!--									</li>-->
						<!--									<li class="nav-item">-->
						<!--										<a href="../../pages/maps/vector.html" class="nav-link">Vector</a>-->
						<!--									</li>-->
						<!--								</ul>-->
						<!--							</div>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="../../pages/widgets.html">-->
						<!--								<i class="ni ni-archive-2 text-green"></i>-->
						<!--								<span class="nav-link-text">Widgets</span>-->
						<!--							</a>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="../../pages/charts.html">-->
						<!--								<i class="ni ni-chart-pie-35 text-info"></i>-->
						<!--								<span class="nav-link-text">Charts</span>-->
						<!--							</a>-->
						<!--						</li>-->
						<!--						<li class="nav-item">-->
						<!--							<a class="nav-link" href="../../pages/calendar.html">-->
						<!--								<i class="ni ni-calendar-grid-58 text-red"></i>-->
						<!--								<span class="nav-link-text">Calendar</span>-->
						<!--							</a>-->
						<!--						</li>-->
					</ul>
					<!-- Divider -->
					<hr class="my-3">
					<!-- Heading -->
					<!--<h6 class="navbar-heading p-0 text-muted">Documentation</h6>-->
					<!-- Navigation -->
<!--					<ul class="navbar-nav mb-md-3">-->
<!--						<li class="nav-item">-->
<!--							<a class="nav-link" href="../../docs/getting-started/overview.html" target="_blank">-->
<!--								<i class="ni ni-spaceship"></i>-->
<!--								<span class="nav-link-text">Getting started</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a class="nav-link" href="../../docs/foundation/colors.html" target="_blank">-->
<!--								<i class="ni ni-palette"></i>-->
<!--								<span class="nav-link-text">Foundation</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a class="nav-link" href="../../docs/components/alerts.html" target="_blank">-->
<!--								<i class="ni ni-ui-04"></i>-->
<!--								<span class="nav-link-text">Components</span>-->
<!--							</a>-->
<!--						</li>-->
<!--						<li class="nav-item">-->
<!--							<a class="nav-link" href="../../docs/plugins/charts.html" target="_blank">-->
<!--								<i class="ni ni-chart-pie-35"></i>-->
<!--								<span class="nav-link-text">Plugins</span>-->
<!--							</a>-->
<!--						</li>-->
<!--					</ul>-->
				</div>
			</div>
		</div>
		<div class="scroll-element scroll-x scroll-scrollx_visible scroll-scrolly_visible">
			<div class="scroll-element_outer">
				<div class="scroll-element_size"></div>
				<div class="scroll-element_track"></div>
				<div class="scroll-bar" style="width: 45px; left: 0px;"></div>
			</div>
		</div>
		<div class="scroll-element scroll-y scroll-scrollx_visible scroll-scrolly_visible">
			<div class="scroll-element_outer">
				<div class="scroll-element_size"></div>
				<div class="scroll-element_track"></div>
				<div class="scroll-bar" style="height: 23px; top: 0px;"></div>
			</div>
		</div>
	</div>
</nav>
