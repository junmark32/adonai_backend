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
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
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
						
						<div class="col-md-7 col-lg-8 col-xl-9">

							<div class="row">
								<div class="col-md-12">
									<div class="card dash-card">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar circle-bar1">
															<div class="circle-graph1" data-percent="<?php echo $patientCount; ?>">
																<img src="<?php echo base_url('assets/img/icon-01.png')?>" class="img-fluid" alt="patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Total Patient</h6>
															<h3><?php echo $patientCount; ?></h3>
															<p class="text-muted">Till Today</p>
														</div>
													</div>
												</div>
												
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar circle-bar2">
															<div class="circle-graph2" data-percent="<?php echo $patientToday; ?>">
																<img src="<?php echo base_url('assets/img/icon-02.png')?>" class="img-fluid" alt="Patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Today Patient</h6>
															<h3><?php echo $patientToday; ?></h3>
															<p class="text-muted"><?php echo $currentDate; ?></p>
														</div>
													</div>
												</div>
												
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget">
														<div class="circle-bar circle-bar3">
															<div class="circle-graph3" data-percent="<?php echo $appointmentCount; ?>">
																<img src="<?php echo base_url('assets/img/icon-03.png')?>" class="img-fluid" alt="Patient">
															</div>
														</div>
														<div class="dash-widget-info">
															<h6>Appoinments</h6>
															<h3><?php echo $appointmentCount; ?></h3>
															<p class="text-muted"><?php echo $currentDate; ?></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<h4 class="mb-4">Patient Appoinment</h4>
									<div class="appointment-tab">
									
										<!-- Appointment Tab -->
										<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
											<li class="nav-item">
												<a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming <span class="badge badge-primary"><?= $upcomingCount ?></span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#today-appointments" data-toggle="tab">Today <span class="badge badge-primary"><?= $todayCount ?></span></a>
											</li> 
										</ul>
										<!-- /Appointment Tab -->
										
										<div class="tab-content">
										
											<!-- Upcoming Appointment Tab -->
<div class="tab-pane show active" id="upcoming-appointments">
    <div class="card card-table mb-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-center mb-0">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Appt Date</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $today = date('Y-m-d');
                        foreach ($appointmentData as $data): 
                            if (date('Y-m-d', strtotime($data['appointment']['Pref_Date'])) > $today):
                        ?>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="<?= site_url('/Doctor/Dashboard/Patients-Profile/' . $data['patient']['PatientID']) ?>" class="avatar avatar-sm mr-2">
                                            <img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $data['patient']['Profile_url']) ?>" alt="User Image">
                                        </a>
                                        <a href="<?= site_url('/Doctor/Dashboard/Patients-Profile/' . $data['patient']['PatientID']) ?>">
                                            <?= $data['patient']['FirstName'] ?> <span>#PT<?= $data['patient']['PatientID'] ?></span>
                                        </a>
                                    </h2>
                                </td>

                                <td>
                                    <?= date('d M Y', strtotime($data['appointment']['Pref_Date'])) ?> 
                                    <span class="d-block text-info"><?= date('h.i A', strtotime($data['appointment']['Pref_Time_Start'])) ?></span>
                                </td>
                                <td><?= $data['appointment']['Purpose'] ?></td>
                                <td><?= $data['appointment']['Status'] ?></td>
                                <td class="text-right">
                                    <div class="table-action">
                                        <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                            <i class="far fa-eye"></i> View
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm bg-success-light">
                                            <i class="fas fa-check"></i> Accept
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            endif;
                        endforeach; 
                        ?>    
                    </tbody>
                </table>        
            </div>
        </div>
    </div>
</div>
<!-- /Upcoming Appointment Tab -->


									   
											<!-- Today Appointment Tab -->
<div class="tab-pane" id="today-appointments">
	<div class="card card-table mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-center mb-0">
					<thead>
						<tr>
							<th>Patient Name</th>
							<th>Appt Date</th>
							<th>Purpose</th>
							<th>Type</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$today = date('Y-m-d');
					foreach ($appointmentData as $data): 
						if (date('Y-m-d', strtotime($data['appointment']['Pref_Date'])) == $today):
					?>
						<tr>
							<td>
								<h2 class="table-avatar">
									<a href="<?= site_url('/Doctor/Dashboard/Patients-Profile/' . $data['patient']['PatientID']) ?>" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $data['patient']['Profile_url']) ?>" alt="User Image"></a>
									<a href="<?= site_url('/Doctor/Dashboard/Patients-Profile/' . $data['patient']['PatientID']) ?>"><?= $data['patient']['FirstName'] ?> <span>#PT<?= $data['patient']['PatientID'] ?></span></a>
								</h2>
							</td>
							<td><?= date('d M Y', strtotime($data['appointment']['Pref_Date'])) ?> <span class="d-block text-info"><?= date('h.i A', strtotime($data['appointment']['Pref_Time_Start'])) ?></span></td>
							<td><?= $data['appointment']['Purpose'] ?></td>
							<td><?= $data['appointment']['Status'] ?></td>
							<td class="text-right">
								<div class="table-action">
									<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
										<i class="far fa-eye"></i> View
									</a>
									
									<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
										<i class="fas fa-check"></i> Accept
									</a>
									<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
										<i class="fas fa-times"></i> Cancel
									</a>
								</div>
							</td>
						</tr>
					<?php 
						endif;
					endforeach; 
					?>	
					</tbody>
				</table>		
			</div>	
		</div>	
	</div>	
</div>
<!-- /Today Appointment Tab -->

											
										</div>
									</div>
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

<script>
  function reloadLink() {
    fetch('/scheduler/update-status')
      .then(response => response.text())
      .then(data => console.log('Link reloaded: ', data))
      .catch(error => console.error('Error reloading link:', error));
  }

  // Reload every 5 seconds (5000 milliseconds)
  setInterval(reloadLink, 1000);
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