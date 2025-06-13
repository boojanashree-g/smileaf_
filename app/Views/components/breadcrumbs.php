<!-- BREADCRUMB AREA START -->
<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image plr--9---"
    data-bg="<?= esc($banner_image) ?>" style="">
    <div class="container inner_banner_container" style="height:335px; position:relative;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-center">
                    <div class="section-title-area ltn__section-title-2">
                        <h1 class="section-title"><?= esc($page_title) ?></h1>
                        <div class="ltn__breadcrumb-list">
                            <ul style="display: flex ;justify-content: center;">
                                <?php foreach ($breadcrumb_items as $item): ?>
                                    <li>
                                        <?php if (isset($item['url'])): ?>
                                            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
                                        <?php else: ?>
                                            <?= esc($item['label']) ?>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Decorative Images -->
                    <img src="<?= base_url('public/assets/img/banner/big_leaf.png') ?>" class="image_inner image_inner_banner" style="position:absolute; right: 29%; width: 8%; opacity: 0.3;">
                    <img src="<?= base_url('public/assets/img/banner/big_leaf.png') ?>" class="image_inner image_inner_banner" style="position: absolute; right: 84%; width: 3%; top: 69%; filter: drop-shadow(-9px 11px 6px black);">
                    <img src="<?= base_url('public/assets/img/banner/big_leaf.png') ?>" class="image_inner image_inner_banner" style="position: absolute; right: 30%; width: 4%; opacity: 0.3; top: 55%;">
                    <img src="<?= base_url('public/assets/img/banner/big_leaf.png') ?>" class="image_inner image_inner_banner" style="position: absolute; right: 69%; width: 9%; top: 50%; overflow: hidden; filter: drop-shadow(-16px 27px 12px black);">
                    <img src="<?= base_url('public/assets/img/banner/big_leaf.png') ?>" class="image_inner image_inner_banner" style="position: absolute; right: 80%; width: 5%; opacity: 1; top: 45%; filter: drop-shadow(-10px 17px 10px black);">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB AREA END -->
