$(document).ready(function () {
    $('.filter-checkbox').on('change', function () {
        console.log('Filter checkbox changed');
        
        // Collect selected values
        let typeIds = [];
        let sizeIds = [];
        let availability = [];
        let shapeIds = [];

        $('input[name="type_id[]"]:checked').each(function () {
            typeIds.push($(this).val()); 
        });

        $('input[name="size_id[]"]:checked').each(function () {
            sizeIds.push($(this).val());
        });

        $('input[name="availability[]"]:checked').each(function () {
            availability.push($(this).val());
        });
        
        $('input[name="shape_id[]"]:checked').each(function () {
            shapeIds.push($(this).val());
        });

        // Get target elements for both views
        let gridTargetElement = getTargetElement('grid');
        let listTargetElement = getTargetElement('list');
        
        console.log('Grid target element found:', gridTargetElement.length);
        console.log('List target element found:', listTargetElement.length);

        // Show loading indicator in both views
        showLoadingIndicator(gridTargetElement, listTargetElement);

        // AJAX request
        $.ajax({
            url:  window.location.href,
            method: 'GET',
            data: {
                type_id: typeIds,
                size_id: sizeIds,
                availability: availability,
                shape_id: shapeIds,
                ajax: '1'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX Success', response.products);
                console.log('Products count:', response.products ? response.products.length : 0);
                
                if (response.success && response.products && response.products.length > 0) {
                    // Generate HTML for both views
                    let gridHtml = generateGridHtml(response.products);
                    let listHtml = generateListHtml(response.products);
                    
                    // Update both views
                    gridTargetElement.html(gridHtml);
                    listTargetElement.html(listHtml);
                    
                    console.log('Content updated for both views');
                    
                } else {
                    console.log('No products found or response failed');
                    showNoProductsMessage(gridTargetElement, listTargetElement);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                showErrorMessage(gridTargetElement, listTargetElement);
            }
        });
    });

    // Function to get target element with fallback selectors
    function getTargetElement(viewType) {
        let selectors = [];
        
        if (viewType === 'grid') {
            selectors = [
                '.ltn__product-tab-content-inner .ltn__product-grid-view .row',
                '.ltn__product-grid-view .row',
                '#liton_product_grid .row',
                '#product-grid-container'
            ];
        } else if (viewType === 'list') {
            selectors = [
                '.ltn__product-tab-content-inner .ltn__product-list-view .row',
                '.ltn__product-list-view .row',
                '#liton_product_list .row',
                '#product-list-container'
            ];
        }
        
        for (let selector of selectors) {
            let element = $(selector);
            if (element.length > 0) {
                console.log(`Found ${viewType} element with selector: ${selector}`);
                return element;
            }
        }
        
        // Last resort - create the container if it doesn't exist
        if (viewType === 'grid') {
            $('#liton_product_grid').append('<div class="row" id="product-grid-container"></div>');
            return $('#product-grid-container');
        } else {
            $('#liton_product_list').append('<div class="row" id="product-list-container"></div>');
            return $('#product-list-container');
        }
    }

    // Function to show loading indicator
    function showLoadingIndicator(gridElement, listElement) {
        const loadingHtml = '<div class="col-12 text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading products...</p></div>';
        gridElement.html(loadingHtml);
        listElement.html(loadingHtml);
    }

    // Function to generate grid view HTML
    function generateGridHtml(products) {
        let html = '';
        
        products.forEach(function(product) {
            html += `
                <div class="col-xl-4 col-sm-6 col-6 product-item" 
                     data-name="${(product.prod_name || '').toLowerCase()}"
                     data-price="${product.current_price || product.price || product.mrp || '0'}"
                     data-category="${(product.category || '').toLowerCase()}"
                     data-stock="${product.stock_status || '1'}">
                    <div class="ltn__product-item ltn__product-item-3 text-center">
                        <div class="product-img">
                            <a href="${base_Url}${product.url || '#'}">
                                <img src="${base_Url}${product.main_image || 'default-image.jpg'}" alt="${product.prod_name || 'Product'}">
                            </a>
                            ${product.stock_status == 0 ? 
                                `<div class="product-badge">
                                    <ul><li class="sale-badge">Out of Stock</li></ul>
                                </div>` : 
                                (product.badge ? 
                                    `<div class="product-badge">
                                        <ul><li class="sale-badge">${product.badge}</li></ul>
                                    </div>` : 
                                    `<div class="product-badge">
                                        <ul><li class="sale-badge">New</li></ul>
                                    </div>`
                                )
                            }
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
                                <a href="${base_Url}${product.url || '#'}">
                                    ${product.prod_name || 'Product Name'}
                                </a>
                            </h2>
                            <div class="product-price">
                                <span>₹${product.current_price || product.price || product.mrp || '0'}</span>
                                ${(product.original_price || product.offer_price) && 
                                  (product.original_price || product.offer_price) !== (product.current_price || product.price || product.mrp) ? 
                                    `<del>₹${product.original_price || product.offer_price}</del>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        return html;
    }

    // Function to generate list view HTML
    function generateListHtml(products) {
        let html = '';
        
        products.forEach(function(product) {
            html += `
                <div class="col-lg-12 product-item" 
                     data-name="${(product.prod_name || '').toLowerCase()}"
                     data-price="${product.current_price || product.price || product.mrp || '0'}"
                     data-category="${(product.category || '').toLowerCase()}"
                     data-stock="${product.stock_status || '1'}">
                    <div class="ltn__product-item ltn__product-item-3">
                        <div class="product-img">
                            <a href="${base_Url}${product.url || '#'}">
                                <img src="${base_Url}${product.main_image || 'default-image.jpg'}" alt="${product.prod_name || 'Product'}">
                            </a>
                            ${product.stock_status == 0 ? 
                                `<div class="product-badge">
                                    <ul><li class="sale-badge">Out of Stock</li></ul>
                                </div>` : 
                                (product.badge ? 
                                    `<div class="product-badge">
                                        <ul><li class="sale-badge">${product.badge}</li></ul>
                                    </div>` : ''
                                )
                            }
                        </div>
                        <div class="product-info">
                            <h2 class="product-title">
                                <a href="${base_Url}${product.url || '#'}">
                                    ${product.prod_name || 'Product Name'}
                                </a>
                            </h2>
                            <div class="product-price">
                                <span>₹${product.current_price || product.price || product.mrp || '0'}</span>
                                ${(product.original_price || product.offer_price) && 
                                  (product.original_price || product.offer_price) !== (product.current_price || product.price || product.mrp) ? 
                                    `<del>₹${product.original_price || product.offer_price}</del>` : ''}
                            </div>
                            <div class="product-brief">
                                <p>${product.description || product.prod_description || 'Premium quality product available at best prices.'}</p>
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
                    </div>
                </div>
            `;
        });
        
        return html;
    }

    // Function to show no products message
    function showNoProductsMessage(gridElement, listElement) {
        const noProductsHtml = '<div class="col-12"><p class="text-center">No products found matching your criteria.</p></div>';
        gridElement.html(noProductsHtml);
        listElement.html(noProductsHtml);
    }

    // Function to show error message
    function showErrorMessage(gridElement, listElement) {
        const errorHtml = '<div class="col-12"><p class="text-center text-danger">Error fetching products. Please try again.</p></div>';
        gridElement.html(errorHtml);
        listElement.html(errorHtml);
    }

    // Optional: Add view switching functionality
    $('.view-toggle').on('click', function() {
        const viewType = $(this).data('view');
        if (viewType === 'grid') {
            $('#liton_product_grid').addClass('active show');
            $('#liton_product_list').removeClass('active show');
        } else if (viewType === 'list') {
            $('#liton_product_list').addClass('active show');
            $('#liton_product_grid').removeClass('active show');
        }
    });
});