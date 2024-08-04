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

<hr>

<div class="col-lg-16">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Product History Table</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Re_Stock</th>
                            <th>Stock Quantity</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($prodHistory)) : ?>
                            <?php foreach($prodHistory as $history) : ?>
                                <tr>
                                    <td><?= esc($history['Name']); ?></td>
                                    <td><?= esc($history['Re-Stock']); ?></td>
                                    <td><?= esc($history['StockQuantity']); ?></td>
                                    <td>
                                        <?php 
                                            $createdAt = new DateTime($history['created_at']);
                                            echo esc($createdAt->format('d-m-Y h:i A'));
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4">No history available.</td>
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