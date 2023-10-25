<?php
    $hasRestStop = $routeData->reservation->{$routeType}->hasRestStop;
    $emptyText = 'Unavailable';
?>

<tr>
    <td colspan="2">
        <span class="font-weight-bold">Routing Information</span>
        <br/>&nbsp;
        Vehicle: <?= $routeData->selectCar->{$routeType}->vehicle->carName ?>
        <br/>&nbsp;
        Driver: Hello Shuttle Driver(s)
        <br/>&nbsp;
        From: <?= $routeData->reservation->{$routeType}->origin->description ?>
        <br/>&nbsp;
        To: <?= $routeData->reservation->{$routeType}->destination->description ?>
        <br/>&nbsp;
        Rest Stop: <?= $hasRestStop ? $routeData->reservation->{$routeType}->restStop->description : $emptyText ?>
        <br/>&nbsp;
        Miles: <?= $routeData->review->routes->{$routeType}->miles ?>
    </td>
    <td>
        <span class="font-weight-bold">Pick-Up Date</span>
        <br/>&nbsp;
        <?= $routeData->reservation->{$routeType}->pickup->date ?>
        <br/>
        <br/>&nbsp;
        <span class="font-weight-bold">Pick-Up Time</span>
        <br/>&nbsp;
        <?= $routeData->reservation->{$routeType}->pickup->time ?>
    </td>
</tr>