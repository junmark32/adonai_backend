<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Doccure - Dashboard</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
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
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="active"> 
								<a href="index.html"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li> 
								<a href="appointment-list.html"><i class="fe fe-layout"></i> <span>Appointments</span></a>
							</li>
							<li> 
								<a href="specialities.html"><i class="fe fe-users"></i> <span>Specialities</span></a>
							</li>
							<li> 
								<a href="doctor-list.html"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
							</li>
							<li> 
								<a href="patient-list.html"><i class="fe fe-user"></i> <span>Patients</span></a>
							</li>
							<li> 
								<a href="/Admin/Products"><i class="fe fe-shopping-bag"></i> <span>Products</span></a>
							</li>
							<li> 
								<a href="reviews.html"><i class="fe fe-star-o"></i> <span>Reviews</span></a>
							</li>
							<li> 
								<a href="transactions-list.html"><i class="fe fe-activity"></i> <span>Transactions</span></a>
							</li>
							<li> 
								<a href="settings.html"><i class="fe fe-vector"></i> <span>Settings</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="invoice-report.html">Invoice Reports</a></li>
								</ul>
							</li>
							<li class="menu-title"> 
								<span>Pages</span>
							</li>
							<li> 
								<a href="profile.html"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="login.html"> Login </a></li>
									<li><a href="register.html"> Register </a></li>
									<li><a href="forgot-password.html"> Forgot Password </a></li>
									<li><a href="lock-screen.html"> Lock Screen </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-warning"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="error-404.html">404 Error </a></li>
									<li><a href="error-500.html">500 Error </a></li>
								</ul>
							</li>
							<li> 
								<a href="blank-page.html"><i class="fe fe-file"></i> <span>Blank Page</span></a>
							</li>
							<li class="menu-title"> 
								<span>UI Interface</span>
							</li>
							<li> 
								<a href="components.html"><i class="fe fe-vector"></i> <span>Components</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-layout"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="form-basic-inputs.html">Basic Inputs </a></li>
									<li><a href="form-input-groups.html">Input Groups </a></li>
									<li><a href="form-horizontal.html">Horizontal Form </a></li>
									<li><a href="form-vertical.html"> Vertical Form </a></li>
									<li><a href="form-mask.html"> Form Mask </a></li>
									<li><a href="form-validation.html"> Form Validation </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"><i class="fe fe-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="tables-basic.html">Basic Tables </a></li>
									<li><a href="data-tables.html">Data Table </a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><i class="fe fe-code"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li class="submenu">
										<a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
										<ul style="display: none;">
											<li><a href="javascript:void(0);"><span>Level 2</span></a></li>
											<li class="submenu">
												<a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
												<ul style="display: none;">
													<li><a href="javascript:void(0);">Level 3</a></li>
													<li><a href="javascript:void(0);">Level 3</a></li>
												</ul>
											</li>
											<li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
										</ul>
									</li>
									<li>
										<a href="javascript:void(0);"> <span>Level 1</span></a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Welcome Admin!</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
											<i class="fe fe-users"></i>
										</span>
										<div class="dash-count">
											<h3><?php echo $doctorCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Doctors</h6>
										<div class="progress progress-sm">
											<?php
											// Example maximum count (you can adjust this according to your needs)
											$maxCount = 1000;

											// Calculate percentage
											$percentage = ($doctorCount / $maxCount) * 100;
											
											// Limit percentage to maximum of 100%
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
										<span class="dash-widget-icon text-success">
											<i class="fe fe-credit-card"></i>
										</span>
										<div class="dash-count">
											<h3><?php echo $patientCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Patients</h6>
										<div class="progress progress-sm">
											<?php
											// Example maximum count (you can adjust this according to your needs)
											$maxCount = 1000;

											// Calculate percentage
											$percentage = ($patientCount / $maxCount) * 100;
											
											// Limit percentage to maximum of 100%
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
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-money"></i>
										</span>
										<div class="dash-count">
											<h3><?php echo $appointmentCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Appointment</h6>
										<div class="progress progress-sm">
											<?php
											// Example maximum count (you can adjust this according to your needs)
											$maxCount = 1000;

											// Calculate percentage
											$percentage = ($appointmentCount / $maxCount) * 100;
											
											// Limit percentage to maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-danger" style="width: ' . $percentage . '%;"></div>';
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
										<span class="dash-widget-icon text-warning border-warning">
											<i class="fe fe-cart"></i>
										</span>
										<div class="dash-count">
											<h3><?php echo $productCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Products</h6>
										<div class="progress progress-sm">
											<?php
											// Example maximum count (you can adjust this according to your needs)
											$maxCount = 1000;

											// Calculate percentage
											$percentage = ($productCount / $maxCount) * 100;
											
											// Limit percentage to maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-warning" style="width: ' . $percentage . '%;"></div>';
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-6">
							
							<!-- Invoice Chart -->
