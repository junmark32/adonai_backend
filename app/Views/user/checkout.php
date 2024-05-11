<!DOCTYPE html> 
<html lang="en">
	
<!-- doccure/checkout.html  30 Nov 2019 04:12:16 GMT -->
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
			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Checkout</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Checkout</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-md-7 col-lg-8">
							<div class="card">
								<div class="card-body">
								
									<!-- Checkout Form -->
									<form action="<?= base_url('patient/insertBooking') ?>">
									
										<!-- Personal Information -->
										<div class="info-widget">
											<h4 class="card-title">Personal Information</h4>
											<div class="row">
												<input type="hidden" name="doctor_id" value="<?= isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '' ?>">
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>First Name</label>
														<input class="form-control" type="text" name="firstname">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Last Name</label>
														<input class="form-control" type="text" name="lastname">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Email</label>
														<input class="form-control" type="email" name="email">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Phone</label>
														<input class="form-control" type="text" name="phone">
													</div>
												</div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Purpose</label>
                                                        <select class="form-control" name="purpose">
                                                            <option value="Check-Up">Check-Up</option>
                                                            <option value="Cataract">Cataract</option>
                                                            <option value="Eyecare">Eyecare</option>
                                                            <option value="Followed_Checkup">Followed_Checkup</option>
                                                            <!-- Add more options as needed -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Location</label>
                                                        <select class="form-control" name="pref_location">
                                                            <option value="Adonai-1 Xentro Mall, Calapan">Adonai-1 Xentro Mall, Calapan</option>
                                                            <option value="Adonai-2">Adonai-2</option>
                                                            <option value="Adonai-3">Adonai-3</option>
                                                            <option value="Adonai-4">Adonai-4</option>
                                                            <!-- Add more options as needed -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Addtional Message</label>
                                                        <input class="form-control" type="text" name="add_message">
                                                    </div>
                                                </div>

											</div>
										</div>
										<!-- /Personal Information -->
										
										<div class="payment-widget">
											<!-- Terms Accept -->
											<div class="terms-accept">
												<div class="custom-checkbox">
												   <input type="checkbox" id="terms_accept">
												   <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
												</div>
											</div>
											<!-- /Terms Accept -->
                                            <input type="hidden" name="pref_date" id="pref_date_input">
                                            <input type="hidden" name="pref_time_start" id="pref_time_start_input">
                                            <input type="hidden" name="pref_time_end" id="pref_time_end_input">
											<input type="hidden" name="pref_day" id="pref_day_input">
											<input type="hidden" name="pref_timeslot_id" id="pref_timeslotid_input">
											
											<!-- Submit Section -->
											<div class="submit-section mt-4">
												<button type="submit" class="btn btn-primary submit-btn">Confirm and Pay</button>
											</div>
											<!-- /Submit Section -->
											
										</div>
									</form>
									<!-- /Checkout Form -->
									
								</div>
							</div>
							
						</div>
						
						<div class="col-md-5 col-lg-4 theiaStickySidebar">
						
							<!-- Booking Summary -->
							<div class="card booking-card">
								<div class="card-header">
									<h4 class="card-title">Booking Summary</h4>
								</div>
								<div class="card-body">
								
									<!-- Booking Doctor Info -->
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<img src="<?= site_url('uploads/' . $doctor['Profile_url']) ?>" alt="User Image">
										</a>
										<div class="booking-info">
											<h4><a href="doctor-profile.html">Dr. <?= $doctor['FirstName'] ?> <?= $doctor['LastName'] ?></a></h4>
											<div class="rating">
                                                <!-- Display the doctor's rating -->
                                                <?php for ($i = 0; $i < $doctor['Rating']; $i++): ?>
                                                    <i class="fas fa-star filled"></i>
                                                <?php endfor; ?>
                                                <span class="d-inline-block average-rating"><?= $doctor['Rating_count'] ?></span>
                                            </div>
											<div class="clinic-details">
												<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $doctor['Location'] ?></p>
											</div>
										</div>
									</div>
									<!-- Booking Doctor Info -->
									
									<div class="booking-summary">
										<div class="booking-item-wrap">
                                        <ul class="booking-date">
                                            <li>Date <span id="selectedDate"></span></li>
											<li>Day <span id="selectedDay"></span></li>
											<li>Time ID <span id="selectedTimeslotId"></span></li>
                                            <li>Time <span id="selectedTime"></span></li>
                                            
                                        </ul>
											<ul class="booking-fee">
												<li>Consulting Fee <span>₱100</span></li>
												<li>Booking Fee <span>₱10</span></li>
												<!-- <li>Video Call <span>$50</span></li> -->
											</ul>
											<div class="booking-total">
												<ul class="booking-total-list">
													<li>
														<span>Total</span>
														<span class="total-cost">₱110</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Booking Summary -->
                            
							
						</div>
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

        <script>
        // Retrieve selected values from local storage
        const selectedDay = localStorage.getItem('selectedDay');
        const selectedDate = localStorage.getItem('selectedDate');
        const selectedTime = localStorage.getItem('selectedTime');
		const selectedTimeslotId = localStorage.getItem('selectedTimeslotId');

        // Trim the selectedTime
        const trimmedSelectedTime = selectedTime.trim();

        // Display selected values in the booking summary
		document.getElementById('selectedDay').textContent = selectedDay;
        document.getElementById('selectedDate').textContent = selectedDate;
		document.getElementById('selectedTimeslotId').textContent = selectedTimeslotId;
        document.getElementById('selectedTime').textContent = trimmedSelectedTime;

        // Set the value of the hidden input field for pref_date
		document.getElementById('pref_timeslotid_input').value = selectedTimeslotId;
		document.getElementById('pref_day_input').value = selectedDay;
        document.getElementById('pref_date_input').value = selectedDate;

        // Extract start and end times
        const [prefTimeStart, prefTimeEnd] = trimmedSelectedTime.split(' - ');

        // Set the value of hidden input fields for Pref_Time_Start and Pref_Time_End
        document.getElementById('pref_time_start_input').value = prefTimeStart;
        document.getElementById('pref_time_end_input').value = prefTimeEnd;

        </script>
        
		<!-- jQuery & Bootstrap JS
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/checkout.html  30 Nov 2019 04:12:16 GMT -->
</html>