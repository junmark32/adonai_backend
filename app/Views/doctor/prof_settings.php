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
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
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
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="active">
												<a href="doctor-dashboard.html">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="appointments.html">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li>
												<a href="my-patients.html">
													<i class="fas fa-user-injured"></i>
													<span>My Patients</span>
												</a>
											</li>
											<li>
												<a href="<?= site_url('/Doctor/Dashboard/Schedule') ?>">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>

											<li>
												<a href="<?= site_url('/Doctor/Products') ?>">
													<i class="fas fa-hourglass-start"></i>
													<span>Products</span>
												</a>
											</li>
										
											<li>
												<a href="<?= site_url('/scheduler/update-status') ?>">
													<i class="fas fa-star"></i>
													<span>Reviews</span>
												</a>
											</li>
										
											<li>
												<a href="doctor-profile-settings.html">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li>
												<a href="social-media.html">
													<i class="fas fa-share-alt"></i>
													<span>Social Media</span>
												</a>
											</li>
											<li>
												<a href="doctor-change-password.html">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="index-2.html">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>

                        <div class="col-md-7 col-lg-8 col-xl-9">
						
							<!-- Basic Information -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Basic Information</h4>
            <div class="row form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="change-avatar">
                            <div class="profile-img">
                                <!-- Assuming you have a path to the profile picture -->
                                <img src="<?= base_url('uploads/' . $doctorData['doctor_data']['Profile_url']) ?>" alt="User Image">
                            </div>
                            <div class="upload-img">
                                <div class="change-photo-btn">
                                    <span><i class="fa fa-upload"></i> Upload Photo</span>
                                    <input type="file" class="upload">
                                </div>
                                <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_user']['Username']) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($doctorData['doctor_data']['Email']) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doctor_data']['FirstName']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doctor_data']['LastName']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doctor_data']['Phone']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control select">
                            <option <?= $doctorData['doctor_data']['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option <?= $doctorData['doctor_data']['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label>Date of Birth</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars(date('d-m-Y', strtotime($doctorData['doctor_data']['BirthDate']))) ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Basic Information -->
							
	<!-- About Me -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">About Me</h4>
            <div class="form-group mb-0">
                <label>Biography</label>
                <textarea class="form-control" rows="5"><?= htmlspecialchars($doctorData['doc_about']['Biography']) ?></textarea>
            </div>
        </div>
    </div>
    <!-- /About Me -->
							
	<!-- Contact Details -->
    <div class="card contact-card">
        <div class="card-body">
            <h4 class="card-title">Contact Details</h4>
            <div class="row form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['Address1']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Address Line 2</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['Address2']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">City</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['City']) ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">State / Province</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['Province']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Country</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['Country']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Postal Code</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($doctorData['doc_cont']['PostalCode']) ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Contact Details -->
							
	<!-- Services and Specialization -->
    <div class="card services-card">
        <div class="card-body">
            <h4 class="card-title">Services and Specialization</h4>
            <div class="form-group">
                <label>Services</label>
                <input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Enter Services" name="services" value="<?= htmlspecialchars(implode(',', array_column($doctorData['doc_serv'], 'Services'))) ?>" id="services">
                <small class="form-text text-muted">Note : Type & Press enter to add new services</small>
            </div> 
            <div class="form-group mb-0">
                <label>Specialization </label>
                <input class="input-tags form-control" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialist" value="<?= htmlspecialchars(implode(',', array_column($doctorData['doc_spec'], 'Specialization'))) ?>" id="specialist">
                <small class="form-text text-muted">Note : Type & Press  enter to add new specialization</small>
            </div> 
        </div>              
    </div>
    <!-- /Services and Specialization -->
						 
	<!-- Education -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Education</h4>
            <div class="education-info">
                <?php foreach ($doctorData['doc_educ'] as $education): ?>
                    <div class="row form-row education-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Degree</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($education['Degree']) ?>">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>College/Institute</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($education['College']) ?>">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Year of Completion</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($education['Year']) ?>">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Education -->
						
<!-- Experience -->
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Experience</h4>
            <div class="experience-info">
                <?php foreach ($doctorData['doc_exp'] as $experience): ?>
                    <div class="row form-row experience-cont">
                        <div class="col-12 col-md-10 col-lg-11">
                            <div class="row form-row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Hospital Name</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($experience['Hosp_name']) ?>">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($experience['From_where']) ?>">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>To</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($experience['To_where']) ?>">
                                    </div> 
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($experience['Designation']) ?>">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Experience -->
							
<!-- Awards -->
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Awards</h4>
            <div class="awards-info">
                <?php foreach ($doctorData['doc_awards'] as $award): ?>
                    <div class="row form-row awards-cont">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label>Awards</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($award['Awards']) ?>">
                            </div> 
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label>Year</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($award['Year']) ?>">
                            </div> 
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="add-more">
                    <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> Add More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Awards -->

    <div class="submit-section submit-btn-bottom">
        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
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

        <!-- Select2 JS -->
		<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js')?>"></script>
		
		<!-- Dropzone JS -->
		<script src="<?php echo base_url('assets/plugins/dropzone/dropzone.min.js')?>"></script>
		
		<!-- Bootstrap Tagsinput JS -->
		<script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')?>"></script>
		
		<!-- Profile Settings JS -->
		<script src="<?php echo base_url('assets/js/profile-settings.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/doctor-dashboard.html  30 Nov 2019 04:12:09 GMT -->
</html>