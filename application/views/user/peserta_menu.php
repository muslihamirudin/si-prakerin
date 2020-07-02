<!DOCTYPE html>
<html>

<!-- Head PHP -->
<?php  $this->load->view('user/_partials/header.php');?>

<body>
	<!-- Sidenav PHP-->
	<?php $this->load->view('user/_partials/sidenav.php');?>
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
			<!-- Card -->
			<div class="header-body">
				<!-- Card stats -->
				<div class="row">
					<?php foreach ($menus as $menu):?>
					<div class="col-xl-4 col-lg-6 col-sm-12">
						<div class="card card-stats mb-4 mb-xl-0 my-3">
							<a href="<?php echo $menu['href'] ?>">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0"><?php echo $this->uri->segment(1)?></h5>
											<span class="h2 font-weight-bold mb-0"><?php echo $menu['name']?></span>
										</div>
										<div class="col-auto">
											<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
												<i class="<?php echo $menu['icon']?>"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-muted text-sm">
										<span class="text-wrap"><?php echo $menu['desc']?></span>
									</p>
								</div>
							</a>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			<!-- Footer PHP -->
			<?php $this->load->view('user/_partials/footer.php');?>
		</div>
	</div>
	<!-- Scripts PHP-->
	<?php $this->load->view('user/_partials/modal.php');?>
	<?php $this->load->view('user/_partials/js.php');?>
	<?php
//	require APPPATH."libraries/hotreloader.php";
//	$reloader = new HotReloader();
//	$reloader->setRoot(__DIR__);
//	$reloader->currentConfig();
//	$reloader->init();
	?>
	<!-- Demo JS - remove this in your project -->
	<!-- <script src="../aset/js/demo.min.js"></script> -->
</body>

</html>
