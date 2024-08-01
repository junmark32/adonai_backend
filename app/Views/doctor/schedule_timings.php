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
									<li class="breadcrumb-item active" aria-current="page">Schedule Timings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Schedule Timings</h2>
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
                                        <div class="profile-info-widget">
                                            <a href="#" class="booking-doc-img">
                                                <img src="<?= base_url('uploads/' . $doctor['Profile_url']) ?>" alt="User Image">
                                            </a>
                                            <div class="profile-det-info">
                                                <h3>Dra. <?= $doctor['FirstName'] . ' ' . $doctor['LastName'] ?></h3>
                                                
                                                <div class="patient-details">
                                                    <h5 class="mb-0"><?= $doctor['Specialization'] ?></h5>
                                                </div>
                                            </div>
                                        </div>
								</div>
								<?= $this->include('include/doctor_sidebar') ?>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-md-7 col-lg-8 col-xl-9">
						 
							<div class="container mt-5">
								<form action="<?= base_url('schedule/insert') ?>" method="post">
									<div id="dateTimeContainer">
										<div class="row dateTimeEntry">
											<div class="col-md-4">
												<div class="form-group">
													<label for="date">Select Date</label>
													<input type="date" class="form-control" name="date[]" onchange="showTimeInputs(this)">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="start_time">Start Time</label>
													<input type="time" class="form-control" name="start_time[]">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="end_time">End Time</label>
													<input type="time" class="form-control" name="end_time[]">
												</div>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-4">
											<button type="button" class="btn btn-secondary" onclick="addDateTimeEntry()">Add Another</button>
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</form>
							</div>

							<script>
								function showTimeInputs(dateInput) {
									var entry = dateInput.closest('.dateTimeEntry');
									entry.querySelectorAll('input[type="time"]').forEach(input => {
										input.style.display = 'block';
									});
								}

								function addDateTimeEntry() {
									var container = document.getElementById('dateTimeContainer');
									var newEntry = container.firstElementChild.cloneNode(true);
									newEntry.querySelectorAll('input').forEach(input => {
										input.value = '';
									});
									container.appendChild(newEntry);
								}
							</script>
							<br>
							<hr>
							<br>
							
							
						
							<div class="container calendar-container">
								<div class="calendar">
									<div class="calendar-header">
										<button class="btn btn-primary" id="prevMonth">Previous</button>
										<h2 id="calendarTitle" class="mx-auto"></h2>
										<button class="btn btn-primary" id="nextMonth">Next</button>
									</div>
									<div class="calendar-body">
										<div class="calendar-day">Sun</div>
										<div class="calendar-day">Mon</div>
										<div class="calendar-day">Tue</div>
										<div class="calendar-day">Wed</div>
										<div class="calendar-day">Thu</div>
										<div class="calendar-day">Fri</div>
										<div class="calendar-day">Sat</div>
									</div>
									<div id="calendarDays" class="calendar-body"></div>
								</div>
								<div class="sidebar">
									<h4>Schedule Details</h4>
									<div id="scheduleDetails">Click a date to see the schedule details.</div>
								</div>
							</div>

							<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
							<script>
								const scheduleTimings = <?php echo json_encode($scheduleTimings); ?>;

								const calendarTitle = document.getElementById('calendarTitle');
								const calendarDays = document.getElementById('calendarDays');
								const prevMonthBtn = document.getElementById('prevMonth');
								const nextMonthBtn = document.getElementById('nextMonth');
								const scheduleDetails = document.getElementById('scheduleDetails');

								let currentYear = new Date().getFullYear();
								let currentMonth = new Date().getMonth();

								function renderCalendar(year, month) {
									calendarTitle.innerText = `${year} - ${month + 1}`;

									const firstDayOfMonth = new Date(year, month, 1).getDay();
									const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
									const lastDayOfMonth = new Date(year, month, lastDateOfMonth).getDay();
									const days = [];

									for (let i = 0; i < firstDayOfMonth; i++) {
										days.push('<div class="calendar-day empty"></div>');
									}
									for (let i = 1; i <= lastDateOfMonth; i++) {
										days.push(`<div class="calendar-day" data-date="${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}">${i}</div>`);
									}
									for (let i = lastDayOfMonth + 1; i < 7; i++) {
										days.push('<div class="calendar-day empty"></div>');
									}

									calendarDays.innerHTML = days.join('');
								}

								function getScheduleForDate(date) {
									return scheduleTimings.filter(item => {
										const itemDate = item.date.split(' ')[0];
										return itemDate === date;
									});
								}

								function formatTimeToAmPm(timeStr) {
	const date = new Date(`1970-01-01T${timeStr}Z`);
	const hours = date.getUTCHours();
	const minutes = date.getUTCMinutes();
	const ampm = hours >= 12 ? 'PM' : 'AM';
	const formattedHours = hours % 12 || 12; // Convert 0 hours to 12
	const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
	return `${formattedHours}:${formattedMinutes} ${ampm}`;
}

