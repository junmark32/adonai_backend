<!DOCTYPE html> 
<html lang="en">
	
<!-- doccure/blank-page.html  30 Nov 2019 04:12:20 GMT -->
<head>
		<meta charset="utf-8">
		<title>Doccure</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/css/fontawesome.min.css')?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome/css/all.min.css')?>">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	
	</head>
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
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Blank Page</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Blank Page</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<h5>Blank Page</h5>
						</div>
					</div>
				</div>

                <div class="col-lg-12">
    <div class="product-slider slider">
        <!-- Product Widget -->
        <div class="profile-widget">
            <div class="row">
                <!-- Image column -->
                <div class="col-lg-6">
                    <div class="prod-img">
                        <img class="img-fluid" alt="Product Image" src="<?= base_url('uploads/' . $product['Image_url']) ?>" >
                    </div>
                </div>
                <!-- Content column -->
                <div class="col-lg-6">
                    <div class="pro-content">
                        <h1>
                            <?= $product['Name'] ?> . <?= $product['Type'] ?>
                        </h1>
                        <h3><?= $product['Gender'] ?></h3>
                        <hr>
                        <h4>
                            ₱<?= $product['Price'] ?>
                        </h4>
                        <ul class="available-info">
                            <li>
                                <i class="fas fa-box"></i> <?= $product['StockQuantity'] ?> in stock
                            </li>
                        </ul>
                        <form action="<?= site_url('/store/cart/addToCart') ?>" method="post">
                            
                            <input type="hidden" name="productID" value="<?= $product['ProductID'] ?>">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">LENSES:</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="lensID">
                                        <?php foreach ($lens as $lensItem): ?>
                                            <option value="<?= $lensItem['LensID'] ?>">
                                                <?= $lensItem['Brand'] . " " . $lensItem['Model'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Quantity:</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" name="quantity" value="1" min="1" max="<?= $product['StockQuantity'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Product Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Brand</th>
                                                    <td><?= $product['Brand'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Face Shape</th>
                                                    <td><?= $product['Faceshape'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Frame Shape</th>
                                                    <td><?= $product['Frameshape'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Material</th>
                                                    <td><?= $product['Material'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td><?= $product['Gender'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Frame Age</th>
                                                    <td><?= $product['Frameage'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Frame Size (mm)</th>
                                                    <td><?= $product['Framesize'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Full Frame Size (mm)</th>
                                                    <td><?= $product['Fullframesize'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nose Bridge Size (mm)</th>
                                                    <td><?= $product['Nosebridgesize'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Temple Size (mm)</th>
                                                    <td><?= $product['Templesize'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Note</th>
                                                    <td><?= $product['Note'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <hr>
            

        </div>
        <!-- /Product Widget -->
    </div>
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
		<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/blank-page.html  30 Nov 2019 04:12:20 GMT -->
</html>