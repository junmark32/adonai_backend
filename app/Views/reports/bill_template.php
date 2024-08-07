<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .receipt {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .receipt-header, .receipt-footer {
            text-align: center;
        }
        .receipt-header h4, .receipt-footer h5 {
            margin: 5px 0;
        }
        .receipt-table {
            width: 100%;
            margin: 20px 0;
        }
        .receipt-table th, .receipt-table td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .receipt-table .total-row {
            font-weight: bold;
        }
        .receipt-instruction {
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="receipt" style="max-height: 400px; overflow-y: auto;">
    <div class="receipt-header">
        <h4>Adonai Clinic</h4>
        <p>Robinson, Lumangbayan, Calapan, Oriental Mindoro<br>
        Tel: +9411396811<br>
        <?= esc(date('M d, Y h:i:s A')) ?><br>
        Table 1<br>
        Cashier: Owner Steward: Owner</p>
    </div>
    <table class="receipt-table table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($products) || !empty($lenses)): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= esc($product['Name']) ?></td>
                <td><?= esc($purchase['Quantity']) ?></td>
                <td><?= esc($product['Price']) ?></td>
                <td><?= esc($purchase['Quantity'] * $product['Price']) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($lenses as $lens): ?>
            <tr>
                <td><?= esc($lens['Brand']) ?></td>
                <td><?= esc($purchase['Quantity']) ?></td>
                <td><?= esc($lens['Price']) ?></td>
                <td><?= esc($lens['Price'] * $purchase['Quantity']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No items found.</td>
        </tr>
    <?php endif; ?>
</tbody>

        <tfoot>
            <tr>
                <td colspan="3">Discounts</td>
                <td><?= esc($purchase['discounts'] ?? 'N/A') ?></td>
            </tr>
            <tr class="total-row">
                <td colspan="3">TOTAL</td>
                <td><?= esc($purchase['TotalAmount'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <td colspan="3">CARD</td>
                <td><?= esc($purchase['card'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <td colspan="4">Total Items: <?= esc(count($products) + count($lenses)) ?> Total Units: <?= esc($purchase['total_units'] ?? '0') ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="receipt-instruction">
        <p>Please present this receipt to the cashier to receive your item</p>
    </div>
    <div class="receipt-footer">
        <h5>Thank You</h5>
        <p>www.adonai.com</p>
    </div>
</div>
</body>
</html>
