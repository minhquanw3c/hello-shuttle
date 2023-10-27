<?php
    $pickup_fee = $feesChargesData->pickupFee->{$routeType};
    $admin_fee = $feesChargesData->adminFee->{$routeType};

    $extra_luggages = $feesChargesData->luggages->{$routeType}->extras;
    $extra_luggages_price = $feesChargesData->luggages->{$routeType}->prices;

    $extra_passengers = $feesChargesData->passengers->{$routeType}->extras;
    $extra_passengers_price = $feesChargesData->passengers->{$routeType}->prices;
?>

<tr>
    <td>
        <span class="font-weight-bold">Charge Description</span>
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
        Extra luggages
    </td>
    <td>
        <?= $extra_luggages ?>
    </td>
    <td>
        <?= $extra_luggages_price ?>
    </td>
</tr>
<tr>
    <td>
        Extra passengers
    </td>
    <td>
        <?= $extra_passengers ?>
    </td>
    <td>
        <?= $extra_passengers_price ?>
    </td>
</tr>
<tr>
    <td colspan="3">
        ------------
    </td>
</tr>
<tr>
    <td colspan="2">
        Total
    </td>
    <td>
        <?= $extra_luggages_price + $extra_passengers_price ?>
    </td>
</tr>

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
        Pick-Up Fee
    </td>
    <td>
        <?= $pickup_fee ?>
    </td>
</tr>
<tr>
    <td>
        Admin Fee
    </td>
    <td>
        <?= $admin_fee ?>
    </td>
</tr>
<tr>
    <td colspan="2">
        ------------
    </td>
</tr>
<tr>
    <td>
        Total
    </td>
    <td>
        <?= $admin_fee + $pickup_fee ?>
    </td>
</tr>