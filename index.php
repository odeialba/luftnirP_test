<?php

require_once 'vendor/autoload.php';

use Printful\Service\CacheService;
use Printful\Service\PrintfulService;

$printful = new PrintfulService(new CacheService());
$availableShippingOptions = $printful->availableShippingOptions("11025 Westlake Dr, Charlotte, North Carolina, 28273", [7679 => 2]);
$totalOptions = count($availableShippingOptions);

if ($totalOptions === 0): ?>
    <h1>There isn't any available shipping option</h1>
<?php else: ?>
    <h1>There <?= $totalOptions > 1 ? 'are' : 'is' ?> <?= $totalOptions ?> available shipping option<?= $totalOptions > 1 ? 's' : '' ?></h1>

    <table border="1">
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Price</th>
            <th>Currency</th>
            <th>Minimum Delivery Days</th>
            <th>Maximum Delivery Days</th>
        </tr>
        <?php foreach ($availableShippingOptions as $shippingOption): ?>
            <tr>
                <td><?= $shippingOption->getId() ?></td>
                <td><?= $shippingOption->getName() ?></td>
                <td><?= $shippingOption->getRate() ?></td>
                <td><?= $shippingOption->getCurrency() ?></td>
                <td><?= $shippingOption->getMinDeliveryDays() ?></td>
                <td><?= $shippingOption->getMaxDeliveryDays() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>