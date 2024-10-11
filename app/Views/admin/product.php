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
								<h3 class="page-title">Product Management</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Products</li>
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
											<i class="fa fa-shopping-cart"></i>
										</span>
										<div class="dash-count">
											<h3><?php echo $purchaseCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Pending Orders</h6>
										
										<div class="progress progress-sm">
											<?php
											// Ensure $returnedCount and $purchaseCount are not negative to avoid division by zero or negative percentages
											$returnedCount = max(0, $returnedCount);
											$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

											// Calculate percentage
											$percentage = ($returnedCount / $purchaseCount) * 100;

											// Limit percentage to maximum of 100%
											$percentage = min($percentage, 0);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-primary" style="width:100%;"></div>';
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
										<span class="dash-widget-icon text-warning">
										<i class="fe fe-clock"></i>

										</span>
										<div class="dash-count">
											<h3><?php echo $onprocessCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">On Process</h6>
										<div class="progress progress-sm">
											<?php
											// Ensure $returnedCount and $purchaseCount are not negative to avoid division by zero or negative percentages
											$onprocessCount = max(0, $onprocessCount);
											$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

											// Calculate percentage
											$percentage = ($onprocessCount / $purchaseCount) * 100;

											// Limit percentage to maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-warning" style="width: 100%;"></div>';
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
										<span class="dash-widget-icon text-success border-success">
										<i class="fa fa-cubes"></i>

										</span>
										<div class="dash-count">
											<h3><?php echo $completeCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Complete Items</h6>
										<div class="progress progress-sm">
											<?php
											// Ensure $soldCount is not negative
											$completeCount = max(0, $completeCount);

											// Use a fixed value or a different count for the denominator to calculate the percentage
											$totalItems = $completeCount; // Replace $purchaseCount with the total number of items or an appropriate denominator

											// Avoid division by zero
											if ($totalItems > 0) {
												$percentage = ($completeCount / $totalItems) * 100;
											} else {
												$percentage = 0;
											}

											// Limit percentage to a maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-success" style="width:100%;"></div>';
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
										<i class="fa fa-reply"></i>

										</span>
										<div class="dash-count">
											<h3><?php echo $returnedCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Returned Items</h6>
										<div class="progress progress-sm">
											<?php
											// Ensure $returnedCount and $purchaseCount are not negative to avoid division by zero or negative percentages
											$returnedCount = max(0, $returnedCount);
											$purchaseCount = max(1, $purchaseCount); // Use max(1, $purchaseCount) to avoid division by zero

											// Calculate percentage
											$percentage = ($returnedCount / $purchaseCount) * 100;

											// Limit percentage to maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-danger" style="width:100%;"></div>';
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>

					<!-- /Page Header -->

					<div class="row">
						
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-secondary border-secondary">
										<i class="fa fa-cubes"></i>

										</span>
										<div class="dash-count">
											<h3><?php echo $soldCount; ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										
										<h6 class="text-muted">Sold Items</h6>
										<div class="progress progress-sm">
											<?php
											// Ensure $soldCount is not negative
											$soldCount = max(0, $soldCount);

											// Use a fixed value or a different count for the denominator to calculate the percentage
											$totalItems = $completeCount; // Replace $purchaseCount with the total number of items or an appropriate denominator

											// Avoid division by zero
											if ($totalItems > 0) {
												$percentage = ($soldCount / $totalItems) * 100;
											} else {
												$percentage = 0;
											}

											// Limit percentage to a maximum of 100%
											$percentage = min($percentage, 100);

											// Print the progress bar with dynamic width
											echo '<div class="progress-bar bg-secondary" style="width:100%;"></div>';
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<hr>

					<!-- Sales Chart -->
