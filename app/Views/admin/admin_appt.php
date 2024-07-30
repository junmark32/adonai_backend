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
								<h3 class="page-title">Appointments</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Appointments</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
					<div class="col-md-12">
						
						<!-- Recent Orders -->
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="datatable table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>Doctor Name</th>
												<th>Speciality</th>
												<th>Patient Name</th>
												<th>Apointment Time</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										<?php if(!empty($appointments)): ?>
											<?php foreach ($appointments as $appointment): ?>
											<tr>
												<td>
													<h2 class="table-avatar">
														<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $appointment->DoctorProfile_url) ?>" alt="User Image"></a>
														<a href="profile.html">Dra. <?= $appointment->DoctorFirstName ?> <?= $appointment->DoctorLastName ?></a>
													</h2>
												</td>
												<td><?= $appointment->Specialization ?></td>
												<td>
													<h2 class="table-avatar">
														<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= base_url('uploads/' . $appointment->PatientProfile_url) ?>" alt="User Image"></a>
														<a href="profile.html"><?= $appointment->PatientFirstName ?> <?= $appointment->PatientLastName ?> </a>
													</h2>
												</td>
												<td><?= date('d M Y', strtotime($appointment->Pref_Date)) ?> <span class="text-primary d-block"><?= date('g:i A', strtotime($appointment->Pref_Time_Start)) ?> - <?= date('g:i A', strtotime($appointment->Pref_Time_End)) ?></span></td>
												<td>
													<?= $appointment->Status ?>
												</td>
											</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="11">No appointments found.</td>
											</tr>
										<?php endif; ?>	
										</tbody>
									</table>
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