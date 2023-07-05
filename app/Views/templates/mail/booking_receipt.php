<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking receipt</title>
<style>
    .m-0 {
        margin: 0;
    }
</style>
</head>
<body>
    <?php
        $customerName = $bookingData->review->customer->lastName . ' ' . $bookingData->review->customer->firstName;
        $oneWayDestination = $bookingData->reservation->oneWayTrip->destination->description;
        $oneWayPickup = $bookingData->reservation->oneWayTrip->pickup->date . ' ' . $bookingData->reservation->oneWayTrip->pickup->time;
        $oneWayPassengers = $bookingData->reservation->oneWayTrip->passengers;
        $oneWayVehicle = $bookingData->selectCar->oneWayTrip->vehicle->carName;
    ?>

    <p>Dear <?= $customerName ?>,</p>

    <p>
        Congratulations! Your trip has been successfully booked! We are thrilled to confirm your travel arrangements and 
        can't wait for you to embark on this exciting journey. Thank you for choosing our services.
    </p>

    <p>
        Here are the details of your trip:
    </p>

    <p class="m-0">Destination: <?= $oneWayDestination ?></p>
    <p class="m-0">Departure Date: <?= $oneWayPickup ?></p>
    <p class="m-0">Number of Travelers: <?= $oneWayPassengers ?></p>
    <p class="m-0">Transportation: <?= $oneWayVehicle ?></p>

    <p>
        Please take a moment to review the information provided above and let us know if you have any questions or if any changes need to be made. 
        We want to ensure that your trip meets all your expectations.
    </p>

    <p>
        For any further assistance or inquiries, feel free to contact our customer support team at [Customer Support Contact Information]. 
        Our dedicated team is available around the clock to assist you.
    </p>

    <p>
        We hope you have an incredible journey filled with unforgettable experiences. Thank you again for choosing us as your travel partner. 
        We look forward to making your trip a memorable one!
    </p>

    <p>
        In case of unexpected events, you can also use this link to cancel booked reservation 
        <a href="<?= $cancelBookingLink ?>" target="_blank">Click here to cancel booking</a>, 
        and you will be refund automatically based on our policy.
    </p>

    <p>
        Best regards,<br/>
        Hello Shuttle CEO<br/>
        Hello Shuttle
    </p>
</body>
</html>