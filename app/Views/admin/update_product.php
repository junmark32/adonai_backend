<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Doccure - Blank Page</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('admin/assets/img/favicon.png')?>">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('admin/assets/css/bootstrap.min.css') ?>">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url('admin/assets/css/font-awesome.min.css')?>">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="<?php echo base_url('admin/assets/css/feathericon.min.css')?>">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url('admin/assets/css/style.css')?>">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="index.html" class="logo">
						<img src="assets/img/logo.png" alt="Logo">
					</a>
					<a href="index.html" class="logo logo-small">
						<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<div class="top-nav-search">
					<form>
						<input type="text" class="form-control" placeholder="Search here">
						<button class="btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">
					
					<!-- Notifications -->
					<li class="nav-item dropdown noti-dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/doctors/doctor-thumb-01.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/patients/patient1.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/patients/patient2.jpg">
												</span>
												<div class="media-body">
												<p class="noti-details"><span class="noti-title">Travis Trimble</span> sent a amount of $210 for his <span class="noti-title">appointment</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/patients/patient3.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Carl Kelly</span> send a message <span class="noti-title"> to his doctor</span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<a href="#">View all Notifications</a>
							</div>
						</div>
					</li>
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Ryan Taylor"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6>Ryan Taylor</h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.html">My Profile</a>
							<a class="dropdown-item" href="settings.html">Settings</a>
							<a class="dropdown-item" href="login.html">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li> 
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
							<li class="active"> 
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
								<h3 class="page-title">Product Management</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item">Products</li>
                                    <li class="breadcrumb-item active">Update Product</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					

                    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Product</h4>
            </div>
            <div class="card-body">
			<form action="/Admin/Products/update_Product" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title">Product details</h4>
            <input type="hidden" name="product_id[]" value="<?= $product['ProductID'] ?? '' ?>">
			<div class="form-group">
			<label>Image:</label>
			<input type="file" name="image" class="form-control-file">
			<?php if (!empty($product['Image_url'])): ?>
				<img src="<?= base_url('uploads/' . $product['Image_url']) ?>" alt="Product Image" style="max-width: 200px; margin-top: 10px;">
				<input type="hidden" name="old_image" value="<?= $product['Image_url'] ?>">
			<?php endif; ?>
		</div>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name[]" class="form-control" value="<?= $product['Name'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Brand:</label>
                <input type="text" name="brand[]" class="form-control" value="<?= $product['Brand'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Type:</label>
                <select class="form-control" name="type[]">
                    <option value="Eyeglasses" <?= ($product['Type'] ?? '') == 'Eyeglasses' ? 'selected' : '' ?>>Eyeglasses</option>
                    <option value="Reading Glasses" <?= ($product['Type'] ?? '') == 'Reading Glasses' ? 'selected' : '' ?>>Reading Glasses</option>
                    <option value="Accessories" <?= ($product['Type'] ?? '') == 'Accessories' ? 'selected' : '' ?>>Accessories</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="text" name="price[]" class="form-control" value="<?= $product['Price'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Stock Quantity:</label>
                <input type="text" name="stock_quantity[]" class="form-control" value="<?= $product['StockQuantity'] ?? '' ?>">
            </div>
        </div>
        <!-- Additional details section -->
        <div class="col-md-6">
            <h4 class="card-title">Additional details</h4>
            <div class="form-group">
                <label>Face shape:</label>
                <input type="text" name="faceshape[]" class="form-control" value="<?= $product['Faceshape'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Frame Shape:</label>
                <input type="text" name="frameshape[]" class="form-control" value="<?= $product['Frameshape'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Material:</label>
                <input type="text" name="material[]" class="form-control" value="<?= $product['Material'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select class="form-control" name="gender[]">
                    <option value="Men" <?= ($product['Gender'] ?? '') == 'Men' ? 'selected' : '' ?>>Men</option>
                    <option value="Women" <?= ($product['Gender'] ?? '') == 'Women' ? 'selected' : '' ?>>Women</option>
                </select>
            </div>
            <div class="form-group">
                <label>Frame Age:</label>
                <input type="text" name="frameage[]" class="form-control" value="<?= $product['Frameage'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Frame Size:</label>
                <input type="text" name="framesize[]" class="form-control" value="<?= $product['Framesize'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Full Frame Size:</label>
                <input type="text" name="fullframesize[]" class="form-control" value="<?= $product['Fullframesize'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Nose Bridge Size:</label>
                <input type="text" name="nosebridgesize[]" class="form-control" value="<?= $product['Nosebridgesize'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Temple Size:</label>
                <input type="text" name="templesize[]" class="form-control" value="<?= $product['Templesize'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Note:</label>
                <input type="text" name="note[]" class="form-control" value="<?= $product['Note'] ?? '' ?>">
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>


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
        <script src="<?php echo base_url('admin/assets/js/jquery-3.2.1.min.js')?>"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url('admin/assets/js/popper.min.js')?>"></script>
        <script src="<?php echo base_url('admin/assets/js/bootstrap.min.js')?>"></script>
		
		<!-- Slimscroll JS -->
        <script src="<?php echo base_url('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')?>"></script>
		
		<!-- Custom JS -->
		<script  src="<?php echo base_url('admin/assets/js/script.js')?>"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->
</html>