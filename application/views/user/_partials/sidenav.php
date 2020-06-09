<?php $this->load->helper('master');
$id = $this->session->userdata('id');
$level = $this->session->userdata('level');
$menus = getmenu($level);
if($level == 'mahasiswa'){
	$mahasiswa = masterdata('tb_mahasiswa', array('nim' => $id), array('alamat_mhs', 'email_mhs', 'jenis_kelamin_mhs'), false);
}

?>
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scroll-wrapper scrollbar-inner" style="position: relative;">
		<div class="scrollbar-inner scroll-content scroll-scrollx_visible scroll-scrolly_visible"
			 style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 140px;">
			<!-- Brand -->
			<div class="sidenav-header d-flex align-items-center">
				<a class="navbar-brand" href="<?php echo site_url('main') ?>">
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
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('user') ?>">
								<i class="ni ni-badge text-primary"></i>
								<span class="nav-link-text">Home</span>
							</a>
						</li>
						<?php if (isset($mahasiswa)): ?>
							<?php if ($mahasiswa->alamat_mhs != null || $mahasiswa->email_mhs != null || $mahasiswa->jenis_kelamin_mhs != null): ?>
								<?php foreach ($menus as $menu): ?>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo $menu->href ?>">
											<i class="ni ni-<?php echo $menu->icon ?> text-<?php echo $menu->color ?>"></i>
											<span class="nav-link-text"><?php echo $menu->name ?></span>
										</a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ($level == 'dosen'): ?>
								<?php foreach ($menus as $menu): ?>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo $menu->href ?>">
											<i class="ni ni-<?php echo $menu->icon ?> text-<?php echo $menu->color ?>"></i>
											<span class="nav-link-text"><?php echo $menu->name ?></span>
										</a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php if ($level == 'peserta'): ?>
								<?php foreach ($menus as $menu): ?>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo $menu->href ?>">
											<i class="ni ni-<?php echo $menu->icon ?> text-<?php echo $menu->color ?>"></i>
											<span class="nav-link-text"><?php echo $menu->name ?></span>
										</a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
					</ul>
					<!-- Divider -->
					<hr class="my-3">
					<!-- Heading -->
					<h6 class="navbar-heading p-0 text-muted">Bantuan</h6>
					<!-- Navigation -->
					<ul class="navbar-nav mb-md-3">
						<?php if ($level == 'mahasiswa'): ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('blog/home') ?>" target="_blank">
								<i class="ni ni-support-16"></i>
								<span class="nav-link-text">Informasi</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo site_url('blog/download') ?>" target="_blank">
								<i class="ni ni-archive-2"></i>
								<span class="nav-link-text">Download Berkas</span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
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
