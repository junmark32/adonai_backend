<?php
$imagePath = 'uploads/logo-adonai.png';
$imageData = base64_encode(file_get_contents($imagePath));
$src = 'data:image/png;base64,' . $imageData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescription</title>
    <style>
        @page {
            size: A4;
            margin: 10mm; /* Adjust margins for more space */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt; /* Smaller font size */
            color: #333;
            line-height: 1.2;
            padding: 0;
            margin: 0;
        }
        .container {
            width: 100%;
        }
        .header-logo {
            display: block;
            margin-bottom: 10px; /* Reduced margin */
            overflow: hidden; /* Ensure items stay within bounds */
        }
        .header-logo {
            width: 100%;
            text-align: center; /* Center alignment of the container */
            margin-bottom: 10px; /* Reduced margin */
        }
        .header-logo div {
            display: inline-block;
            vertical-align: middle;
            width: 30%; /* Each item takes up 30% of the width */
            text-align: center; /* Center align text within each item */
        }
        .header-logo img {
            max-height: 40px; /* Adjusted logo size */
            vertical-align: middle; /* Align image with text */
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px; /* Reduced padding */
            background-color: #fff;
        }
        .card-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px; /* Reduced margin */
            padding-bottom: 2px; /* Reduced padding */
        }
        .card-header h4 {
            font-size: 18pt; /* Slightly smaller font size */
            color: #555;
        }
        .card-body {
            padding: 5px 0; /* Reduced padding */
        }
        h5 {
            font-size: 12pt; /* Smaller font size */
            margin: 10px 0; /* Reduced margin */
            color: #444;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px; /* Reduced margin */
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 5px; /* Reduced padding */
            text-align: left;
            font-size: 10pt; /* Smaller font size */
        }
        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .table td {
            background-color: #fafafa;
        }
        .form-group-row {
            margin-bottom: 10px; /* Reduced margin */
        }
        .form-group-row label {
            font-weight: bold;
            margin-bottom: 2px; /* Reduced margin */
            display: block;
        }
        .form-group-row p {
            margin: 2px 0; /* Reduced margin */
        }
        .highlight {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Prescription Report</h4>
            </div>
            <div class="card-body">
                <?php foreach ($prescription_data as $prescription): ?>
                    <div class="header-logo">
                        <div>RX</div>
                        <div><img src="<?= $src; ?>" alt="Adonai Logo"></div>
                        <div>PO No: <?= $prescription['PrescriptionID'] ?></div>
                    </div>

                    <h5>Personal Information</h5>
                    <table class="table">
                        <tr>
                            <td class="highlight">Name:</td>
                            <td><?= $prescription['Name'] ?></td>
                        </tr>
                        <tr>
                            <td class="highlight">Sex:</td>
                            <td><?= $prescription['Gender'] ?></td>
                            <td class="highlight">Date:</td>
                            <td><?= $prescription['Date'] ?></td>
                        </tr>
                        <tr>
                            <td class="highlight">Address:</td>
                            <td><?= $prescription['Address'] ?></td>
                        </tr>
                        <tr>
                            <td class="highlight">Age:</td>
                            <td><?= $prescription['Age'] ?></td>
                            <td class="highlight">B-day:</td>
                            <td><?= $prescription['DateOfBirth'] ?></td>
                        </tr>
                        <tr>
                            <td class="highlight">Occupation:</td>
                            <td><?= $prescription['Occupation'] ?></td>
                        </tr>
                        <tr>
                            <td class="highlight">CP#:</td>
                            <td><?= $prescription['Phone'] ?></td>
                        </tr>
                    </table>

                    <h5>Best Corrected Optical Power</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>SPH</th>
                                <th>CYL</th>
                                <th>AX</th>
                                <th>ADD</th>
                                <th>VA</th>
                                <th>PD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>OD</td>
                                <td><?= $prescription['B_OD_SPH'] ?></td>
                                <td><?= $prescription['B_OD_CYL'] ?></td>
                                <td><?= $prescription['B_OD_AX'] ?></td>
                                <td><?= $prescription['B_OD_ADD'] ?></td>
                                <td><?= $prescription['B_OD_VA'] ?></td>
                                <td><?= $prescription['B_OD_PD'] ?></td>
                            </tr>
                            <tr>
                                <td>OS</td>
                                <td><?= $prescription['B_OS_SPH'] ?></td>
                                <td><?= $prescription['B_OS_CYL'] ?></td>
                                <td><?= $prescription['B_OS_AX'] ?></td>
                                <td><?= $prescription['B_OS_ADD'] ?></td>
                                <td><?= $prescription['B_OS_VA'] ?></td>
                                <td><?= $prescription['B_OS_PD'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group-row">
                        <label>Ocular History:</label>
                        <p><?= $prescription['Ocular_History'] ?></p>
                    </div>

                    <h5>Lens Power Prescribed</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>SPH</th>
                                <th>CYL</th>
                                <th>AX</th>
                                <th>ADD</th>
                                <th>PD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>OD</td>
                                <td><?= $prescription['L_OD_SPH'] ?></td>
                                <td><?= $prescription['L_OD_CYL'] ?></td>
                                <td><?= $prescription['L_OD_AX'] ?></td>
                                <td><?= $prescription['L_OD_ADD'] ?></td>
                                <td><?= $prescription['L_OD_PD'] ?></td>
                            </tr>
                            <tr>
                                <td>OS</td>
                                <td><?= $prescription['L_OS_SPH'] ?></td>
                                <td><?= $prescription['L_OS_CYL'] ?></td>
                                <td><?= $prescription['L_OS_AX'] ?></td>
                                <td><?= $prescription['L_OS_ADD'] ?></td>
                                <td><?= $prescription['L_OS_PD'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group-row">
                        <label>Frame:</label>
                        <p><?= $prescription['Frame'] ?></p>
                        <label>Lens:</label>
                        <p><?= $prescription['Lens'] ?></p>
                    </div>
                    <div class="form-group-row">
                        <label>Total:</label>
                        <p><?= $prescription['Total'] ?></p>
                    </div>

                    <div class="form-group-row">
                        <label>Diagnosis:</label>
                        <p><?= $prescription['Diagnosis'] ?></p>
                    </div>
                    <div class="form-group-row">
                        <label>Remarks:</label>
                        <p><?= $prescription['Remarks'] ?></p>
                    </div>
                    <div class="form-group-row">
                        <label>Management:</label>
                        <p><?= $prescription['Management'] ?></p>
                    </div>
                    <div class="form-group-row">
                        <label>Follow Up:</label>
                        <p><?= $prescription['Follow_Up'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