<div class="card card-chart">
    <div class="card-header">
        <h4 class="card-title">Product Sales</h4>
        <div class="d-flex flex-wrap align-items-center">
            <div class="dropdown mr-2">
                <select id="monthDropdown" class="form-control">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="d-flex flex-wrap align-items-center ml-auto">
                <label for="startDate" class="mr-2 mb-0">Start Date:</label>
                <input type="date" id="startDate" class="form-control d-inline-block" style="width: auto; max-width: 150px;">
                <label for="endDate" class="mx-2 mb-0">End Date:</label>
                <input type="date" id="endDate" class="form-control d-inline-block" style="width: auto; max-width: 150px;">
                <button id="generateReport" class="btn btn-primary ml-2">Generate Report</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="morrisArea"></div>
    </div>
</div>
<!-- /Sales Chart -->


<script>
$(function() {
    // Data from the server
    var purchaseDailyData = <?= json_encode($purchaseDailyData); ?>;

    // Initialize Morris Area Chart
    var mA = Morris.Area({
        element: 'morrisArea',
        data: purchaseDailyData,
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Sales'],
        lineColors: ['#1b5a90'],
        lineWidth: 2,
        fillOpacity: 0.5,
        gridTextSize: 10,
        hideHover: 'auto',
        resize: true,
        redraw: true
    });

    // Update chart data based on selected month
    $('#monthDropdown').change(function() {
        var selectedMonth = $(this).val();
        var selectedMonthName = $(this).find('option:selected').text();
        
        // Filter data based on the selected month
        var filteredData = purchaseDailyData.filter(function(data) {
            return data.y.slice(5, 7) === selectedMonth;
        });

        // Update chart with filtered data and new label
        mA.options.labels = [selectedMonthName + ' Sales'];
        mA.setData(filteredData);
    });
});
</script>


						
<!-- Feed Activity -->
<div class="card card-table flex-fill">
    <div class="card-header">
        <h4 class="card-title">Recent Purchase Eyeglasses</h4>
        <div class="d-flex flex-wrap align-items-center">
            <div class="mb-2 mb-md-0 d-flex align-items-center">
                <label for="rowLimit" class="mr-2 mb-0">Show:</label>
                <select id="rowLimit" class="form-control d-inline-block" style="width: auto;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <label for="rowLimit" class="ml-2 mb-0">entries</label>
            </div>
            <div class="ml-auto mb-2 mb-md-0 d-flex align-items-center">
                <button id="prevPage" class="btn btn-secondary mr-2">Previous</button>
                <button id="nextPage" class="btn btn-secondary">Next</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table id="purchaseTable" class="table table-hover table-center mb-0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Product</th>
                        <th>Lens</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchases as $purchase): ?>
                    <tr id="purchase_<?php echo $purchase->PurchaseID; ?>">
                        <td><?php echo $purchase->PurchaseID; ?></td>
                        <td><?php echo $purchase->FirstName; ?> <?php echo $purchase->LastName; ?></td>
                        <td><?php echo $purchase->Email; ?></td>
                        <td><?php echo $purchase->ProductName; ?></td>
                        <td><?php echo $purchase->LensBrand; ?></td>
                        <td>
                            <form id="form_<?php echo $purchase->PurchaseID; ?>" class="status-form">
                                <input type="hidden" name="purchase_id" value="<?php echo $purchase->PurchaseID; ?>">
                                <select name="status" class="form-control status-select">
                                    <option value="Pending" <?php if ($purchase->Status == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="On-Process" <?php if ($purchase->Status == 'On-Process') echo 'selected'; ?>>On-Process</option>
                                    <option value="Completed" <?php if ($purchase->Status == 'Completed') echo 'selected'; ?>>Completed</option>
                                    <option value="Returned" <?php if ($purchase->Status == 'Returned') echo 'selected'; ?>>Returned</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo $purchase->Quantity; ?></td>
                        <td><?php echo $purchase->TotalAmount; ?></td>
                        <td>
                            <!-- Add additional actions here if needed -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /Feed Activity -->



<script>
document.getElementById('generateReport').addEventListener('click', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;

    if (startDate && endDate) {
        var formData = new FormData();
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);

        fetch('<?= base_url('report/generateReport') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.blob())
        .then(blob => {
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'report.pdf'; // This will trigger the download
            document.body.appendChild(a);
            a.click();
            a.remove(); // Clean up
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please select both start date and end date.');
    }
});


</script>

<script>
    // JavaScript to handle status update using AJAX
    document.addEventListener('DOMContentLoaded', function () {
        const statusForms = document.querySelectorAll('.status-form');

        statusForms.forEach(form => {
            form.addEventListener('change', function (event) {
                event.preventDefault();

                const formData = new FormData(form);
                const purchaseId = formData.get('purchase_id');
                const status = formData.get('status');

                fetch('<?php echo base_url('purchase/updateStatus'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the status in the table cell
                        const statusCell = document.querySelector(`#purchase_${purchaseId} .status-select`);
                        statusCell.value = status;
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating status.');
                });
            });
        });
    });
</script>



<script>
	document.addEventListener('DOMContentLoaded', function () {
    const rowLimit = document.getElementById('rowLimit');
    const purchaseTable = document.getElementById('purchaseTable');
    const rows = purchaseTable.getElementsByTagName('tr');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowLimit.value, 10);

    function updateTable() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        for (let i = 0; i < rows.length; i++) {
            if (i >= startIndex && i < endIndex) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function goToPage(page) {
        currentPage = page;
        updateTable();
    }

    rowLimit.addEventListener('change', function () {
        rowsPerPage = parseInt(rowLimit.value, 10);
        goToPage(1); // Reset to the first page when rows per page changes
    });

    prevPageBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            goToPage(currentPage - 1);
        }
    });

    nextPageBtn.addEventListener('click', function () {
        const maxPage = Math.ceil(rows.length / rowsPerPage);
        if (currentPage < maxPage) {
            goToPage(currentPage + 1);
        }
    });

    updateTable(); // Initial call to set up the table
});


