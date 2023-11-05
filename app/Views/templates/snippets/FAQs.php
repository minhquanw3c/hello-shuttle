<div id="<?= $accordianName ?>">
    <?php foreach($policies as $policyIndex => $policy): ?>
        <div class="card mt-3">
            <div class="card-header">
                <a class="card-link d-block collapsed" data-toggle="collapse" href="<?= '#' . $accordianName . '-item-' . $policyIndex ?>">
                    <?= $policy["heading"] ?>
                </a>
            </div>
            <div id="<?= $accordianName . '-item-' . $policyIndex ?>" class="collapse" data-parent="#<?= $accordianName ?>">
                <div class="card-body">
                    <?php if(count($policy["descriptions"])): ?>
                        <?php foreach($policy["descriptions"] as $description): ?>
                            <p><?= $description ?></p>
                        <?php endforeach ?>
                    <?php endif ?>
                    <?php if(count($policy["children"])): ?>
                        <ul>
                            <?php foreach($policy["children"] as $child): ?>
                                <li>
                                    <?= $child ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>