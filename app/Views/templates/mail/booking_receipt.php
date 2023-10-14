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

    .mt-0 {
        margin-top: 0;
    }
    .mt-1 {
        margin-top: 1rem;
    }
    .policy__notices {
        font-size: 0.65rem;
        color: grey;
    }
</style>
</head>
<body>
    <?php
        $tripType = $bookingData->reservation->tripType;
        $customerName = $bookingData->review->customer->lastName . ' ' . $bookingData->review->customer->firstName;

        $airlane = $bookingData->review->airline->brand ? $bookingData->review->airline->brand->text : 'N/A';
        $flightNumber = $bookingData->review->airline->flightNumber ? $bookingData->review->airline->flightNumber : 'N/A';
        $additionalNotes = $bookingData->review->additionalNotes ? $bookingData->review->additionalNotes : 'N/A';

        $oneWayDestination = $bookingData->reservation->oneWayTrip->destination->description;
        $oneWayHasRestStop = $bookingData->reservation->oneWayTrip->hasRestStop;
        $oneWayRestStop = $oneWayHasRestStop ? $bookingData->reservation->oneWayTrip->restStop->description : null;
        $oneWayPickup = $bookingData->reservation->oneWayTrip->pickup->date . ' ' . $bookingData->reservation->oneWayTrip->pickup->time;
        $oneWayPassengers = $bookingData->reservation->oneWayTrip->passengers;
        $oneWayVehicle = $bookingData->selectCar->oneWayTrip->vehicle->carName;

        if ($tripType === 'round-trip') {
            $roundTripDestination = $bookingData->reservation->roundTrip->destination->description;
            $roundTripHasRestStop = $bookingData->reservation->roundTrip->hasRestStop;
            $roundTripRestStop = $roundTripHasRestStop ? $bookingData->reservation->roundTrip->restStop->description : null;
            $roundTripPickup = $bookingData->reservation->roundTrip->pickup->date . ' ' . $bookingData->reservation->roundTrip->pickup->time;
            $roundTripPassengers = $bookingData->reservation->roundTrip->passengers;
            $roundTripVehicle = $bookingData->selectCar->roundTrip->vehicle->carName;
        }
    ?>

    <p>Dear <?= $customerName ?>,</p>

    <p>
        Congratulations! Your trip has been successfully booked! We are thrilled to confirm your travel arrangements and 
        can't wait for you to embark on this exciting journey. Thank you for choosing our services.
    </p>

    <p>
        Here are the details of your trips:
    </p>

    <ol>
        <li>
            <ul>
                <li>Destination: <?= $oneWayDestination ?></li>
                <li>Rest stop: <?= $oneWayRestStop ?></li>
                <li>Departure date: <?= $oneWayPickup ?></li>
                <li>Number of travelers: <?= $oneWayPassengers ?></li>
                <li>Transportation: <?= $oneWayVehicle ?></li>
            </ul>
        </li>
        <?php if($tripType === 'round-trip'): ?>
            <li class="mt-1">
                <ul>
                    <li>Destination: <?= $roundTripDestination ?></li>
                    <li>Rest stop: <?= $roundTripRestStop ?></li>
                    <li>Departure date: <?= $roundTripPickup ?></li>
                    <li>Number of travelers: <?= $roundTripPassengers ?></li>
                    <li>Transportation: <?= $roundTripVehicle ?></li>
                </ul>
            </li>
        <?php endif ?>
    </ol>

    <ul>
        <li>Airlane: <?= $airlane ?></li>
        <li>Flight number: <?= $flightNumber ?></li>
        <li>Additional notes: <?= $additionalNotes ?></li>
    </ul>

    <p>
        Please take a moment to review the information provided above and let us know if you have any questions or if any changes need to be made. 
        We want to ensure that your trip meets all your expectations.
    </p>

    <p>
        For any further assistance or inquiries, feel free to contact our customer support team at (949) 800-5678. 
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
    <p class="policy__notices">
        *Gratuity - (Standard gratuity rate is 20%)* Fares listed do not include gratuity. 
        If you'd like to show your appreciation to your driver, your gesture is greatly welcomed. 
        You can provide a gratuity in Zelle, Venmo or Cash at the end of your trip or request your 
        preferred dollar amount or percentage to be added to your reservation. 
        We'll then send you an updated receipt via email.
    </p>
    <p class="policy__notices">
        *Where to Find Your Driver at the Airport* Your driver will be waiting for you right in front of your terminal. 
        Please do not proceed to the Uber/Lyft/Taxi transportation lot outside the airport. 
        Your driver will reach out to you via text and calls prior to your scheduled pickup time. 
        You should be ready at the curb in front of your terminal, and your driver will be standing by. 
        Contact him when you're outside, and he'll arrive within minutes to pick you up.
    </p>
    <p class="policy__notices">
        *Modifying or Cancelling a Reservation* To ensure any changes or cancellations are valid, 
        you must receive a text or email confirmation from HelloShuttle
    </p>
</body>
</html>