</script>


<div class="row">
    <!-- Feed Activity -->
    <div class="col-md-8">
        <div class="card card-table flex-fill">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Best Selling Eyeglasses</h4>
                    <div class="form-inline">
                        <label for="rowLimit" class="mr-2">Show:</label>
                        <select id="rowLimit" class="form-control">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <label for="rowLimit" class="ml-2 mr-2">entries</label>
                        <button id="bprevPage" class="btn btn-secondary mr-2">Previous</button>
                        <button id="bnextPage" class="btn btn-secondary">Next</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Orders</th>
                            </tr>
                        </thead>
                        <tbody id="bestTable">
                            <?php foreach ($bestselling as $index => $bestsell): ?>
                            <tr class="product-row" data-name="<?php echo $bestsell->Name; ?>" data-brand="<?php echo $bestsell->Brand; ?>" data-type="<?php echo $bestsell->Type; ?>" data-lens="<?php echo $bestsell->LensBrand; ?>" data-image="<?= base_url('uploads/' . $bestsell->Image_url); ?>" data-quantity="<?php echo $bestsell->TotalQuantity; ?>" <?php echo $index === 0 ? 'id="firstProduct"' : ''; ?>>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('uploads/' . $bestsell->Image_url); ?>" alt="<?php echo $bestsell->Name; ?>" class="mr-2" style="max-width: 50px; max-height: 50px;">
                                        <div>
                                            <div><?php echo $bestsell->Name; ?></div>
                                            <div><?php echo $bestsell->Brand; ?></div>
                                            <div><?php echo $bestsell->Type; ?></div>
											<div><?php echo $bestsell->LensBrand; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $bestsell->TotalQuantity; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Feed Activity -->

    <!-- Product Viewer Card -->
    <div class="col-md-4 d-flex">
        <div class="card flex-fill">
            <img id="viewerImage" alt="Card Image" src="assets/img/img-01.jpg" class="card-img-top">
            <div class="card-header">
                <h5 id="viewerTitle" class="card-title mb-0">Card with image and list</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li id="viewerName" class="list-group-item">Cras justo odio</li>
                <li id="viewerBrand" class="list-group-item">Dapibus ac facilisis in</li>
                <li id="viewerType" class="list-group-item">Vestibulum at eros</li>
				<li id="viewerLens" class="list-group-item">Vestibulum at erosq</li>
                <li id="viewerQuantity" class="list-group-item">Orders: 0</li>
            </ul>
        </div>
    </div>
    <!-- /Product Viewer Card -->
