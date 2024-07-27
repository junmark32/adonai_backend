<?= $this->include('include/doctor_header') ?>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
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
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar dct-dashbd-lft">
						
							<!-- Profile Widget -->
							<div class="card widget-profile pat-widget-profile">
								<?php foreach($patient_data as $patient): ?>
									<div class="card-body">
										<div class="pro-widget-content">
											<div class="profile-info-widget">
												<a href="#" class="booking-doc-img">
													
													<img src="<?= base_url('uploads/' . $patient['Profile_url']) ?>" alt="User Image">
												</a>
												<div class="profile-det-info">
													<h3><?= $patient['FirstName'] ?> <?= $patient['LastName'] ?></h3>
													
													<div class="patient-details">
														<h5><b>Patient ID :</b> <?= $patient['PatientID'] ?></h5>
														<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $patient['Address'] ?></h5>
													</div>
												</div>
											</div>
										</div>
										<div class="patient-info">
											<ul>
												<li>Phone <span><?= $patient['Phone'] ?></span></li>
												<li>Age <span><?= $patient['Age'] ?> Years, <?= $patient['Gender'] ?></span></li>
												<li>Blood Group <span><?= $patient['Blood_type'] ?></span></li>
											</ul>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<!-- /Profile Widget -->
							
							
							
						</div>

						<div class="col-md-7 col-lg-8 col-xl-9 dct-appoinment">
							<div class="card">
								<div class="card-body pt-0">
									<div class="user-tabs">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pres" data-toggle="tab"><span>Prescription</span></a>
											</li>
											
										</ul>
									</div>
									<div class="tab-content">
										
										<!-- Appointment Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																	<th>Doctor</th>
																	<th>Appt Date</th>
																	<th>Booking Date</th>
																	<th>Status</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php foreach($merged_data as $mergedItem): ?>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="doctor-profile.html" class="avatar avatar-sm mr-2">
																					<img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $mergedItem['doctor']['Profile_url']) ?>" alt="User Image">
																				</a>
																				<a href="doctor-profile.html">Dra. <?= $mergedItem['doctor']['FirstName'] ?> <?= $mergedItem['doctor']['LastName'] ?> <span><?= $mergedItem['doctor']['Specialization'] ?></span></a>
																			</h2>
																		</td>
																		<td><?= date('d M Y', strtotime($mergedItem['appointment']['Pref_Date'])) ?> <span class="d-block text-info"><?= date('h.i A', strtotime($mergedItem['appointment']['Pref_Time_Start'])) ?></span></td>
																		<td><?= date('d M Y', strtotime($mergedItem['appointment']['created_at'])) ?></td>
																		<td><span class="badge badge-pill bg-info-light"><?= $mergedItem['appointment']['Status'] ?></span></td>
																		<td class="text-right">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
																					<i class="far fa-clock"></i> Reschedule
																				</a>
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
										
										<!-- Prescription Tab -->
<div class="tab-pane fade" id="pres">
    <?php foreach($patient_data as $patient): ?>
        <div class="text-right">
            <a href="<?= site_url('/Doctor/Dashboard/Add-Prescription/Patients-Profile/' . $patient['PatientID']) ?>" class="add-new-btn">Add Prescription</a>
        </div>
        <div class="card card-table mb-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Created by</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($merged_datas as $mergedItems): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($mergedItems['prescription']['created_at'])) ?></td>
                                <td>Prescription <?= $mergedItems['prescription']['PrescriptionID'] ?></td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                            <img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $mergedItems['doctor']['Profile_url']) ?>" alt="User Image">
                                        </a>
                                        <a href="doctor-profile.html">Dr. <?= $mergedItems['doctor']['FirstName'] ?> <?= $mergedItems['doctor']['LastName'] ?> <span><?= $mergedItem['doctor']['Specialization'] ?></span></a>
                                    </h2>
                                </td>
                                <td class="text-right">
                                    <div class="table-action">
                                        <a href="<?= site_url('/report/generatePres/' . $mergedItems['prescription']['PrescriptionID'] . '/Patients-Profile/' . $patient['PatientID']) ?>" class="btn btn-sm bg-primary-light">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                        <a href="<?= site_url('/Doctor/Dashboard/Edit-Prescription/' . $mergedItems['prescription']['PrescriptionID'] . '/Patients-Profile/' . $patient['PatientID']) ?>" class="btn btn-sm bg-info-light">
                                            <i class="far fa-eye"></i> View
                                        </a>

                                        <a href="#" class="btn btn-sm bg-danger-light delete-link" data-url="<?= site_url('/Doctor/Dashboard/Delete-Prescription/' . $mergedItems['prescription']['PrescriptionID'] . '/Patients-Profile/' . $patient['PatientID']) ?>">
											<i class="far fa-trash-alt"></i> Delete
										</a>

										

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- /Prescription Tab -->


										
												
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
										<script>
											document.addEventListener('DOMContentLoaded', function() {
												const deleteLinks = document.querySelectorAll('.delete-link');
												
												deleteLinks.forEach(link => {
													link.addEventListener('click', function(event) {
														event.preventDefault();
														const url = this.getAttribute('data-url');
														
														swal({
															title: "Are you sure?",
															text: "You will not be able to recover this prescription!",
															type: "warning",
															showCancelButton: true,
															confirmButtonColor: "#DD6B55",
															confirmButtonText: "Yes, delete it!",
															cancelButtonText: "No, cancel!",
															closeOnConfirm: false,
															closeOnCancel: false
														}, function(isConfirm) {
															if (isConfirm) {
																window.location.href = url;
															} else {
																swal("Cancelled", "Your prescription is safe :)", "error");
															}
														});
													});
												});
											});
										</script>
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
		
		<!-- Add Medical Records Modal -->
		<div class="modal fade custom-modal" id="add_medical_records">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Medical Records</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form>					
						<div class="modal-body">
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control datetimepicker" value="31-10-2019">
							</div>
							<div class="form-group">
								<label>Description ( Optional )</label>
								<textarea class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label>Upload File</label> 
								<input type="file" class="form-control">
							</div>	
							<div class="submit-section text-center">
								<button type="submit" class="btn btn-primary submit-btn">Submit</button>
								<button type="button" class="btn btn-secondary submit-btn" data-dismiss="modal">Cancel</button>							
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Medical Records Modal -->
	  
		<!-- jQuery -->
		<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?= base_url('assets/js/popper.min.js')?>"></script>
		<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Datetimepicker JS -->
		<script src="<?= base_url('assets/js/moment.min.js')?>"></script>
		<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js')?>"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="<?= base_url('assets/plugins/theia-sticky-sidebar/ResizeSensor.js')?>"></script>
        <script src="<?= base_url('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?= base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/patient-profile.html  30 Nov 2019 04:12:13 GMT -->
</html>