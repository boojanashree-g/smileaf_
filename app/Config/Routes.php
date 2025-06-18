<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('productDetails', 'Home::productDetails');
$routes->get('cart', 'Home::cart');
$routes->get('checkout', 'Home::checkout');
$routes->get('contact', 'Home::contact');
$routes->get('products', 'Home::products');
$routes->get('wishlist', 'Home::wishlist');
$routes->get('myaccount', 'Home::myaccount');
$routes->get('signup', 'Home::signup');
$routes->get('signin', 'Home::signin');
$routes->get('terms-and-conditions', 'Home::termsAndConditions');
$routes->get('privacy-policy', 'Home::privacyPolicy');
$routes->get('order-tracking', 'Home::orderTracking');
$routes->get('product-categories/(:segment)', 'Home::productCategories/$1');

$routes->post('signup-otp', 'SignupController::signupOTP');



// *************************** [Admin Routes] *************************************************************************

$routes->group('admin', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'AdminController::login');
    $routes->post('check-login', 'AdminController::checkLogin');
    $routes->get('dashboard', 'AdminController::dashboard', ['filter' => 'adminAuth']);
    $routes->get('logout', 'AdminController::logout');

});

$routes->group('admin/banner', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'BannerController::banner');
    $routes->post('insert-data', 'BannerController::insertData');
    $routes->post('get-data', 'BannerController::getData');
    $routes->post('delete-data', 'BannerController::deleteData');
    $routes->post('update-data', 'BannerController::updateData');
    $routes->post('update-status', 'BannerController::updateStatus');


});

$routes->group('admin/main-menu', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'MainmenuController::mainMenu');
    $routes->post('insert-data', 'MainmenuController::insertData');
    $routes->post('update-status', 'MainmenuController::updateStatus');
    $routes->post('update-data', 'MainmenuController::updateData');
    $routes->post('get-data', 'MainmenuController::getData');
    $routes->post('delete-data', 'MainmenuController::deleteData');

});

$routes->group('admin/sub-menu', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'SubmenuController::subMenu');
    $routes->post('insert-data', 'SubmenuController::insertData');
    $routes->post('get-data', 'SubmenuController::getData');
    $routes->post('update-data', 'SubmenuController::updateData');
    $routes->post('delete-data', 'SubmenuController::deleteData');
    $routes->post('update-status', 'SubmenuController::updateStatus');
});

$routes->group('admin/sub-category', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'SubCatController::subCategory');
    $routes->post('insert-data', 'SubCatController::insertData');
    $routes->post('get-data', 'SubCatController::getData');
    $routes->post('update-data', 'SubCatController::updateData');
    $routes->post('delete-data', 'SubCatController::deleteData');
    $routes->post('update-status', 'SubCatController::updateStatus');
});



// Filter Types
$routes->group('admin/filter-types', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'FilterTypeController::filterType');
    $routes->post('insert-data', 'FilterTypeController::insertData');
    $routes->post('get-data', 'FilterTypeController::getData');
    $routes->post('update-data', 'FilterTypeController::updateData');
    $routes->post('delete-data', 'FilterTypeController::deleteData');
    $routes->post('update-status', 'FilterTypeController::updateStatus');
});


//Filter Shapes
$routes->group('admin/filter-shapes', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'FilterShapeController::filterShape');
    $routes->post('insert-data', 'FilterShapeController::insertData');
    $routes->post('get-data', 'FilterShapeController::getData');
    $routes->post('update-data', 'FilterShapeController::updateData');
    $routes->post('delete-data', 'FilterShapeController::deleteData');
    $routes->post('update-status', 'FilterShapeController::updateStatus');
});

//Filter Sizes
$routes->group('admin/filter-size', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'FilterSizeController::filterSize');
    $routes->post('insert-data', 'FilterSizeController::insertData');
    $routes->post('get-data', 'FilterSizeController::getData');
    $routes->post('update-data', 'FilterSizeController::updateData');
    $routes->post('delete-data', 'FilterSizeController::deleteData');
    $routes->post('update-status', 'FilterSizeController::updateStatus');
});

$routes->group('admin/product-details', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'ProductController::ProductDetails');
    $routes->post('submenu', 'ProductController::getSubmenu');
    $routes->post('insert-data', 'ProductController::insertData');
    $routes->post('get-data', 'ProductController::getData');
    $routes->post('update-data', 'ProductController::updateData');
    $routes->post('delete-data', 'ProductController::deleteData');

});

