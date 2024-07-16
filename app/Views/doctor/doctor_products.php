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
									<li class="breadcrumb-item active" aria-current="page">Products</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Products</h2>
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
												<a href="reviews.html">
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
							
						<div class="row">
								<div class="col-xl-3 col-sm-6 col-12">
									<div class="card">
										<div class="card-body">
											<div class="dash-widget-header">
												<div class="dash-count">
													<h3><?php echo $purchaseCount; ?></h3>
												</div>
											</div>
											<div class="dash-widget-info">
												<h6 class="text-muted">Pending Orders</h6>
												<div class="progress progress-sm">
													<?php
													// Ensure $returnedCount and $purchaseCount are not negative to avoid division by zero or negative percentages
													$returnedCount = max(0, $returnedCount);
													$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

													// Calculate percentage
													$percentage = ($returnedCount / $purchaseCount) * 100;

													// Limit percentage to a maximum of 100%
													$percentage = min($percentage, 100);

													// Print the progress bar with dynamic width
													echo '<div class="progress-bar bg-primary" style="width: ' . $percentage . '%;"></div>';
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12">
									<div class="card">
										<div class="card-body">
											<div class="dash-widget-header">
												<div class="dash-count">
													<h3><?php echo $onprocessCount; ?></h3>
												</div>
											</div>
											<div class="dash-widget-info">
												<h6 class="text-muted">On Process</h6>
												<div class="progress progress-sm">
													<?php
													// Ensure $onprocessCount and $purchaseCount are not negative to avoid division by zero or negative percentages
													$onprocessCount = max(0, $onprocessCount);
													$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

													// Calculate percentage
													$percentage = ($onprocessCount / $purchaseCount) * 100;

													// Limit percentage to a maximum of 100%
													$percentage = min($percentage, 100);

													// Print the progress bar with dynamic width
													echo '<div class="progress-bar bg-warning" style="width: ' . $percentage . '%;"></div>';
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12">
									<div class="card">
										<div class="card-body">
											<div class="dash-widget-header">
												<div class="dash-count">
													<h3><?php echo $completeCount; ?></h3>
												</div>
											</div>
											<div class="dash-widget-info">
												<h6 class="text-muted">Complete Items</h6>
												<div class="progress progress-sm">
													<?php
													// Ensure $completeCount is not negative
													$completeCount = max(0, $completeCount);

													// Use a fixed value or a different count for the denominator to calculate the percentage
													$totalItems = $completeCount; // Replace $purchaseCount with the total number of items or an appropriate denominator

													// Avoid division by zero
													if ($totalItems > 0) {
														$percentage = ($completeCount / $totalItems) * 100;
													} else {
														$percentage = 0;
													}

													// Limit percentage to a maximum of 100%
													$percentage = min($percentage, 100);

													// Print the progress bar with dynamic width
													echo '<div class="progress-bar bg-success" style="width: ' . $percentage . '%;"></div>';
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-sm-6 col-12">
									<div class="card">
										<div class="card-body">
											<div class="dash-widget-header">
												<div class="dash-count">
													<h3><?php echo $returnedCount; ?></h3>
												</div>
											</div>
											<div class="dash-widget-info">
												<h6 class="text-muted">Returned Items</h6>
												<div class="progress progress-sm">
													<?php
													// Ensure $returnedCount and $purchaseCount are not negative to avoid division by zero or negative percentages
													$returnedCount = max(0, $returnedCount);
													$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

													// Calculate percentage
													$percentage = ($returnedCount / $purchaseCount) * 100;

													// Limit percentage to a maximum of 100%
													$percentage = min($percentage, 100);

													// Print the progress bar with dynamic width
													echo '<div class="progress-bar bg-danger" style="width: ' . $percentage . '%;"></div>';
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
	
							<div class="row">
								<div class="col-md-12">
									<!-- Feed Activity -->
									<div class="card card-table flex-fill">
										<div class="card-header">
											<h4 class="card-title">Recent Purchase</h4>
											<div class="row">
												<div class="col">
													<label for="rowLimit">Show:</label>
													<select id="rowLimit" class="form-control" style="width: auto; display: inline-block;">
														<option value="5">5</option>
														<option value="10">10</option>
														<option value="15">15</option>
														<option value="20">20</option>
													</select>
													<label for="rowLimit">entries</label>
												</div>
												<div class="col text-right">
													<button id="prevPage" class="btn btn-secondary">Previous</button>
													<button id="nextPage" class="btn btn-secondary">Next</button>
												</div>
											</div>
										</div>
										<div class="card-body">
											<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
												<table id="purchaseTable" class="table table-hover table-center mb-0">
													<thead>
														<tr>
															<th>Id</th>
															<th>Customer</th>
															<th>Email</th>
															<th>Product</th>
															<th>Status</th>
															<th>Quantity</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($purchases as $purchase): ?>
														<tr id="purchase_<?php echo $purchase->PurchaseID; ?>">
															<td><?php echo $purchase->PurchaseID; ?></td>
															<td><?php echo $purchase->FirstName; ?> <?php echo $purchase->LastName; ?></td>
															<td><?php echo $purchase->Email; ?></td>
															<td><?php echo $purchase->ProductName; ?></td>
															<td>
																<form id="form_<?php echo $purchase->PurchaseID; ?>" class="status-form">
																	<input type="hidden" name="purchase_id" value="<?php echo $purchase->PurchaseID; ?>">
																	<select name="status" class="form-control status-select">
																		<option value="Pending" <?php if ($purchase->Status == 'Pending') echo 'selected'; ?>>Pending</option>
																		<option value="On-Process" <?php if ($purchase->Status == 'On-Process') echo 'selected'; ?>>On-Process</option>
																		<option value="Completed" <?php if ($purchase->Status == 'Completed') echo 'selected'; ?>>Completed</option>
																		<option value="Returned" <?php if ($purchase->Status == 'Returned') echo 'selected'; ?>>Returned</option>
																	</select>
																</form>
															</td>
															<td><?php echo $purchase->Quantity; ?></td>
															<td><?php echo $purchase->TotalAmount; ?></td>
															<td>
																<!-- Add additional actions here if needed -->
															</td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!-- /Feed Activity -->

