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
									<li class="breadcrumb-item active" aria-current="page">Add Prescription</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Edit Prescription</h2>
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
                <!-- Profile Widget -->
                <div class="card widget-profile pat-widget-profile">
                    <?php foreach ($patient_data as $patient): ?>
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
                                <li>Age <span>38 Years, Male</span></li>
                                <li>Blood Group <span>AB+</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- /Profile Widget -->
            </div>

            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Prescription</h4>
                    </div>
                    <div class="card-body">
                    <?php foreach ($prescription_data as $prescription): ?>
                        <div class="container">
                            <div class="header-logo">
                                <div>RX</div>
                                <div><img src="<?php echo base_url('uploads/logo-adonai.png'); ?>" alt="Adonai Logo"></div>
                                <div>PO no. <?= $prescription['PrescriptionID'] ?></div>
                            </div>
                            
                            
                            <form action="/Doctor/Dashboard/Update-Prescription/<?= $prescription['PrescriptionID'] ?>/Patients-Profile/<?= $patient['PatientID'] ?>" method="post" enctype="multipart/form-data">
                                <h5>Personal Information</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="col-sm-2 col-form-label">Name:</td>
                                            <td class="col-sm-10">
                                                <input type="text" class="form-control" name="name" value="<?= $prescription['Name'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2 col-form-label">Sex:</td>
                                            <td class="col-sm-1">
                                                <select class="form-control" name="sex">
                                                    <option <?= $prescription['Gender'] == 'M' ? 'selected' : '' ?>>M</option>
                                                    <option <?= $prescription['Gender'] == 'F' ? 'selected' : '' ?>>F</option>
                                                </select>
                                            </td>
                                            <td class="col-sm-1 col-form-label">Date:</td>
                                            <td class="col-sm-2">
                                                <input type="date" class="form-control" name="date" value="<?= $prescription['Date'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2 col-form-label">Address:</td>
                                            <td class="col-sm-10">
                                                <input type="text" class="form-control" name="address" value="<?= $prescription['Address'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-1 col-form-label">Age:</td>
                                            <td class="col-sm-1">
                                                <input type="number" class="form-control" name="age" value="<?= $prescription['Age'] ?>">
                                            </td>
                                            <td class="col-sm-1 col-form-label">B-day:</td>
                                            <td class="col-sm-3">
                                                <input type="date" class="form-control" name="birthday" value="<?= $prescription['DateOfBirth'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2 col-form-label">Occupation:</td>
                                            <td class="col-sm-10">
                                                <input type="text" class="form-control" name="occupation" value="<?= $prescription['Occupation'] ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-sm-2 col-form-label">CP#:</td>
                                            <td class="col-sm-10">
                                                <input type="text" class="form-control" name="cp" value="<?= $prescription['Phone'] ?>">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <h5>Best Corrected Optical Power</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>SPH</th>
                                                <th>CYL</th>
                                                <th>AX</th>
                                                <th>ADD</th>
                                                <th>VA</th>
                                                <th>PD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>OD</td>
                                                <td><input type="text" class="form-control" name="bc_od_sph" value="<?= $prescription['B_OD_SPH'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_od_cyl" value="<?= $prescription['B_OD_CYL'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_od_ax" value="<?= $prescription['B_OD_AX'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_od_add" value="<?= $prescription['B_OD_ADD'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_od_va" value="<?= $prescription['B_OD_VA'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_od_pd" value="<?= $prescription['B_OD_PD'] ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>OS</td>
                                                <td><input type="text" class="form-control" name="bc_os_sph" value="<?= $prescription['B_OS_SPH'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_os_cyl" value="<?= $prescription['B_OS_CYL'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_os_ax" value="<?= $prescription['B_OS_AX'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_os_add" value="<?= $prescription['B_OS_ADD'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_os_va" value="<?= $prescription['B_OS_VA'] ?>"></td>
                                                <td><input type="text" class="form-control" name="bc_os_pd" value="<?= $prescription['B_OS_PD'] ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Ocular History:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="ocular_history" rows="3"><?= $prescription['Ocular_History'] ?></textarea>
                                    </div>
                                </div>
                                
                                <h5>Lens Power Prescribed</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>SPH</th>
                                                <th>CYL</th>
                                                <th>AX</th>
                                                <th>ADD</th>
                                                <th>PD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>OD</td>
                                                <td><input type="text" class="form-control" name="lp_od_sph" value="<?= $prescription['L_OD_SPH'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_od_cyl" value="<?= $prescription['L_OD_CYL'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_od_ax" value="<?= $prescription['L_OD_AX'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_od_add" value="<?= $prescription['L_OD_ADD'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_od_pd" value="<?= $prescription['L_OD_PD'] ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>OS</td>
                                                <td><input type="text" class="form-control" name="lp_os_sph" value="<?= $prescription['L_OS_SPH'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_os_cyl" value="<?= $prescription['L_OS_CYL'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_os_ax" value="<?= $prescription['L_OS_AX'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_os_add" value="<?= $prescription['L_OS_ADD'] ?>"></td>
                                                <td><input type="text" class="form-control" name="lp_os_pd" value="<?= $prescription['L_OS_PD'] ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Frame:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="frame" value="<?= $prescription['Frame'] ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Lens:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="lens" value="<?= $prescription['Lens'] ?>">
                                    </div>
                                </div>
                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Total:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="total" value="<?= $prescription['Total'] ?>">
                                    </div>
                                </div>

                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Diagnosis:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="diagnosis" rows="2"><?= $prescription['Diagnosis'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Remarks:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="remarks" rows="2"><?= $prescription['Remarks'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Management:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="management" rows="2"><?= $prescription['Management'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-group-row">
                                    <label class="col-sm-2 col-form-label">Follow Up:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="follow_up" rows="2"><?= $prescription['Follow_Up'] ?></textarea>
                                    </div>
                                </div>

                                <!-- Submit Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                            <button type="reset" class="btn btn-secondary submit-btn">Clear</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Submit Section -->
                            </form>
                            
                        </div>
                    <?php endforeach; ?>
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
	  
		<!-- jQuery -->
		<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?= base_url('assets/js/popper.min.js')?>"></script>
		<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="<?= base_url('assets/plugins/theia-sticky-sidebar/ResizeSensor.js')?>"></script>
        <script src="<?= base_url('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?= base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/add-prescription.html  30 Nov 2019 04:12:37 GMT -->
</html>