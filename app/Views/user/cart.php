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
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Cart</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Shopping Cart</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">&nbsp;</th>
                                        <th class="align-middle">&nbsp;</th>
                                        <th class="align-middle">Product Name &amp; Lens Details</th>
                                        <th class="align-middle text-center">Price</th>
                                        <th class="align-middle text-center">Quantity</th>
                                        <th class="align-middle text-center">Total</th>
                                        <th class="align-middle text-center">Select</th> <!-- New column for checkboxes -->
                                    </tr>
                                </thead>
                                <tbody>
    <?php foreach ($cartItems as $item) : ?>
        <tr>
            <td class="align-middle">
                <button type="button" class="close" aria-label="Close" onclick="window.location.href='<?= base_url('store/cart/remove/' . $item['CartID']) ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>
            </td>
            <td class="align-middle">
                <a href="product-details.php?product=<?= $item['product']['ProductID'] ?>">
                    <img src="<?= base_url('uploads/' . $item['product']['Image_url']) ?>" alt="Product Image" style="width: 100px;">
                </a>
            </td>
            <td class="align-middle">
                <div class="product-details">
                    <h3 class="product-name"><a href="product-details.php?product=<?= $item['product']['ProductID'] ?>"><?= $item['product']['Name'] ?> - ₱<?= $item['product']['Price']?></a></h3>
                    <p>LENS: <?= $item['lens']['Model'] ?> &nbsp; <?= $item['lens']['Brand'] ?> &nbsp; <?= $item['lens']['LensType'] ?> - ₱<?= $item['lens']['Price'] ?></p>
                </div>
            </td>
            <td class="align-middle text-center">₱<?= $item['product']['Price'] + $item['lens']['Price'] ?></td>
            <td class="align-middle text-center"><?= $item['Quantity'] ?></td>
            <td class="align-middle text-center">₱<?= $item['Quantity'] * ($item['product']['Price'] + $item['lens']['Price']) ?></td>
            <td class="align-middle text-center">
                <input type="checkbox" name="selectedItems[]" value="<?= $item['CartID'] ?>" onchange="updateCartTotal()">
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                            </table>
                            <hr style="border-top: 3px solid black;">
                            <h3><strong>Cart Total</strong></h3>
                            <div class="card-body">
                                <p id="cartTotal">Subtotal: ₱0</p> <!-- Display cart total here -->
                            </div>
                            <div class="card-footer">
                                <h5><strong>Thank You for Your Purchase! Important Information Regarding Your Eyeglasses</strong></h5>
                                <h6>Thank you for choosing Adonai for your eyeglass needs. We are committed to ensuring that you receive the best-fitted eyeglasses and optimal vision correction.</h6>
                                <h6>After checkout, please be aware that the eyeglasses you've selected will be available for pickup at our clinic. Prior to visiting our clinic, we kindly request you to schedule an appointment for an eye test. This step is crucial to ensure the accuracy of your prescription and the suitability of the selected eyeglasses.</h6>
                                <h6>Once your purchase is complete, you will receive an email containing a downloadable voucher confirming your order and appointment details. Please present this voucher to our clinic staff during your visit for the eye test. Following the test, you can proceed to collect the glasses you've ordered.</h6>
                                <br>
								<form id="checkoutForm" action="/store/cart/checkout" >
                                    <input type="checkbox" id="confirmCheckout">
                                    <label for="confirmCheckout">I confirm that I have checked the items and want to proceed to checkout.</label>
									<br>
                                    <button type="button" class="btn btn-primary btn-lg" onclick="checkout()">Checkout</button>
                                </form>
                            </div>
                            <div class="card-footer d-flex justify-content-center"> <!-- Updated to align button to the right -->
                                <!-- This section was removed because the checkout form is now within the previous card-footer -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->



<script>
    function updateCartTotal() {
        var checkboxes = document.getElementsByName('selectedItems[]');
        var cartTotal = 0;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                // Get the price of the selected item
                var price = parseFloat(document.querySelectorAll('tbody tr')[i].querySelectorAll('td')[5].innerText.replace('₱', ''));
                cartTotal += price;
            }
        }

        // Update the cart total displayed
        document.getElementById('cartTotal').innerText = 'Subtotal: ₱' + cartTotal.toFixed(2);
    }

    function checkout() {
        // Check if the confirmation checkbox is checked
        var confirmationCheckbox = document.getElementById('confirmCheckout');
        if (confirmationCheckbox.checked) {
            // Submit the form synchronously
            document.getElementById('checkoutForm').submit();
        } else {
            // If the confirmation checkbox is not checked, prompt the user to confirm
            alert("Please confirm that you want to proceed to checkout by checking the box.");
        }
    }
</script>








   
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
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- doccure/blank-page.html  30 Nov 2019 04:12:20 GMT -->
</html>