</div>




<script>
	document.addEventListener('DOMContentLoaded', function () {
    const rowLimit = document.getElementById('rowLimit');
    const purchaseTable = document.getElementById('bestTable');
    const rows = purchaseTable.getElementsByTagName('tr');
    const prevPageBtn = document.getElementById('bprevPage');
    const nextPageBtn = document.getElementById('bnextPage');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowLimit.value, 10);

    function updateTable() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        for (let i = 0; i < rows.length; i++) {
            if (i >= startIndex && i < endIndex) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function goToPage(page) {
        currentPage = page;
        updateTable();
    }

    rowLimit.addEventListener('change', function () {
        rowsPerPage = parseInt(rowLimit.value, 10);
        goToPage(1); // Reset to the first page when rows per page changes
    });

    prevPageBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            goToPage(currentPage - 1);
        }
    });

    nextPageBtn.addEventListener('click', function () {
        const maxPage = Math.ceil(rows.length / rowsPerPage);
        if (currentPage < maxPage) {
            goToPage(currentPage + 1);
        }
    });

    updateTable(); // Initial call to set up the table
});


</script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    function updateProductViewer(row) {
        const name = row.getAttribute('data-name');
        const brand = row.getAttribute('data-brand');
        const type = row.getAttribute('data-type');
		const lens = row.getAttribute('data-lens');
        const image = row.getAttribute('data-image');
        const quantity = row.getAttribute('data-quantity');

        // Update the product viewer card
        document.getElementById('viewerImage').src = image;
        document.getElementById('viewerImage').alt = name;
        document.getElementById('viewerTitle').innerText = name;
        document.getElementById('viewerName').innerText = `Name: ${name}`;
        document.getElementById('viewerBrand').innerText = `Brand: ${brand}`;
        document.getElementById('viewerType').innerText = `Type: ${type}`;
		document.getElementById('viewerLens').innerText = `Lens: ${lens}`;
        document.getElementById('viewerQuantity').innerText = `Orders: ${quantity}`;
    }

    // Update product viewer with the first product by default
    const firstProductRow = document.getElementById('firstProduct');
    if (firstProductRow) {
        updateProductViewer(firstProductRow);
    }

    // Add click event listener to each product row
    document.querySelectorAll('.product-row').forEach(row => {
        row.addEventListener('click', () => {
            updateProductViewer(row);
        });
    });
});

</script>
							
						

					<!-- /Page Header -->
					<hr>

					<div class="row">
						<div class="col-sm-12">
                            <h4 class="card-title d-flex justify-content-between">
                                <a class="edit-link" href="/Admin/Products/Add_Product"><i class="fa fa-plus-circle"></i> Add Product</a>
                            </h4>
                           
						</div>			
					</div>

                    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab">All Products</a></li>
                                    <!-- Add more tabs as needed for Women, Men, Accessories, etc. -->
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="bottom-tab1">
                                        <div class="row">
                                            <!-- Loop through products and generate product cards -->
                                            <?php foreach ($products as $product): ?>
                                            <div class="col-md-3 mb-4">
                                                <div class="card product-card">
                                                    <img src="<?= base_url('uploads/' . $product['Image_url']) ?>" class="card-img-top" alt="<?= $product['Name'] ?>">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?= $product['Name'] ?></h5>
                                                        <p class="card-text">₱ <?= $product['Price'] ?></p>
                                                        <hr>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- Update button with product ID as parameter -->
                                                            <a href="<?= base_url('/Admin/Products/Edit_Product/' . $product['ProductID']) ?>" class="btn btn-rounded btn-outline-primary">Update</a>
                                                            <button type="button" class="btn btn-rounded btn-danger">Disable</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <!-- Add more tab panes for other product categories -->
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
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->
</html>