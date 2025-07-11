<?= $this->extend("templates/base_layout") ?>

<?= $this->section("main-content") ?>
    <!-- 404 area start -->
    <div class="ltn__404-area ltn__404-area-1 mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="error-404-inner text-center">
                        <h2 class="text-white">Order completed</h2>
                        <p class="text-white">Thank you for choosing us! Please check your email for more details.</p>
                        <div class="btn-wrapper">
                            <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg mr-2"><i class="fas fa-long-arrow-alt-left"></i> BOOK MORE</a>
                            <a href="<?= $dashboardUrl ?>" class="btn btn-white btn-lg">MY DASHBOARD <i class="fas fa-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 area end -->
<?= $this->endSection() ?>

