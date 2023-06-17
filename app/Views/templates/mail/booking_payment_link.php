<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking payment link</title>
<style>

</style>
</head>
<body>
    <p>Thank you for choosing us!</p>
    <p>You can click on below payment link to complete booking no: <?= $paymentData->bookingId ?>.</p>
    <ul>
        <li>
            <p>Payment link: <?= $paymentData->paymentLink ?></p>
        </li>
        <li>
            <p>Total price: &<?= $paymentData->total ?></p>
        </li>
        <li>
            <p>Created at: <?= $paymentData->bookingCreatedAt ?></p>
        </li>
    </ul>
</body>
</html>