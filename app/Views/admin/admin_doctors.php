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
									<h3 class="page-title">List of Doctors</h3>
									<ul class="breadcrumb">
										<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
										<li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
										<li class="breadcrumb-item active">Doctor</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- /Page Header -->
						
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-body">
									<h5 class="card-title d-flex justify-content-between">
														<span>Personal Details</span> 
														<a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Add Doctor</a>
													</h5>
										<div class="table-responsive">
											<table class="datatable table table-hover table-center mb-0">
												<thead>
													<tr>
														<th>Doctor Name</th>
														<th>Speciality</th>
														<th>Member Since</th>
														<th>Account Status</th>
														
													</tr>
												</thead>
												<tbody>
												<?php if (!empty($doctors)): ?>
													<?php foreach ($doctors as $doctor): ?>
														<tr>
															<td>
																<h2 class="table-avatar">
																	<a href="profile.html" class="avatar avatar-sm mr-2">
																		<img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $doctor['Profile_url']) ?>" alt="User Image">
																	</a>
																	<a href="profile.html"><?php echo esc($doctor['FirstName']); ?> <?php echo esc($doctor['LastName']); ?></a>
																</h2>
															</td>
															<td><?php echo esc($doctor['Specialization']); ?></td>
															<td><?php echo esc(date('d M Y', strtotime($doctor['created_at']))); ?> <br><small><?php echo esc(date('h:i A', strtotime($doctor['created_at']))); ?></small></td>
															<td>
																<div class="status-toggle">
																	<input type="checkbox" id="status_<?php echo esc($doctor['DoctorID']); ?>" class="check" <?php echo $doctor['Status'] == 'Active' ? 'checked' : ''; ?>>
																	<label for="status_<?php echo esc($doctor['DoctorID']); ?>" class="checktoggle <?php echo $doctor['Status'] == 'Active' ? 'active' : ''; ?>">checkbox</label>
																</div>
															</td>
														</tr>
													<?php endforeach; ?>
												<?php else: ?>
													<tr>
														<td colspan="11">No doctors found.</td>
													</tr>
												<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<!-- Edit Details Modal -->
<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/doc-register') ?>" method="post" enctype="multipart/form-data">
                    <div class="row form-row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Enter last name">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="tel" class="form-control" name="phone" placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" name="dateOfBirth">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="" disabled selected>Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <h5 class="form-title"><span>Address</span></h5>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter address">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Details Modal -->

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