calendarDays.addEventListener('click', function(event) {
	const target = event.target;
	if (target.classList.contains('calendar-day') && !target.classList.contains('empty')) {
		const date = target.getAttribute('data-date');
		const schedules = getScheduleForDate(date);

		if (schedules.length > 0) {
			let scheduleHTML = schedules.map(schedule => {
				const formattedStartTime = formatTimeToAmPm(schedule.start_time);
				const formattedEndTime = formatTimeToAmPm(schedule.end_time);
				return `
					<div class="doc-times">
						<div class="doc-slot-list">
							${formattedStartTime} - ${formattedEndTime}
							<a href="<?= site_url('schedule/delete/') ?>${schedule.id}" class="delete_schedule">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
				`;
			}).join('');

			scheduleDetails.innerHTML = scheduleHTML;

		} else {
			scheduleDetails.innerHTML = `
				<h4>No Schedule</h4>
				<p>No schedule available for ${date}</p>
			`;
		}
	}
});




								function handleCustomButtonClick(date) {
									const schedules = getScheduleForDate(date);
									if (schedules.length > 0) {
										let scheduleText = schedules.map(schedule => {
											return `Start Time: ${schedule.start_time}\nEnd Time: ${schedule.end_time}`;
										}).join('\n\n');
										
										alert(`Custom Button Clicked\n\n${scheduleText}`);
									} else {
										alert(`No schedule available for ${date}`);
									}
								}

								prevMonthBtn.addEventListener('click', () => {
									if (currentMonth === 0) {
										currentMonth = 11;
										currentYear--;
									} else {
										currentMonth--;
									}
									renderCalendar(currentYear, currentMonth);
								});

								nextMonthBtn.addEventListener('click', () => {
									if (currentMonth === 11) {
										currentMonth = 0;
										currentYear++;
									} else {
										currentMonth++;
									}
									renderCalendar(currentYear, currentMonth);
								});

								renderCalendar(currentYear, currentMonth);
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
		
<!-- Add Time Slot Modal -->
<div class="modal fade custom-modal" id="add_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('schedule/insert') ?>" method="post">
                    <!-- Ensure to set the form action to the appropriate route where you handle insertion -->
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-lg-3">
                                <div class="form-group">               
                                    <label>Day</label>
                                    <select class="form-control" name="day">
                                        <option>-</option>
                                        <option>Sunday</option>
                                        <option>Monday</option>  
                                        <option>Tuesday</option>
                                        <option>Wednesday</option>
                                        <option>Thursday</option>
                                        <option>Friday</option>
                                        <option>Saturday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" class="form-control" name="start_time">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" class="form-control" name="end_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Time Slot Modal -->


		
		<!-- Edit Time Slot Modal -->
		<div class="modal fade custom-modal" id="edit_time_slot">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Time Slots</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="hours-info">
								<div class="row form-row hours-cont">
									<div class="col-12 col-md-10">
										<div class="row form-row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Start Time</label>
													<select class="form-control">
														<option>-</option>
														<option selected>12.00 am</option>
														<option>12.30 am</option>  
														<option>1.00 am</option>
														<option>1.30 am</option>
													</select>
												</div> 
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>End Time</label>
													<select class="form-control">
														<option>-</option>
														<option>12.00 am</option>
														<option selected>12.30 am</option>  
														<option>1.00 am</option>
														<option>1.30 am</option>
													</select>
												</div> 
											</div>
										</div>
									</div>
								</div>
								
								<div class="row form-row hours-cont">
									<div class="col-12 col-md-10">
										<div class="row form-row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Start Time</label>
													<select class="form-control">
														<option>-</option>
														<option>12.00 am</option>
														<option selected>12.30 am</option>
														<option>1.00 am</option>
														<option>1.30 am</option>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>End Time</label>
													<select class="form-control">
														<option>-</option>
														<option>12.00 am</option>
														<option>12.30 am</option>
														<option selected>1.00 am</option>
														<option>1.30 am</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
								</div>
								
								<div class="row form-row hours-cont">
									<div class="col-12 col-md-10">
										<div class="row form-row">
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Start Time</label>
													<select class="form-control">
														<option>-</option>
														<option>12.00 am</option>
														<option>12.30 am</option>
														<option selected>1.00 am</option>
														<option>1.30 am</option>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>End Time</label>
													<select class="form-control">
														<option>-</option>
														<option>12.00 am</option>
														<option>12.30 am</option>
														<option>1.00 am</option>
														<option selected>1.30 am</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
								</div>

							</div>
							
							<div class="add-more mb-3">
								<a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
							</div>
							<div class="submit-section text-center">
								<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Time Slot Modal -->
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
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/schedule-timings.html  30 Nov 2019 04:12:09 GMT -->
</html>