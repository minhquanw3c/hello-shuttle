<?php
    $extras_total = 0;
    $protection_total = 0;
?>

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
<!-- Extras -->
<?php if (count($optionsData->{$routeType}->extras) > 0): ?>
    <?php foreach($optionsData->{$routeType}->extras as $option): ?>
        <tr>
            <td>
                <?= $option->configName ?>
            </td>
            <td>
                <?= $option->quantity ?>
            </td>
            <td>
                <?php $extras_total += (floatVal($option->configValue) * $option->quantity) ?>
                <?= floatVal($option->configValue) * $option->quantity ?>
            </td>
        </tr>
    <?php endforeach ?>
<?php endif ?>

<!-- Protections -->
<?php if (count($optionsData->{$routeType}->protection) > 0): ?>
    <?php foreach($optionsData->{$routeType}->protection as $option): ?>
        <tr>
            <td>
                <?= $option->configName ?>
            </td>
            <td>
                <?= $option->quantity ?>
            </td>
            <td>
                <?php $protection_total += (floatVal($option->configValue) * $option->quantity) ?>
                <?= floatVal($option->configValue) * $option->quantity ?>
            </td>
        </tr>
    <?php endforeach ?>
<?php endif ?>
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
        <?= $extras_total + $protection_total ?>
    </td>
</tr>