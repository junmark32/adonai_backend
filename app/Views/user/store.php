<?= $this->include('include/header') ?>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
						<!-- Header -->
<?php if (isset($loggedIn) && $loggedIn): ?>
    <?php
    switch ($role) {
        case 'user':
            echo $this->include('include/navbar_user');
            break;
        case 'admin':
            echo $this->include('include/navbar_admin');
            break;
        case 'doctor':
            echo $this->include('include/navbar_doctor');
            break;
        default:
            // Default case
            break;
    }
    ?>
<?php endif; ?>
			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Store</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Eyewear</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Home Banner -->
			<section class="section section-search">
				<div class="container-fluid">
					<div class="banner-wrapper">
						<div class="banner-header text-center">
							<h1>Find the Perfect Pair of Eyeglasses, Book an Appointment</h1>
							<p>Explore a wide selection of eyeglasses and schedule an appointment at our nearest store.</p>
						</div>
						<div class="banner-header text-center">
						<button type="button" onclick="window.location='<?php echo site_url('/store')?>'" class="btn btn-info">Shop Eyewear</button>

						</div>
                         
						
						
					</div>
				</div>
			</section>
			<!-- /Home Banner -->

			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<!-- <div class="row">
						<div class="col-12">
							<h5>Blank Page</h5>
						</div>
					</div> -->

			<!-- Cards Section -->
			<section class="comp-section comp-cards">
				<div class="row mb-4">
					<!-- Women's Category -->
					<div class="col-12 col-md-6 col-lg-4">
						<div class="comp-header text-center">
							<h3 class="comp-title">Women</h3>
							<div class="line mx-auto"></div>
						</div>
					</div>

					<!-- Men's Category -->
					<div class="col-12 col-md-6 col-lg-4">
						<div class="comp-header text-center">
							<h3 class="comp-title">Men</h3>
							<div class="line mx-auto"></div>
						</div>
					</div>

					<!-- Accessories Category -->
					<div class="col-12 col-md-6 col-lg-4">
						<div class="comp-header text-center">
							<h3 class="comp-title">Accessories</h3>
							<div class="line mx-auto"></div>
						</div>
					</div>
				</div>

				<div class="row">
					<!-- Women's Card -->
					<div class="col-12 col-md-6 col-lg-4 d-flex">
						<div class="card flex-fill">
							<img alt="Women's Collection" src="<?= base_url('uploads/women.jpg' ) ?>" class="card-img-top">
						</div>
					</div>

					<!-- Men's Card -->
					<div class="col-12 col-md-6 col-lg-4 d-flex">
						<div class="card flex-fill">
							<img alt="Men's Collection" src="<?= base_url('uploads/men.jpg' ) ?>" class="card-img-top">
						</div>
					</div>

					<!-- Accessories Card -->
					<div class="col-12 col-md-6 col-lg-4 d-flex">
						<div class="card flex-fill">
							<img alt="Accessories Collection" src="<?= base_url('uploads/accesories.jpg' ) ?>" class="card-img-top">
						</div>
					</div>
				</div>
			</section>


					<div class="row">
						<div class="col-12">
							<h1><strong>PRODUCT OVERVIEW</strong></h1>
						</div>
					</div>

					<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">All Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Women</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">Men</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab4" data-toggle="tab">Accessories</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="bottom-tab1">
                        <div class="row">
                            <!-- Loop through products and generate product cards -->
                            <?php foreach ($products as $product): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card product-card">
                                    <img src="<?= base_url('uploads/' . $product['Image_url']) ?>" class="card-img-top" alt="<?= $product['Name'] ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $product['Name'] ?></h5>
                                        <p class="card-text">₱ <?= $product['Price'] ?></p>
                                        <hr>
                                        <div class="d-flex justify-content-center">
                                            <!-- Update button with product ID as parameter -->
                                            <a href="<?= base_url('/store/product/' . $product['ProductID']) ?>" class="btn btn-rounded btn-outline-primary">Quick View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tab pane for Women -->
                    <div class="tab-pane" id="bottom-tab2">
                        <div class="row">
                            <!-- Loop through products and generate product cards -->
                            <?php foreach ($products as $product): ?>
                                <?php if ($product['Gender'] == 'Women'): ?>
                                    <div class="col-md-3 mb-4">
                                        <div class="card product-card">
                                            <img src="<?= base_url('uploads/' . $product['Image_url']) ?>" class="card-img-top" alt="<?= $product['Name'] ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $product['Name'] ?></h5>
                                                <p class="card-text">₱ <?= $product['Price'] ?></p>
                                                <hr>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Update button with product ID as parameter -->
                                                    <a href="<?= base_url('/store/product/' . $product['ProductID']) ?>" class="btn btn-rounded btn-outline-primary">Quick View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tab pane for Men -->
                    <div class="tab-pane" id="bottom-tab3">
                        <div class="row">
                            <!-- Loop through products and generate product cards -->
                            <?php foreach ($products as $product): ?>
                                <?php if ($product['Gender'] == 'Men'): ?>
                                    <div class="col-md-3 mb-4">
                                        <div class="card product-card">
                                            <img src="<?= base_url('uploads/' . $product['Image_url']) ?>" class="card-img-top" alt="<?= $product['Name'] ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $product['Name'] ?></h5>
                                                <p class="card-text">₱ <?= $product['Price'] ?></p>
                                                <hr>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Update button with product ID as parameter -->
                                                    <a href="<?= base_url('/store/product/' . $product['ProductID']) ?>" class="btn btn-rounded btn-outline-primary">Quick View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Tab pane for Accessories -->
                    <div class="tab-pane" id="bottom-tab4">
                        <div class="row">
                            <!-- Loop through products and generate product cards -->
                            <?php foreach ($products as $product): ?>
                                <?php if ($product['Type'] == 'Accessories'): ?>
                                    <div class="col-md-3 mb-4">
                                        <div class="card product-card">
                                            <img src="<?= base_url('uploads/' . $product['Image_url']) ?>" class="card-img-top" alt="<?= $product['Name'] ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $product['Name'] ?></h5>
                                                <p class="card-text">₱ <?= $product['Price'] ?></p>
                                                <hr>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Update button with product ID as parameter -->
                                                    <a href="<?= base_url('/store/product/' . $product['ProductID']) ?>" class="btn btn-rounded btn-outline-primary">Quick View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        swal({
            title: "Success!",
            text: "<?= session()->getFlashdata('success') ?>",
            type: "success",
            confirmButtonText: "OK"
        });
    </script>