<div class="card card-chart">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Patient Status</h4>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Select Interval
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#" onclick="updateChart('daily')">Daily</a>
                <a class="dropdown-item" href="#" onclick="updateChart('monthly')">Monthly</a>
                <a class="dropdown-item" href="#" onclick="updateChart('yearly')">Yearly</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="morrisLine"></div>
    </div>
</div>
<!-- /Invoice Chart -->

<script>
$(function(){
    // Initial data (e.g., yearly)
    const yearlyData = <?php echo json_encode($yearlyData); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const dailyData = <?php echo json_encode($dailyData); ?>;
    
    // Appointment data
    const appointmentYearlyData = <?php echo json_encode($appointmentYearlyData); ?>;
    const appointmentMonthlyData = <?php echo json_encode($appointmentMonthlyData); ?>;
    const appointmentDailyData = <?php echo json_encode($appointmentDailyData); ?>;

    function mergeData(patientData, appointmentData) {
        const mergedData = {};
        
        // Combine patient data
        patientData.forEach(item => {
            mergedData[item.y] = { y: item.y, a: item.a, b: 0 };
        });

        // Combine appointment data
        appointmentData.forEach(item => {
            if (mergedData[item.y]) {
                mergedData[item.y].b = item.b;
            } else {
                mergedData[item.y] = { y: item.y, a: 0, b: item.b };
            }
        });

        return Object.values(mergedData);
    }

    // Merge the data initially for yearly, monthly, and daily
    const mergedYearlyData = mergeData(yearlyData, appointmentYearlyData);
    const mergedMonthlyData = mergeData(monthlyData, appointmentMonthlyData);
    const mergedDailyData = mergeData(dailyData, appointmentDailyData);

    window.mL = Morris.Line({
        element: 'morrisLine',
        data: mergedYearlyData, // Initial data set to mergedYearlyData
        xkey: 'y',
        ykeys: ['a', 'b'], // 'a' for patients, 'b' for appointments
        labels: ['Patients', 'Appointments'],
        lineColors: ['#ff9d00', '#4CAF50'], // Different colors for patients and appointments
        lineWidth: 1,
        gridTextSize: 10,
        hideHover: 'auto',
        resize: true,
        redraw: true
    });

    $(window).on("resize", function(){
        mL.redraw();
    });

    window.updateChart = function(interval) {
        let newData, xLabel;
        switch(interval) {
            case 'daily':
                newData = mergedDailyData;
                xLabel = 'Day';
                break;
            case 'monthly':
                newData = mergedMonthlyData;
                xLabel = 'Month';
                break;
            case 'yearly':
                newData = mergedYearlyData;
                xLabel = 'Year';
                break;
            default:
                newData = mergedYearlyData;
                xLabel = 'Year';
                break;
        }
        mL.options.labels = ['Patients', 'Appointments'];
        mL.options.xkey = 'y';
        mL.options.ykeys = ['a', 'b'];
        mL.options.parseTime = false; // Prevents Morris.js from parsing the xkey as a date
        mL.setData(newData);
        // Update the x-axis label
        mL.options.labels = ['Patients', 'Appointments'];
    };
});
</script>


							
						</div>	

						<div class="col-md-12 col-lg-6">
						
							<!-- Sales Chart -->
							<div class="card card-chart">
								<div class="card-header">
									<h4 class="card-title">Product Sales</h4>
								</div>
								<div class="card-body">
									<div id="morrisArea"></div>
								</div>
							</div>
							<!-- /Sales Chart -->
							
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-6 d-flex">
						
							<!-- Recent Orders -->
							<div class="card card-table flex-fill">
								<div class="card-header">
									<h4 class="card-title">Doctors List</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor Name</th>
													<th>Speciality</th>
													<th>Earned</th>
													<th>Reviews</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Ruby Perrin</a>
														</h2>
													</td>
													<td>Dental</td>
													<td>$3200.00</td>
													<td>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star-o text-secondary"></i>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Darren Elder</a>
														</h2>
													</td>
													<td>Dental</td>
													<td>$3100.00</td>
													<td>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star-o text-secondary"></i>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-03.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Deborah Angel</a>
														</h2>
													</td>
													<td>Cardiology</td>
													<td>$4000.00</td>
													<td>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star-o text-secondary"></i>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-04.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Sofia Brient</a>
														</h2>
													</td>
													<td>Urology</td>
													<td>$3200.00</td>
													<td>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star-o text-secondary"></i>
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-05.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Marvin Campbell</a>
														</h2>
													</td>
													<td>Orthopaedics</td>
													<td>$3500.00</td>
													<td>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star text-warning"></i>
														<i class="fe fe-star-o text-secondary"></i>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->
							
						</div>
						<div class="col-md-6 d-flex">
						
							<!-- Feed Activity -->
							<div class="card  card-table flex-fill">
								<div class="card-header">
									<h4 class="card-title">Patients List</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>													
													<th>Patient Name</th>
													<th>Phone</th>
													<th>Last Visit</th>
													<th>Paid</th>													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient1.jpg" alt="User Image"></a>
															<a href="profile.html">Charlene Reed </a>
														</h2>
													</td>
													<td>8286329170</td>
													<td>20 Oct 2019</td>
													<td class="text-right">$100.00</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient2.jpg" alt="User Image"></a>
															<a href="profile.html">Travis Trimble </a>
														</h2>
													</td>
													<td>2077299974</td>
													<td>22 Oct 2019</td>
													<td class="text-right">$200.00</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient3.jpg" alt="User Image"></a>
															<a href="profile.html">Carl Kelly</a>
														</h2>
													</td>
													<td>2607247769</td>
													<td>21 Oct 2019</td>
													<td class="text-right">$250.00</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient4.jpg" alt="User Image"></a>
															<a href="profile.html"> Michelle Fairfax</a>
														</h2>
													</td>
													<td>5043686874</td>
													<td>21 Sep 2019</td>
													<td class="text-right">$150.00</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient5.jpg" alt="User Image"></a>
															<a href="profile.html">Gina Moore</a>
														</h2>
													</td>
													<td>9548207887</td>
													<td>18 Sep 2019</td>
													<td class="text-right">$350.00</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Feed Activity -->
							
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
						
							<!-- Recent Orders -->
							<div class="card card-table">
								<div class="card-header">
									<h4 class="card-title">Appointment List</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>Doctor Name</th>
													<th>Speciality</th>
													<th>Patient Name</th>
													<th>Apointment Time</th>
													<th>Status</th>
													<th class="text-right">Amount</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Ruby Perrin</a>
														</h2>
													</td>
													<td>Dental</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient1.jpg" alt="User Image"></a>
															<a href="profile.html">Charlene Reed </a>
														</h2>
													</td>
													<td>9 Nov 2019 <span class="text-primary d-block">11.00 AM - 11.15 AM</span></td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_1" class="check" checked>
															<label for="status_1" class="checktoggle">checkbox</label>
														</div>
													</td>
													<td class="text-right">
														$200.00
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Darren Elder</a>
														</h2>
													</td>
													<td>Dental</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient2.jpg" alt="User Image"></a>
															<a href="profile.html">Travis Trimble </a>
														</h2>
													</td>
													
													<td>5 Nov 2019 <span class="text-primary d-block">11.00 AM - 11.35 AM</span></td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_2" class="check" checked>
															<label for="status_2" class="checktoggle">checkbox</label>
														</div>
													</td>
													<td class="text-right">
														$300.00
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-03.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Deborah Angel</a>
														</h2>
													</td>
													<td>Cardiology</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient3.jpg" alt="User Image"></a>
															<a href="profile.html">Carl Kelly</a>
														</h2>
													</td>
													<td>11 Nov 2019 <span class="text-primary d-block">12.00 PM - 12.15 PM</span></td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_3" class="check" checked>
															<label for="status_3" class="checktoggle">checkbox</label>
														</div>
													</td>
													<td class="text-right">
														$150.00
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-04.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Sofia Brient</a>
														</h2>
													</td>
													<td>Urology</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient4.jpg" alt="User Image"></a>
															<a href="profile.html"> Michelle Fairfax</a>
														</h2>
													</td>
													<td>7 Nov 2019<span class="text-primary d-block">1.00 PM - 1.20 PM</span></td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_4" class="check" checked>
															<label for="status_4" class="checktoggle">checkbox</label>
														</div>
													</td>
													<td class="text-right">
														$150.00
													</td>
												</tr>
												<tr>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-05.jpg" alt="User Image"></a>
															<a href="profile.html">Dr. Marvin Campbell</a>
														</h2>
													</td>
													<td>Orthopaedics</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient5.jpg" alt="User Image"></a>
															<a href="profile.html">Gina Moore</a>
														</h2>
													</td>
													
													<td>15 Nov 2019 <span class="text-primary d-block">1.00 PM - 1.15 PM</span></td>
													<td>
														<div class="status-toggle">
															<input type="checkbox" id="status_5" class="check" checked>
															<label for="status_5" class="checktoggle">checkbox</label>
														</div>
													</td>
													<td class="text-right">
														$200.00
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->
							
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
		
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>