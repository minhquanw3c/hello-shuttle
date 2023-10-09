<html lang="en">
<head>
</head>
<body>
<?php
    $oneWay_hasRestStop = $bookingData->reservation->oneWayTrip->hasRestStop;
    $roundTrip_hasRestStop = $bookingData->reservation->roundTrip->hasRestStop;
?>

<p>Dear <?= implode(" ", array($bookingData->review->customer->lastName, $bookingData->review->customer->firstName))  ?>,</p>
<p>Your booking details for order: <?= $bookingRefNo ?></p>
<p>Trip type: <?= $bookingData->reservation->tripType ?></p>
<?php if(isset($bookingData->reservation->tripType)): ?>
    <p>Picking up</p>
    <ul>
        <li>Vehicle: <?= $bookingData->selectCar->oneWayTrip->vehicle->carName ?></li>
        <li>From: <?= $bookingData->reservation->oneWayTrip->origin->description ?></li>
        <li>Rest stop: <?= $oneWay_hasRestStop ? $bookingData->reservation->oneWayTrip->restStop->description : null ?></li>
        <li>To: <?= $bookingData->reservation->oneWayTrip->destination->description ?></li>
        <li>Miles: <?= $bookingData->review->routes->oneWayTrip->miles ?></li>
        <li>Pickup time: 
            <?= $bookingData->reservation->oneWayTrip->pickup->date ?> 
            <?= $bookingData->reservation->oneWayTrip->pickup->time ?>
        </li>
        <?php if(count($bookingData->chooseOptions->oneWayTrip->extras) > 0): ?>
            <li>Extras:</li>
            <ul>
                <?php foreach($bookingData->chooseOptions->oneWayTrip->extras as $option): ?>
                    <li>
                        <?= $option->configName ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <?php if(count($bookingData->chooseOptions->oneWayTrip->protection) > 0): ?>
            <li>Protection:</li>
            <ul>
                <?php foreach($bookingData->chooseOptions->oneWayTrip->protection as $option): ?>
                    <li>
                        <?= $option->configName ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <li>
            Total: $<?= $bookingData->review->prices->oneWayTrip ?>
        </li>
    </ul>
<?php endif ?>

<?php if($bookingData->reservation->tripType == 'round-trip'): ?>
    <p>Return</p>
    <ul>
        <li>Vehicle: <?= $bookingData->selectCar->roundTrip->vehicle->carName ?></li>
        <li>From: <?= $bookingData->reservation->roundTrip->origin->description ?></li>
        <li>Rest stop: <?= $roundTrip_hasRestStop ? $bookingData->reservation->roundTrip->restStop->description : null ?></li>
        <li>To: <?= $bookingData->reservation->roundTrip->destination->description ?></li>
        <li>Miles: <?= $bookingData->review->routes->roundTrip->miles ?></li>
        <li>Pickup time: 
            <?= $bookingData->reservation->roundTrip->pickup->date ?> 
            <?= $bookingData->reservation->roundTrip->pickup->time ?>
        </li>
        <?php if(count($bookingData->chooseOptions->roundTrip->extras) > 0): ?>
            <li>Extras:</li>
            <ul>
                <?php foreach($bookingData->chooseOptions->roundTrip->extras as $option): ?>
                    <li>
                        <?= $option->configName ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <?php if(count($bookingData->chooseOptions->roundTrip->protection) > 0): ?>
            <li>Protection:</li>
            <ul>
                <?php foreach($bookingData->chooseOptions->roundTrip->protection as $option): ?>
                    <li>
                        <?= $option->configName ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <li>
            Total: $<?= $bookingData->review->prices->roundTrip ?>
        </li>
    </ul>
<?php endif ?>

<?php
    $airlane = $bookingData->review->airline->brand ? $bookingData->review->airline->brand->text : 'N/A';
    $flightNumber = $bookingData->review->airline->flightNumber ? $bookingData->review->airline->flightNumber : 'N/A';
    $additionalNotes = $bookingData->review->additionalNotes ? $bookingData->review->additionalNotes : 'N/A';
?>

<p>Airline</p>
<ul>
    <li>Airline: <?= $airlane ?></li>
    <li>Flight number: <?= $flightNumber ?></li>
    <li>Additional notes: <?= $additionalNotes ?></li>
</ul>

<p>Total booking price: $<?= $bookingData->review->prices->total ?></p>
</body>
</html>