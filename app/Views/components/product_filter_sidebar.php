<aside class="sidebar ltn__shop-sidebar">
    <!-- Availability -->
    <div class="widget ltn__menu-widget">
        <h4 class="ltn__widget-title ltn__widget-title-border">Product Availability</h4>
        <ul>
            <li><label><input type="checkbox" class="filter-checkbox" name="availability[]" value="1"> Available</label></li>
            <li><label><input type="checkbox" class="filter-checkbox" name="availability[]" value="0"> Out of Stock</label></li>
        </ul>
    </div>

    <!-- Product Types -->
    <div class="widget ltn__menu-widget">
        <h4 class="ltn__widget-title ltn__widget-title-border">Product Types</h4>
        <ul>
            <?php if (!empty($productTypes)): ?>
                <?php foreach ($productTypes as $type): ?>
                    <li><label><input type="checkbox" class="filter-checkbox" name="type_id[]" value="<?= esc($type->type_id) ?>"> <?= esc($type->type_name) ?></label></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No product types found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Product Shape -->
    <div class="widget ltn__menu-widget">
        <h4 class="ltn__widget-title ltn__widget-title-border">Product Shape</h4>
        <ul>
            <?php if (!empty($productShape)): ?>
                <?php foreach ($productShape as $shape): ?>
                    <li><label><input type="checkbox" class="filter-checkbox" name="shape_id[]" value="<?= esc($shape->shape_id) ?>"> <?= esc($shape->shape_name) ?></label></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No product types found.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Product Size -->
    <div class="widget ltn__menu-widget">
        <h4 class="ltn__widget-title ltn__widget-title-border">Product Size</h4>
        <ul>
            <?php if (!empty($productsize)): ?>
                <?php foreach ($productsize as $size): ?>
                    <li><label><input type="checkbox" class="filter-checkbox" name="size_id[]" value="<?= esc($size->size_id) ?>"> <?= esc($size->size_name) ?></label></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No product types found.</li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
