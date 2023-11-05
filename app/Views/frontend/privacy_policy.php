<?= $this->extend("templates/base_layout") ?>

<?= $this->section("page-custom-style") ?>
<style>
.ltn__404-area.ltn__404-area-1 p,
.ltn__404-area.ltn__404-area-1 li {
    color: #000;
}
</style>
<?= $this->endSection() ?>

<?= $this->section("main-content") ?>
<div class="ltn__404-area ltn__404-area-1 mb-120 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-404-inner text-center">
                    <h2 class="">Privacy &amp; Policy</h2>
                </div>
                
                <!-- Terms -->
                <?php if(count($terms) > 0): ?>
                    <ol class="list-style-upper-alpha">
                        <?php foreach($terms as $term): ?>
                            <li>
                                <strong><?= $term["heading"] ?></strong>
                                <?php if(count($term["children"])): ?>
                                    <ul>
                                        <?php foreach($term["children"] as $child): ?>
                                            <li>
                                                <?= $child ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ol>
                <?php endif ?>

                <hr class="border-secondary" />

                <!-- Polices -->
                <?php if(count($policies) > 0): ?>
                    <ol>
                        <?php foreach($policies as $policy): ?>
                            <li>
                                <strong><?= $policy["heading"] ?></strong>
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
                            </li>
                        <?php endforeach ?>
                    </ol>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>