<?= $this->include('include/doctor_header') ?>

	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
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
									<li class="breadcrumb-item active" aria-current="page">Patients</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Patients</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
                                    <?php foreach ($doctors as $doctor): ?>
                                        <div class="profile-info-widget">
                                            <a href="#" class="booking-doc-img">
                                                <img src="<?= base_url('uploads/' . $doctor['Profile_url']) ?>" alt="User Image">
                                            </a>
                                            <div class="profile-det-info">
                                                <h3>Dra. <?= $doctor['FirstName'] ?> <?= $doctor['LastName'] ?></h3>
                                                
                                                <div class="patient-details">
                                                    <h5 class="mb-0"><?= $doctor['Specialization'] ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
								</div>
								<?= $this->include('include/doctor_sidebar') ?>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
                      <!-- In your view file -->
<div class="col-md-7 col-lg-8 col-xl-9">
    <div class="row row-grid">
        <?php foreach ($allPatients as $patient): ?>
            <div class="card widget-profile pat-widget-profile" style="width: 300px; margin: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <div class="card-body" style="display: flex; flex-direction: column; height: 100%; padding: 15px;">
                    <div class="pro-widget-content" style="flex: 1;">
                        <div class="profile-info-widget" style="display: flex; align-items: center;">
                            <a href="patient-profile.html" class="booking-doc-img" style="flex-shrink: 0;">
                                <!-- Update image path if needed -->
                                <img src="<?= base_url('uploads/' . $patient['Profile_url']) ?>" alt="User Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                            </a>
                            <div class="profile-det-info" style="margin-left: 15px;">
                                <h3><a href="<?= site_url('/Doctor/Dashboard/Patients-Profile/' . $patient['PatientID']) ?>" style="text-decoration: none; color: #333;"><?= $patient['FirstName'] ?> <?= $patient['LastName'] ?></a></h3>
                                
                                <div class="patient-details">
                                    <h5><b>Patient ID :</b> <?= $patient['PatientID'] ?></h5>
                                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $patient['Address'] ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="patient-info" style="border-top: 1px solid #ddd; padding-top: 10px;">
                        <ul style="list-style: none; padding: 0;">
                            <li>Phone <span><?= $patient['Phone'] ?></span></li>
                            <li>Gender <span><?= $patient['Gender'] ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
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


		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

		<script>
    // Make the userID available in JavaScript
    var token = '<?php echo $token; ?>';
    // Enable Pusher logging - don't include this in production
    console.log("User Token:", token);
    Pusher.logToConsole = true;

    var pusher = new Pusher('66016c500af8a7ce62eb', {
        cluster: 'ap1',
        encrypted: true
    });

    var channel = pusher.subscribe('user-token-' + token);
    channel.bind('booking-notification', function(data) {
        // Handle the notification data here
        console.log('Received data:', data);
        
        // Request permission to show notifications
        if (Notification.permission === 'granted') {
            showNotification(data.message);
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    showNotification(data.message);
                }
            });
        }
    });

    // Function to display the notification
    function showNotification(message) {
        var options = {
            body: message,
            icon: 'path_to_icon/icon.png' // Optional: Path to an icon
        };
        var notification = new Notification('New Booking Notification', options);

        // Optional: Handle notification click
        notification.onclick = function(event) {
            event.preventDefault();
            // Example: Focus or navigate to the app
            window.open('http://localhost:8080/Doctor/Dashboard', '_blank');
        };
    }
</script>



	  
		<!-- jQuery -->
		<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/ResizeSensor.j')?>'"></script>
        <script src="<?php echo base_url('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')?>"></script>
		
		<!-- Circle Progress JS -->
		<script src="<?php echo base_url('assets/js/circle-progress.min.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/doctor-dashboard.html  30 Nov 2019 04:12:09 GMT -->
</html>