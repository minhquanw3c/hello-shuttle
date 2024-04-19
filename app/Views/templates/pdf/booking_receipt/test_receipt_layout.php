<html lang="en">
<head>
<style>
    .font-weight-bold {
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }
</style>
</head>
<body>

<?php
    $is_round_trip = $bookingData->reservation->tripType === 'round-trip';
    $customer_name = $bookingData->review->customer->lastName . ' ' . $bookingData->review->customer->firstName;
    $customer_phone = $bookingData->review->customer->contact->mobileNumber;
    $trip_notes = $bookingData->review->additionalNotes;
    $airline = $bookingData->review->airline->brand->text;
    $flight_number = $bookingData->review->airline->flightNumber;
    $total_trips_prices = $bookingData->review->prices->total;
?>

<table>
    <tbody>
        <!-- Header logo -->
        <tr>
            <td colspan="3" style="background-color: #071c1f; text-align: center;">
                <img height="70px" src="<?= base_url('/') . '/static/images/logo/hello-shuttle-gold-hand-white-text.png' ?>" alt="logo" />
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <!-- Company contact -->
        <tr>
            <td colspan="3">
                <span>Tel: (000) 000-0000</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span>Email: info@testemail.com</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span>Address: Lorem ipsum</span>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td colspan="3">
                <span class="font-weight-bold">Reservation #: <?= $bookingRefNo ?></span>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <!-- Customer info -->
        <tr>
            <td>
                <span class="font-weight-bold">Bill To:</span>
                <br/>&nbsp;
                <?= $customer_name ?>
            </td>
            <td>
                <span class="font-weight-bold">Primary Passengers:</span>
                <br/>&nbsp;
                <?= $customer_name ?>
                <br/>&nbsp;
                Phone: <?= $customer_phone ?>
            </td>
            <td>
                <span class="font-weight-bold">Booked On:</span>
                <br/>&nbsp;
                <?= $bookingData->bookedAt ?>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <!-- Payment info -->
        <tr>
            <td>
                <span class="font-weight-bold">Payment Type</span>
                <br/>&nbsp;
                Stripe
            </td>
            <td>
                <span class="font-weight-bold">Payment Status</span>
                <br/>&nbsp;
                <?= $bookingData->paymentStatus ?>
            </td>
            <td>
                <span class="font-weight-bold">Total Trip(s) Amount</span>
                <br/>&nbsp;
                $<?= $total_trips_prices ?>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>
        <tr><td colspan="3"><hr></td></tr>

        <?= view('templates/pdf/booking_receipt/route_information', ['routeData' => $bookingData, 'routeType' => 'oneWayTrip']) ?>

        <tr><td colspan="3"><br/></td></tr>

        <!-- Chosen options -->
        <?= view('templates/pdf/booking_receipt/chosen_options', ['optionsData' => $bookingData->chooseOptions, 'routeType' => 'oneWayTrip']) ?>

        <tr><td colspan="3"><br/></td></tr>

        <!-- Charges & Fees -->
        <?= view('templates/pdf/booking_receipt/fees_charges', ['feesChargesData' => $bookingData->review->prices, 'routeType' => 'oneWayTrip']) ?>
        <tr><td colspan="3"><br/></td></tr>

        <?php if ($is_round_trip): ?>
            <tr><td colspan="3"><hr></td></tr>

            <?= view('templates/pdf/booking_receipt/route_information', ['routeData' => $bookingData, 'routeType' => 'roundTrip']) ?>

            <tr><td colspan="3"><br/></td></tr>

            <!-- Chosen options -->
            <?= view('templates/pdf/booking_receipt/chosen_options', ['optionsData' => $bookingData->chooseOptions, 'routeType' => 'roundTrip']) ?>

            <tr><td colspan="3"><br/></td></tr>

            <!-- Charges & Fees -->
            <?= view('templates/pdf/booking_receipt/fees_charges', ['feesChargesData' => $bookingData->review->prices, 'routeType' => 'roundTrip']) ?>
        <?php endif ?>

        <tr><td colspan="3"><br/></td></tr>
        <tr><td colspan="3"><hr></td></tr>

        <!-- Notes & Flight -->
        <tr>
            <td>
                <span class="font-weight-bold">Notes/Comments</span>
            </td>
            <td>
                <span class="font-weight-bold">Fly INFO</span>
            </td>
        </tr>
        <tr>
            <td>
                Trip Notes:
                <br/>&nbsp;
                <?= $trip_notes ?>
            </td>
            <td>
                EVA air:
                <br/>&nbsp;
                
            </td>
        </tr>
        <tr>
            <td>
                Airline:
                <br/>&nbsp;
                <?= $airline ?>
            </td>
            <td>
                Fly number:
                <br/>&nbsp;
                <?= $flight_number ?>
            </td>
        </tr>

        <tr><td colspan="3"><br></td></tr>
        <tr><td colspan="3"><hr></td></tr>

        <!-- Policy -->
        <tr>
            <td colspan="3">
                <span class="font-weight-bold">Gratuity - (Normal gratuity amount is 20%)</span>
                <br>
                Fares listed do not include gratuity. If you'd like to show your appreciation to your driver, your gesture is greatly welcomed. 
                You can provide a gratuity in Zelle, Venmo or Cash at the end of your trip or request your preferred dollar amount or percentage 
                to be added to your reservation. We'll then send you an updated receipt via email.
            </td>
        </tr>

        <tr><td colspan="3"><br></td></tr>

        <tr>
            <td colspan="3">
                <span class="font-weight-bold">Where to Find Your Driver at the Airport</span>
                <br>
                Your driver will be waiting for you right in front of your terminal. Please do not proceed to the Uber/Lyft/Taxi transportation 
                lot outside the airport. Your driver will reach out to you via text and calls prior to your scheduled pickup time. 
                You should be ready at the curb in front of your terminal, and your driver will be standing by. Contact him when you're outside, 
                and he'll arrive within minutes to pick you up.
            </td>
        </tr>

        <tr><td colspan="3"><br></td></tr>

        <tr>
            <td colspan="3">
                <span class="font-weight-bold">Modifying or Cancelling a Reservation</span>
                <br>
                To ensure any changes or cancellations are valid, you must receive a text or email confirmation from HelloShuttle
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>