<script>
    // JavaScript to handle status update using AJAX
    document.addEventListener('DOMContentLoaded', function () {
        const statusForms = document.querySelectorAll('.status-form');

        statusForms.forEach(form => {
            form.addEventListener('change', function (event) {
                event.preventDefault();

                const formData = new FormData(form);
                const purchaseId = formData.get('purchase_id');
                const status = formData.get('status');

                fetch('<?php echo base_url('purchase/updateStatus'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the status in the table cell
                        const statusCell = document.querySelector(`#purchase_${purchaseId} .status-select`);
                        statusCell.value = status;
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating status.');
                });
            });
        });
    });
</script>



<script>
	document.addEventListener('DOMContentLoaded', function () {
    const rowLimit = document.getElementById('rowLimit');
    const purchaseTable = document.getElementById('purchaseTable');
    const rows = purchaseTable.getElementsByTagName('tr');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowLimit.value, 10);

    function updateTable() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        for (let i = 0; i < rows.length; i++) {
            if (i >= startIndex && i < endIndex) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function goToPage(page) {
        currentPage = page;
        updateTable();
    }

    rowLimit.addEventListener('change', function () {
        rowsPerPage = parseInt(rowLimit.value, 10);
        goToPage(1); // Reset to the first page when rows per page changes
    });

    prevPageBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            goToPage(currentPage - 1);
        }
    });

    nextPageBtn.addEventListener('click', function () {
        const maxPage = Math.ceil(rows.length / rowsPerPage);
        if (currentPage < maxPage) {
            goToPage(currentPage + 1);
        }
    });

    updateTable(); // Initial call to set up the table
});


</script>
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