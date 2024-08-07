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
    <title>Optometry Appointment Slip</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .appointment-slip {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            width: 80px;
        }
    </style>
</head>
<body>

<div class="appointment-slip">
    <div class="header">
        <img src="<?= $src; ?>" alt="Clinic Logo">
        <h2>Adonai Clinic</h2>
        <p>XentroMall, Lumangbayan, Calapan City, Oriental Mindoro</p>
        <p>Phone: (123) 456-7890</p>
    </div>

    <hr>

    <div class="body">
        <h4 class="text-center">Appointment Slip</h4>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Acct. ID:</strong> <span><?= $patientData['patient_ID'] ?></span><br>
                <strong>Acct. Name:</strong> <span><?= $patientData['patient_first_name'] ?> <?= $patientData['patient_last_name'] ?></span></p>
                <p><strong>Patient Name:</strong> <?= $appt['appt_first_name'] ?> <?= $appt['appt_last_name'] ?></p>
            </div>
            <div class="col-md-6 text-right">
    <?php
        $appt_date = DateTime::createFromFormat('Y-m-d', $appt['appt_date'])->format('d-m-Y');
        $appt_start_time = DateTime::createFromFormat('H:i:s', $appt['appt_start_time'])->format('h:i A');
        $appt_end_time = DateTime::createFromFormat('H:i:s', $appt['appt_end_time'])->format('h:i A');
    ?>
    <p><strong>Appointment Date:</strong> <span><?= $appt_date ?></span><br>
    <strong>Time:</strong> <?= $appt_start_time ?> - <?= $appt_end_time ?></p>
    <p><strong>Doctor:</strong> <?= $appt['appt_doctor'] ?></p>
</div>

        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Purpose of Visit:</strong> <?= $appt['appt_purpose'] ?></p>
                <p><strong>Clinic Location:</strong> <?= $appt['appt_location'] ?></p>
            </div>
            <div class="col-md-6 text-right">
                <p><strong>Appointment ID:</strong> APPT<?= $appt['appt_id'] ?></p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <p><strong>Additional Notes:</strong> <?= $appt['appt_message'] ?></p>
                <p>Please bring your previous prescription glasses and any other relevant medical records.</p>
            </div>
        </div>
    </div>

    <hr>

    <div class="footer">
        <p>Thank you for choosing our clinic for your eye care needs. We look forward to serving you!</p>
        <p><strong>Website:</strong> www.optometryclinic.com | <strong>Email:</strong> contact@optometryclinic.com</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
