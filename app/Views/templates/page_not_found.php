<?= $this->extend("templates/base_layout") ?>

<?= $this->section("main-content") ?>
    <!-- 404 area start -->
    <div class="ltn__404-area ltn__404-area-1 mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="error-404-inner text-center">
                        <h2 class="text-white">Page Not Found!</h2>
                        <p class="text-white">Oops! The page you are looking for does not exist. It might have been moved or deleted.</p>
                        <div class="btn-wrapper">
                            <a href="<?= base_url('/') ?>" class="btn btn-white btn-lg"><i class="fas fa-long-arrow-alt-left"></i> BACK TO HOME</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 area end -->
<?= $this->endSection() ?>