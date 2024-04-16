<?= $this->include('include/header') ?>
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
						<!-- Header -->
                        <?= $this->include('include/navbar_guest') ?>
			<!-- /Header -->
			<!-- /Header -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Patient Register <a href="doctor-register.html">Are you a Doctor?</a></h3>
										</div>
										
										<!-- Register Form -->
<!-- Register Form -->
<form action="/register-user" method="POST">
    <div class="row">
        <!-- First Column -->
        <div class="col-md-6">
            <!-- First Name Field -->
            <div class="form-group form-focus">
                <input type="text" class="form-control floating" name="firstname" required>
                <label class="focus-label">First Name</label>
            </div>
            <!-- Last Name Field -->
            <div class="form-group form-focus">
                <input type="text" class="form-control floating" name="lastname" required>
                <label class="focus-label">Last Name</label>
            </div>
            <!-- Email Field -->
            <div class="form-group form-focus">
                <input type="email" class="form-control floating" name="email" required>
                <label class="focus-label">Email</label>
            </div>
            <!-- Phone Field -->
            <div class="form-group form-focus">
                <input type="text" class="form-control floating" name="phone" required>
                <label class="focus-label">Phone</label>
            </div>
             <!-- Date of Birth Field -->
             <div class="form-group form-focus">
                <input type="date" class="form-control floating" name="dateOfBirth" required>
                <label class="focus-label">Date of Birth</label>
            </div>
            <!-- Gender Field -->
            <div class="form-group form-focus select-focus">
                <select class="select form-control" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <label class="focus-label">Gender</label>
            </div>
        </div>
        <!-- Second Column -->
        <div class="col-md-6">
            <!-- Username Field -->
            <div class="form-group form-focus">
                <input type="text" class="form-control floating" name="username" required>
                <label class="focus-label">Username</label>
            </div>
            <!-- Password Field -->
            <div class="form-group form-focus">
                <input type="password" class="form-control floating" name="password" id="password" required>
                <label class="focus-label">Password</label>
            </div>
            <!-- Confirm Password Field -->
            <div class="form-group form-focus">
                <input type="password" class="form-control floating" name="confirm_password" id="confirm_password" required>
                <label class="focus-label">Confirm Password</label>
            </div>
           
        </div>
    </div>
    <div class="text-right">
        <a class="forgot-link" href="login.html">Already have an account?</a>
    </div>
    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
    <div class="login-or">
        <span class="or-line"></span>
        <span class="span-or">or</span>
    </div>
    <div class="row form-row social-login">
        <div class="col-6">
            <a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
        </div>
        <div class="col-6">
            <a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
        </div>
    </div>
</form>
<!-- /Register Form -->


<script>
    // Add an event listener to the confirm password input field
    document.getElementById('confirm_password').addEventListener('input', function () {
        // Get the password and confirm password values
        var password = document.getElementById('password').value;
        var confirm_password = this.value;

        // Check if the passwords match
        if (password !== confirm_password) {
            // If passwords don't match, set custom validation message
            this.setCustomValidity("Passwords do not match");
        } else {
            // If passwords match, clear the custom validation message
            this.setCustomValidity('');
        }
    });
</script>

										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
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
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/register.html  30 Nov 2019 04:12:20 GMT -->
</html>