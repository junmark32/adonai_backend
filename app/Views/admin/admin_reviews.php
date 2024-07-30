<?= $this->include('include/admin_header') ?>
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
			
			<!-- Sidebar -->
			<?= $this->include('include/admin_sidebar') ?>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
                <div class="content container-fluid">
					
						<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Reviews</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Reviews</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Patient Name</th>
													<th>Doctor Name</th>
													<th>Ratings</th>
													<th>Description</th>
													<th>Date</th>
													<!-- <th class="text-right">Actions</th> -->
												</tr>
											</thead>
											<tbody>
											<?php if (!empty($docfeeds)): ?>
												<?php foreach ($docfeeds as $docfeed): ?>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . (!empty($docfeed->PatientProfile_url) ? $docfeed->PatientProfile_url : 'default_profile.jpg')) ?>" alt="User Image"></a>
															<a href="profile.html"><?= $docfeed->PatientFirstName ?> <?= $docfeed->PatientLastName ?> </a>
														</h2>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . (!empty($docfeed->DoctorProfile_url) ? $docfeed->DoctorProfile_url : 'default_profile.jpg')) ?>" alt="User Image"></a>
															<a href="profile.html">Dra. <?= $docfeed->DoctorFirstName ?> <?= $docfeed->DoctorLastName ?></a>
														</h2>
													</td>
													
													<td>
														<?php
														for ($i = 0; $i < 5; $i++) {
															if ($i < $docfeed->Rating) {
																echo '<i class="fe fe-star text-warning"></i>';
															} else {
																echo '<i class="fe fe-star-o text-secondary"></i>';
															}
														}
														?>
													</td>
													
													<td>
													<?php
														$maxLength = 50; // maximum length of the review before truncation
														$reviewText = $docfeed->Review;
														if (strlen($reviewText) > $maxLength) {
															$reviewText = substr($reviewText, 0, $maxLength) . '...';
														}
														echo $reviewText;
														?>
													</td>
														<td><?php 
														$dateTime = new DateTime($docfeed->created_at); 
														echo $dateTime->format('d M Y'); 
														?> 
														<br>
														<small>
														<?php 
														echo $dateTime->format('h:i A'); 
														?>
														</small></small></td>
													<!-- <td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal">
																<i class="fe fe-trash"></i> Delete
															</a>
															
														</div>
													</td> -->
												</tr>
												<?php endforeach; ?>
												<?php else: ?>
													<tr>
														<td colspan="11">No reviews found.</td>
													</tr>
												<?php endif; ?>	
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>			
					
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<script src="assets/plugins/raphael/raphael.min.js"></script>    
		<script src="assets/plugins/morris/morris.min.js"></script>  
		<script src="assets/js/chart.morris.js"></script>

		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>
		
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>