<!DOCTYPE html> 
<html lang="en">
	
<!-- doccure/booking.html  30 Nov 2019 04:12:16 GMT -->
<head>
		<meta charset="utf-8">
		<title>Doccure</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">

<!-- Add the evo-calendar.css for styling -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css"/>

<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for functionality -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>


		
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
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
				
					<div class="row">
						<div class="col-12">
						
							<div class="card">
								<div class="card-body">
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<img src="<?= base_url('uploads/' . $doctor['Profile_url']) ?>" alt="User Image">
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
											<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> <?= $doctor['Location'] ?></p>
										</div>
									</div>
								</div>
							</div>

							
							<div id="calendar"></div>
							



							<script>
    // Get the PHP data and parse it as JSON
    const scheduleTimings = JSON.parse('<?php echo $scheduleTimings; ?>');

    // Initialize the calendar with events
    $('#calendar').evoCalendar({
        calendarEvents: scheduleTimings,
        onSelectDate: function(date, event) {
            if (event) {
                renderTimeSlots(date); // Optional: Render time slots if needed
            }
        }
    });

    // Function to render time slots based on selected date
    function renderTimeSlots(selectedDate) {
        const dateString = selectedDate.toISOString().split('T')[0]; // Get date in YYYY-MM-DD format

        // Clear existing time slots
        $('#time-slot-list').html('');

        // Filter and render time slots for the selected date
        scheduleTimings.forEach(event => {
            if (event.date.split(' ')[0] === dateString) {
                const timingHtml = `<li>
                    <a class="timing ${event.color === '#ff0000' ? 'disabled' : ''}" href="#" onclick="${event.color === '#ff0000' ? '' : `selectTimeSlot('${event.name}', '${event.date}', '${event.id}')`}">
                        <span>${event.name}</span>
                    </a>
                </li>`;
                $('#time-slot-list').append(timingHtml);
            }
        });
    }

    function selectTimeSlot(timeSlot, date, timeslotId) {
        // Store selected values in local storage
        localStorage.setItem('selectedTimeSlot', timeSlot);
        localStorage.setItem('selectedDate', date);
        localStorage.setItem('selectedTimeslotId', timeslotId);

        // Redirect to the checkout page
        window.location.href = '<?= site_url('/booking/checkout?doctor_id=' . $doctor['DoctorID']) ?>';
    }

    // Handle click events on the event-container elements
    $(document).on('click', '.event-container', function(e) {
        const eventIndex = $(this).data('event-index');
        const event = scheduleTimings.find(e => e.id == eventIndex);

        if (event) {
            if (event.color === '#ff0000') { // Reserved
                e.preventDefault(); // Prevent default action if the event is reserved
                return; // Exit the function
            }

            // Extract event details
            const [startTime, endTime] = event.name.split(' - ');
            const formattedDate = event.date;
            const timeslotId = event.id;

            // Store selected values in local storage
            localStorage.setItem('selectedTimeSlot', event.name);
            localStorage.setItem('selectedDate', formattedDate);
            localStorage.setItem('selectedTimeStart', startTime.trim());
            localStorage.setItem('selectedTimeEnd', endTime.trim());
            localStorage.setItem('selectedTimeslotId', timeslotId);

            // Redirect to the checkout page
            window.location.href = '<?= site_url('/booking/checkout?doctor_id=' . $doctor['DoctorID']) ?>';
        }
    });
</script>


							
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

<!-- doccure/booking.html  30 Nov 2019 04:12:16 GMT -->
</html>