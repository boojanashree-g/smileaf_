$(document).ready(function () {
    $('.filter-checkbox').on('change', function () {
        console.log('Filter checkbox changed');
        
        // Collect selected values
        let typeIds = [];
        let sizeIds = [];
        let availability = [];

        $('input[name="type_id[]"]:checked').each(function () {
            typeIds.push($(this).val()); 
        });

        $('input[name="size_id[]"]:checked').each(function () {
            sizeIds.push($(this).val());
        });

        $('input[name="availability[]"]:checked').each(function () {
            availability.push($(this).val());
        });

        // Debug: Check if the target element exists
        let targetElement = $('.ltn__product-tab-content-inner .ltn__product-grid-view .row');
        console.log('Target element found:', targetElement.length);
        console.log('Target element:', targetElement);

        // Try alternative selectors if the main one doesn't work
        if (targetElement.length === 0) {
            // Try broader selector
            targetElement = $('.ltn__product-grid-view .row');
            console.log('Alternative selector 1 found:', targetElement.length);
            
            if (targetElement.length === 0) {
                // Try even broader
                targetElement = $('#liton_product_grid .row');
                console.log('Alternative selector 2 found:', targetElement.length);
                
                if (targetElement.length === 0) {
                    // Try the most basic
                    targetElement = $('.row').first();
                    console.log('Basic selector found:', targetElement.length);
                }
            }
        }

        // Show loading indicator
        targetElement.html('<div class="col-12 text-center"><p>Loading products...</p></div>');

        // AJAX request
        $.ajax({
            url: base_Url+'/products',
            method: 'GET',
            data: {
                type_id: typeIds,
                size_id: sizeIds,
                availability: availability,
                ajax: '1'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX Success', response);
                console.log('Products count:', response.products ? response.products.length : 0);
                
                if (response.success && response.products && response.products.length > 0) {
                    let productsHtml = '';
                    
                    response.products.forEach(function(product) {
                        console.log('Processing product:', product.prod_name);
                        
                        productsHtml += `
                            <div class="col-xl-4 col-sm-6 col-6">
                                <div class="ltn__product-item ltn__product-item-3 text-center">
                                    <div class="product-img">
                                        <a href="<?= base_url() ?>${base_Url }${product.url || '#'}">
                                            <img src="${base_Url}${product.main_image || 'default-image.jpg'}" alt="${product.prod_name || 'Product'}">
                                        </a>
                                        <div class="product-badge">
                                            <ul>
                                                <li class="sale-badge">New</li>
                                            </ul>
                                        </div>
                                        <div class="product-hover-action">
                                            <ul>
                                                <li>
                                                    <a href="#" title="Quick View" data-bs-toggle="modal" data-bs-target="#quick_view_modal">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" title="Add to Cart" data-bs-toggle="modal" data-bs-target="#add_to_cart_modal">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" title="Wishlist" data-bs-toggle="modal" data-bs-target="#liton_wishlist_modal">
                                                        <i class="far fa-heart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h2 class="product-title">
                                            <a href="${product.url || '#'}">
                                                ${product.prod_name || 'Product Name'}
                                            </a>
                                        </h2>
                                        <div class="product-price">
                                            <span>₹${product.current_price || product.price || '300'}</span>
                                            ${product.original_price ? `<del>₹${product.original_price}</del>` : '<del>₹200</del>'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    console.log('Generated HTML length:', productsHtml.length);
                    console.log('First 200 chars of HTML:', productsHtml.substring(0, 200));
                    
                    targetElement.html(productsHtml);
                    
                    // Verify the content was updated
                    console.log('Content updated. New element count:', targetElement.children().length);
                    
                } else {
                    console.log('No products found or response failed');
                    targetElement.html('<div class="col-12"><p class="text-center">No products found.</p></div>');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                targetElement.html('<div class="col-12"><p class="text-center text-danger">Error fetching products.</p></div>');
            }
        });
    });    
});