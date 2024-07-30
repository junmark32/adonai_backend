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