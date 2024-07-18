<?= $this->include('include/header') ?>
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
									<li class="breadcrumb-item active" aria-current="page">Doctor Profile</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Doctor Profile</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<!-- Doctor Widget -->
					<div class="card">
						<div class="card-body">
							<div class="doctor-widget">
								<div class="doc-info-left">
									<div class="doctor-img">
										<img src="<?= base_url('uploads/' . $doctor['Profile_url']) ?>" class="img-fluid" alt="User Image">
									</div>
									<div class="doc-info-cont">
										<h4 class="doc-name">Dr. <?= $doctor['FirstName'] ?> <?= $doctor['LastName'] ?></h4>
										<p class="doc-speciality"><?= $doctor['Specialization'] ?></p>
										<!-- <p class="doc-department"><img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">Dentist</p> -->
										<div class="rating">
                                            <!-- Display the doctor's rating -->
                                            <?php for ($i = 0; $i < $doctor['Rating']; $i++): ?>
                                                <i class="fas fa-star filled"></i>
                                            <?php endfor; ?>
                                            <span class="d-inline-block average-rating"><?= $doctor['Rating_count'] ?></span>
                                        </div>
										<div class="clinic-details">
											<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $doctor['Location'] ?> - <a href="javascript:void(0);">Get Directions</a></p>
											<!-- <ul class="clinic-gallery">
												<li>
													<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-01.jpg" alt="Feature">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
														<img  src="assets/img/features/feature-02.jpg" alt="Feature Image">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-03.jpg" alt="Feature">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-04.jpg" alt="Feature">
													</a>
												</li>
											</ul> -->
										</div>
										<div class="clinic-services">
											<!-- <span>Dental Fillings</span>
											<span>Teeth Whitneing</span> -->
										</div>
									</div>
								</div>
								<div class="doc-info-right">
									<div class="clini-infos">
										<ul>
											<li><i class="far fa-thumbs-up"></i> 99%</li>
											<li><i class="far fa-comment"></i> 35 Feedback</li>
											<li><i class="fas fa-map-marker-alt"></i> <?= $doctor['Location'] ?></li>
										</ul>
									</div>
									<div class="clinic-booking">
										<a class="apt-btn" href="booking.html">Book Appointment</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Doctor Widget -->
					
					<!-- Doctor Details Tab -->
					<div class="card">
						<div class="card-body pt-0">
						
							<!-- Tab Menu -->
							<nav class="user-tabs mb-4">
								<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
									<li class="nav-item">
										<a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
									</li>
								</ul>
							</nav>
							<!-- /Tab Menu -->
							
							<!-- Tab Content -->
							<div class="tab-content pt-0">
							
								<!-- Overview Content -->
								<div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
									<div class="row">
										<div class="col-md-12 col-lg-9">
										
											<!-- About Details -->
											<div class="widget about-widget">
												<h4 class="widget-title">About Me</h4>
												<p><?= $docabout['Biography'] ?></p>
											</div>
											<!-- /About Details -->
										
											<!-- Education Details -->
											<div class="widget education-widget">
												<h4 class="widget-title">Education</h4>
												<div class="experience-box">
                                                    <?php foreach ($doceduc as $educ): ?>
                                                        <ul class="experience-list">
                                                            <li>
                                                                <div class="experience-user">
                                                                    <div class="before-circle"></div>
                                                                </div>
                                                                <div class="experience-content">
                                                                    <div class="timeline-content">
                                                                        <a href="#/" class="name"><?= $educ['College'] ?></a>
                                                                        <div><?= $educ['Degree'] ?></div>
                                                                        <span class="time"><?= $educ['Year'] ?></span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php endforeach; ?>
												</div>
											</div>
											<!-- /Education Details -->
									
											<!-- Experience Details -->
											<div class="widget experience-widget">
												<h4 class="widget-title">Work & Experience</h4>
												<div class="experience-box">
                                                    <?php foreach ($docexp as $exp): ?>
                                                        <ul class="experience-list">
                                                            <li>
                                                                <div class="experience-user">
                                                                    <div class="before-circle"></div>
                                                                </div>
                                                                <div class="experience-content">
                                                                    <div class="timeline-content">
                                                                        <a href="#/" class="name"><?= $exp['Hosp_name'] ?></a>
                                                                        <span class="time"><?= $exp['From_where'] ?> - <?= $exp['To_where'] ?> <?= $exp['Designation'] ?></span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php endforeach; ?>
												</div>
											</div>
											<!-- /Experience Details -->
								
											<!-- Awards Details -->
											<div class="widget awards-widget">
												<h4 class="widget-title">Awards</h4>
												<div class="experience-box">
                                                    <?php foreach ($docawards as $awards): ?>
                                                        <ul class="experience-list">
                                                            <li>
                                                                <div class="experience-user">
                                                                    <div class="before-circle"></div>
                                                                </div>
                                                                <div class="experience-content">
                                                                    <div class="timeline-content">
                                                                        <p class="exp-year"><?= $awards['Year'] ?></p>
                                                                        <h4 class="exp-title"><?= $awards['Awards'] ?></h4>
                                                                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p> -->
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php endforeach; ?>
												</div>
											</div>
											<!-- /Awards Details -->
											
											<!-- Services List -->
											<div class="service-list">
												<h4>Services</h4>
                                                <?php foreach ($docserv as $serv): ?>
                                                    <ul class="clearfix">
                                                        <li><?= $serv['Services'] ?> </li>
                                                    </ul>
                                                <?php endforeach; ?>
											</div>
											<!-- /Services List -->
											
											<!-- Specializations List -->
											<div class="service-list">
												<h4>Specializations</h4>
												<?php foreach ($docspec as $spec): ?>
                                                    <ul class="clearfix">
                                                        <li><?= $spec['Specialization'] ?> </li>
                                                    </ul>
                                                <?php endforeach; ?>
											</div>
											<!-- /Specializations List -->

										</div>
									</div>
								</div>
								<!-- /Overview Content -->
								
								
								
								<!-- Reviews Content -->
								<div role="tabpanel" id="doc_reviews" class="tab-pane fade">
								
									<!-- Review Listing -->
									<div class="widget review-listing">
										<ul class="comments-list">
											<?php foreach ($reviews as $review): ?>
												<!-- Comment List -->
												<li>
													<div class="comment d-flex">
													<img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?= base_url('uploads/' . $review->Profile_url) ?>">
														<div class="comment-body flex-grow-1">
															<div class="meta-data">
																<span class="comment-author"><?= $review->FirstName ?> <?= $review->LastName ?></span>
																<span class="comment-date">
																	<?php
																	// Calculate the relative time
																	$reviewTime = \CodeIgniter\I18n\Time::parse($review->created_at);
																	echo 'Reviewed ' . $reviewTime->humanize();
																	?>
																</span>
															</div>
															<p class="comment-content">
																<?= $review->Review ?>
															</p>
														</div>
														<div class="review-count rating text-right">
															<?php for ($i = 0; $i < $review->Rating; $i++): ?>
																<i class="fas fa-star filled"></i>
															<?php endfor; ?>
															<?php for ($i = $review->Rating; $i < 5; $i++): ?>
																<i class="fas fa-star"></i>
															<?php endfor; ?>
														</div>
													</div>
												</li>
												<!-- /Comment List -->
											<?php endforeach; ?>
										</ul>
										
										<!-- Show All -->
										<div class="all-feedback text-center">
											<a href="#" class="btn btn-primary btn-sm">
												Show all feedback <strong>(167)</strong>
											</a>
										</div>
										<!-- /Show All -->
										
									</div>
									<!-- /Review Listing -->

								
									<!-- Write Review -->
									<div class="write-review">
										<h4>Write a review for <strong>Dr. <?= $doctor['FirstName'] ?> <?= $doctor['LastName'] ?></strong></h4>
										
										<!-- Write Review Form -->
									<form action="<?= base_url('/feedback/addReview') ?>" method="post">
										<div class="form-group">
											<label>Review</label>
											<div class="star-rating">
												<input id="star-5" type="radio" name="rating" value="5">
												<label for="star-5" title="5 stars">
													<i class="active fa fa-star"></i>
												</label>
												<input id="star-4" type="radio" name="rating" value="4">
												<label for="star-4" title="4 stars">
													<i class="active fa fa-star"></i>
												</label>
												<input id="star-3" type="radio" name="rating" value="3">
												<label for="star-3" title="3 stars">
													<i class="active fa fa-star"></i>
												</label>
												<input id="star-2" type="radio" name="rating" value="2">
												<label for="star-2" title="2 stars">
													<i class="active fa fa-star"></i>
												</label>
												<input id="star-1" type="radio" name="rating" value="1">
												<label for="star-1" title="1 star">
													<i class="active fa fa-star"></i>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label>Your review</label>
											<textarea id="review_desc" name="review_desc" maxlength="100" class="form-control"></textarea>
											<div class="d-flex justify-content-between mt-3">
												<small class="text-muted"><span id="chars">100</span> characters remaining</small>
											</div>
										</div>
										<hr>
										<div class="form-group">
											<div class="terms-accept">
												<div class="custom-checkbox">
													<input type="checkbox" id="terms_accept">
													<label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
												</div>
											</div>
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary submit-btn">Add Review</button>
										</div>
										<!-- Hidden fields for doctor and patient IDs -->
										<input type="hidden" name="doctor_id" value="<?= $doctor['DoctorID'] ?>"> <!-- Replace with actual doctor ID -->
										<input type="hidden" name="patient_id" value="<?= $userData['PatientID'] ?>"> <!-- Replace with actual patient ID -->
									</form>
									<!-- /Write Review Form -->

										
									</div>
									<!-- /Write Review -->
						
								</div>
								<!-- /Reviews Content -->
								
							
								
							</div>
						</div>
					</div>
					<!-- /Doctor Details Tab -->

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
		
		<!-- Voice Call Modal -->
		<div class="modal fade call-modal" id="voice_call">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<!-- Outgoing Call -->
						<div class="call-box incoming-box">
							<div class="call-wrapper">
								<div class="call-inner">
									<div class="call-user">
										<img alt="User Image" src="assets/img/doctors/doctor-thumb-02.jpg" class="call-avatar">
										<h4>Dr. Darren Elder</h4>
										<span>Connecting...</span>
									</div>							
									<div class="call-items">
										<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
										<a href="voice-call.html" class="btn call-item call-start"><i class="material-icons">call</i></a>
									</div>
								</div>
							</div>
						</div>
						<!-- Outgoing Call -->

					</div>
				</div>
			</div>
		</div>
		<!-- /Voice Call Modal -->
		
		<!-- Video Call Modal -->
		<div class="modal fade call-modal" id="video_call">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
					
						<!-- Incoming Call -->
						<div class="call-box incoming-box">
							<div class="call-wrapper">
								<div class="call-inner">
									<div class="call-user">
										<img class="call-avatar" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
										<h4>Dr. Darren Elder</h4>
										<span>Calling ...</span>
									</div>							
									<div class="call-items">
										<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
										<a href="video-call.html" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
									</div>
								</div>
							</div>
						</div>
						<!-- /Incoming Call -->
						
					</div>
				</div>
			</div>
		</div>
		<!-- Video Call Modal -->
		
		<!-- jQuery -->
		<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="<?php echo base_url('assets/js/popper.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Fancybox JS -->
		<script src="<?php echo base_url('assets/plugins/fancybox/jquery.fancybox.min.js')?>"></script>
		
		<!-- Custom JS -->
		<script src="<?php echo base_url('assets/js/script.js')?>"></script>
		
	</body>

<!-- doccure/doctor-profile.html  30 Nov 2019 04:12:16 GMT -->
</html>