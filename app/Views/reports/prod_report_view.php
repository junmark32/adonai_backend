<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Daily Sales Report</title>
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }

        header h1 {
            margin: 0;
            color: #333;
        }

        header p {
            color: #777;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-group {
            flex: 1;
            margin-right: 20px;
        }

        .info-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .totals {
            text-align: right;
            flex: 1;
        }

        .totals p {
            margin: 5px 0;
            font-weight: bold;
        }

        .totals span {
            display: inline-block;
            min-width: 100px;
            text-align: right;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details th, .details td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .details th {
            background-color: #f4f4f4;
        }

        .details tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <!-- Try using a relative path here if needed -->
            <img src="uploads/logo-adonai.png" alt="Company Logo">
            <h1>Sales Report</h1>
            <p>Generated for the period <?= $startDate; ?> to <?= $endDate; ?></p>
        </header>
        
        <section class="info">
            <div class="info-group">
                <h3>Sales Person: John Doe </h3>
            </div>
            <div class="totals">
                <?php
                    $totalSales = 0;
                    foreach ($purchases as $purchase) {
                        if ($purchase->Status == 'Completed') {
                            $totalSales += $purchase->TotalAmount;
                        }
                    }
                ?>
                <p>Sales Total: Php <?= number_format($totalSales, 2); ?></p>
            </div>
        </section>

        <section class="details">
            <table>
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
                    <th>Purchase Date</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($purchases as $purchase): ?>
                    <?php if ($purchase->Status == 'Completed'): ?>
                        <tr>
                            <td><?= $purchase->PurchaseID; ?></td>
                            <td><?= $purchase->FirstName . ' ' . $purchase->LastName; ?></td>
                            <td><?= $purchase->Email; ?></td>
                            <td><?= $purchase->ProductName; ?> <span><?= $purchase->ProductPrice; ?></span></td>
                            <td><?= $purchase->LensBrand; ?> <span><?= $purchase->LensPrice; ?></span></td>
                            <td><?= $purchase->Status; ?></td>
                            <td><?= $purchase->Quantity; ?></td>
                            <td><?= $purchase->TotalAmount; ?></td>
                            <td><?= date('Y-m-d', strtotime($purchase->PurchaseDate)); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>