<?php elseif (session()->getFlashdata('error')) : ?>
    <script>
        swal({
            title: "Error!",
            text: "<?= session()->getFlashdata('error') ?>",
            type: "error",
            confirmButtonText: "OK"
        });
    </script>
<?php endif; ?>


				</section>
				<!-- End Bottom Tabs Section -->




						
						<!-- /Cards -->
				</div>
			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img src="assets/img/footer-logo.png" alt="logo">
									</div>
									<div class="footer-about-content">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<div class="social-icon">
											<ul>
												<li>
													<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Patients</h2>
									<ul>
										<li><a href="search.html"><i class="fas fa-angle-double-right"></i> Search for Doctors</a></li>
										<li><a href="login.html"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="register.html"><i class="fas fa-angle-double-right"></i> Register</a></li>
										<li><a href="booking.html"><i class="fas fa-angle-double-right"></i> Booking</a></li>
										<li><a href="patient-dashboard.html"><i class="fas fa-angle-double-right"></i> Patient Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Doctors</h2>
									<ul>
										<li><a href="appointments.html"><i class="fas fa-angle-double-right"></i> Appointments</a></li>
										<li><a href="chat.html"><i class="fas fa-angle-double-right"></i> Chat</a></li>
										<li><a href="login.html"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="doctor-register.html"><i class="fas fa-angle-double-right"></i> Register</a></li>
										<li><a href="doctor-dashboard.html"><i class="fas fa-angle-double-right"></i> Doctor Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> 3556  Beech Street, San Francisco,<br> California, CA 94108 </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											+1 315 369 5943
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											doccure@example.com
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0"><a href="templateshub.net">Templates Hub</a></p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="term-condition.html">Terms and Conditions</a></li>
											<li><a href="privacy-policy.html">Policy</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/blank-page.html  30 Nov 2019 04:12:20 GMT -->
</html>