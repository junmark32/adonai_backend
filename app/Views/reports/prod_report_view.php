<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Purchase Report</h1>
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
            <tr>
                <td><?= $purchase->PurchaseID; ?></td>
                <td><?= $purchase->FirstName . ' ' . $purchase->LastName; ?></td>
                <td><?= $purchase->Email; ?></td>
                <td><?= $purchase->ProductName; ?></td>
                <td><?= $purchase->LensBrand; ?></td>
                <td><?= $purchase->Status; ?></td>
                <td><?= $purchase->Quantity; ?></td>
                <td><?= $purchase->TotalAmount; ?></td>
                <td><?= date('Y-m-d', strtotime($purchase->PurchaseDate)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
