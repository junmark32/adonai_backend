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
									<li class="breadcrumb-item active" aria-current="page">Orders</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Orders</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						
						<!-- Profile Sidebar -->
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                        <?php foreach ($patients as $patient): ?>
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
										<img src="<?= base_url('uploads/' . (!empty($patient['Profile_url']) ? $patient['Profile_url'] : 'default_profile.jpg')) ?>" alt="User Image">
										</a>
										<div class="profile-det-info">
											<h3><?= $patient['FirstName'] ?> <?= $patient['LastName'] ?></h3>
											<div class="patient-details">
                                                <h5><i class="fas fa-birthday-cake"></i> <?= date('F j, Y', strtotime($patient['DateOfBirth'])) ?></h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $patient['Address'] ?></h5>
											</div>
										</div>
									</div>
								</div>
								<?= $this->include('include/user_sidebar') ?>

							</div>
                        <?php endforeach; ?>
						</div>
						<!-- / Profile Sidebar -->
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body pt-0">
								
									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#orders" data-toggle="tab">Orders</a>
											</li>
											<!-- <li class="nav-item">
												<a class="nav-link" href="#pat_medical_records" data-toggle="tab"><span class="med-records">Medical Records</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_billing" data-toggle="tab">Billing</a>
											</li> -->
										</ul>
									</nav>
									<!-- /Tab Menu -->
									
									<!-- Tab Content -->
									<div class="tab-content pt-0">
										
										<!-- Appointment Tab -->
                                        <div id="orders" class="tab-pane fade show active">
                                            <div class="card card-table mb-0">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
    <thead>
        <tr>
            <th>Order No.</th>
            <th>Eyewear</th>
            <th>Lens</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($purchases as $index => $purchase): ?>
            <tr>
                <td  style="text-align: center;"><?= esc($purchase['PurchaseID']) ?></td> <!-- Replace 'order_no' with the actual order number field -->
                <td>
                    <div style="display: flex; align-items: center;">
                        <a  class="avatar avatar-lg mr-2">
                            <img class="avatar-img rounded-circle" src="<?= base_url('uploads/') . $productData[$index]['Image_url'] ?>" alt="User Image">
                        </a>
                        <div>
                            <span><strong><?= esc($productData[$index]['Name'] ?? 'N/A') ?></strong></span><br>
                            <span>₱ <?= esc($productData[$index]['Price'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                </td>

                <td>
                    <span><strong><?= esc($lensData[$index]['Brand'] ?? 'N/A') ?></strong></span><br>
                    <span>₱ <?= esc($lensData[$index]['Price'] ?? 'N/A') ?></span>
                </td>
                <td style="text-align: center;"><?= esc($purchase['Quantity']) ?></td>
                <td>₱ <?= esc($purchase['TotalAmount']) ?></td>
                <?php
                // Assuming $purchase['PurchaseDate'] is in 'Y-m-d H:i:s' format
                $date = new DateTime($purchase['PurchaseDate']);
                $formattedDate = $date->format('d/m/Y');
                $formattedTime = $date->format('h:i A');
                ?>

                <td>
                    <span><?= esc($formattedDate) ?></span><br>
                    <span><?= esc($formattedTime) ?></span>
                </td>
                <!-- Replace 'order_date' with the actual order date field -->
                <td><?= esc($purchase['Status']) ?></td> <!-- Replace 'status' with the actual status field -->
                <td class="text-right">
                    <div class="table-action">
                        <form action="<?= site_url('/purchase/cancel/' . $purchase['PurchaseID']) ?>" method="post">
                            <button type="submit" class="btn btn-sm bg-danger text-light">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Appointment Tab -->

									</div>
									<!-- Tab Content -->
									
								</div>
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
    channel.bind('prescription-notification', function(data) {
        // Handle the notification data here
        console.log('Received data:', data);
        
        // Request permission to show notifications if not already granted
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
        var notification = new Notification('Adonai', options);

        // Optional: Handle notification click
        notification.onclick = function(event) {
            event.preventDefault();
            // Example: Focus or navigate to the app
            window.focus();
        };
    }
</script>

	  
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

<!-- doccure/patient-dashboard.html  30 Nov 2019 04:12:16 GMT -->
</html>