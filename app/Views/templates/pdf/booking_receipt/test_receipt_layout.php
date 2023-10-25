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

<table>
    <tbody>
        <tr>
            <td colspan="3" style="background-color: #071c1f; text-align: center;">
                <img height="70px" src="<?= base_url('/') . '/static/images/logo/hello-shuttle-gold-03.png' ?>" alt="logo" />
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td colspan="3">
                <span>Tel: (949) 800-5678</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span>Email: info@helloshuttle.com</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span>Address: 10700 Flower Ave, Stanton, CA 90680, USA</span>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td colspan="3">
                <span class="font-weight-bold">Reservation #: <?= $bookingRefNo ?></span>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td>
                <span class="font-weight-bold">Bill To:</span>
                <br/>&nbsp;
                Tai Thai
            </td>
            <td>
                <span class="font-weight-bold">Primary Passengers:</span>
                <br/>&nbsp;
                Tai Thai
                <br/>&nbsp;
                Phone #(714)...
            </td>
            <td>
                <span class="font-weight-bold">Booked On:</span>
                <br/>&nbsp;
                <?= $bookingData->bookedAt ?>
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td>
                <span class="font-weight-bold">Payment Type</span>
                <br/>&nbsp;
                Stripe
            </td>
            <td>
                <span class="font-weight-bold">Payment Status</span>
                <br/>&nbsp;
                PAID
            </td>
            <td>

            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

        <?= view('templates/pdf/booking_receipt/route_information', ['routeData' => $bookingData, 'routeType' => 'oneWayTrip']) ?>

        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td>
                <span class="font-weight-bold">Option Description</span>
            </td>
            <td>
                <span class="font-weight-bold">Quantity</span>
            </td>
            <td>
                <span class="font-weight-bold">Amount ($)</span>
            </td>
        </tr>
        <tr>
            <td>
                Pet Included
            </td>
            <td>
                1
            </td>
            <td>
                177.68
            </td>
        </tr>
        <tr>
            <td>
                Pick-Up Fee
            </td>
            <td>
                3
            </td>
            <td>
                10.00
            </td>
        </tr>
        <tr>
            <td>
                Admin Fee
            </td>
            <td>
                2
            </td>
            <td>
                76.33
            </td>
        </tr>
        <tr>
            <td colspan="3">
                ------------
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Options Total
            </td>
            <td>
                316.81
            </td>
        </tr>

        <!-- Charges and fees -->
        <tr><td colspan="3"><br/></td></tr>

        <tr>
            <td>
                <span class="font-weight-bold">Fees Description</span>
            </td>
            <td>
                <span class="font-weight-bold">Amount ($)</span>
            </td>
        </tr>
        <tr>
            <td>
                Base Fare
            </td>
            <td>
                177.68
            </td>
        </tr>
        <tr>
            <td>
                Pick-Up Fee
            </td>
            <td>
                10.00
            </td>
        </tr>
        <tr>
            <td>
                Admin Fee
            </td>
            <td>
                76.33
            </td>
        </tr>
        <tr>
            <td colspan="2">
                ------------
            </td>
        </tr>
        <tr>
            <td>
                Trip Total
            </td>
            <td>
                316.81
            </td>
        </tr>

        <tr><td colspan="3"><br/></td></tr>

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
                test notes lorem ipsum test notes lorem ipsum test notes
            </td>
            <td>
                EVA air:
                <br/>&nbsp;
                test notes lorem ipsum test notes lorem ipsum test notes
            </td>
        </tr>
        <tr>
            <td>
                Pax Notes:
                <br/>&nbsp;
                test notes lorem ipsum test notes lorem ipsum test notes
            </td>
            <td>
                Fly number:
                <br/>&nbsp;
                test notes lorem ipsum test notes lorem ipsum test notes
            </td>
        </tr>

        <tr><td colspan="3"><br></td></tr>

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