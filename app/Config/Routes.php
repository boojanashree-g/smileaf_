<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('product-details/(:any)', 'Home::productDetails/$1');
$routes->get('cart', 'Home::cart');
$routes->get('contact', 'Home::contact');
$routes->get('products/(:segment)/(:segment)', 'Home::products/$1/$2');
$routes->get('products', 'Home::products');
$routes->get('wishlist', 'Home::wishlist');
$routes->get('myaccount', 'Home::myaccount', ['filter' => 'checkLogin']);
$routes->get('signup', 'Home::signup', );
$routes->get('signin', 'Home::signin');
$routes->get('terms-and-conditions', 'Home::termsAndConditions');
$routes->get('privacy-policy', 'Home::privacyPolicy');
$routes->get('order-tracking', 'Home::orderTracking', ['filter' => 'checkLogin']);
$routes->post('getorder-status', 'Home::getOrderStatus', ['filter' => 'checkLogin']);

$routes->get('product-categories/(:segment)', 'Home::productCategories/$1');
// $routes->post('signup-otp', 'SignupController::signupOTP');
// $routes->post('check-signotp', 'SignupController::checkSignOTP');


// new
$routes->post('signin-otp', 'SigninController::signinOTP');
$routes->post('verify-otp', 'SigninController::verifyOTP');
$routes->post('resend-otp', 'SigninController::resendOTP');
$routes->get('logout', 'SigninController::logout');

// Myaccount 
$routes->post('insert-account', 'MyaccountController::insertAccount');
$routes->post('getdist-data', 'MyaccountController::getDist', ['filter' => 'AuthFilter']);
$routes->post('insert-address', 'MyaccountController::insertAddress', ['filter' => 'AuthFilter']);
$routes->get('get-address', 'MyaccountController::getAddress');
$routes->post('update-address', 'MyaccountController::updateAddress', ['filter' => 'AuthFilter']);
$routes->post('delete-address', 'MyaccountController::deleteAddress', ['filter' => 'AuthFilter']);
$routes->post('update-defaultaddress', 'MyaccountController::updateDefaultAddress', ['filter' => 'AuthFilter']);
$routes->post('update-cancel-reason', 'MyaccountController::updateCancelReason', ['filter' => 'AuthFilter']);

$routes->post('place-order', 'checkoutController::placeOrder', ['filter' => 'AuthFilter']);
$routes->get('checkout', 'checkoutController::checkout');
$routes->post('get-single-address', 'checkoutController::getSingleAddress');


// Checkout userdetails
$routes->post('save-userdetails', 'MyaccountController::insertUserDetails', ['filter' => 'AuthFilter']);
$routes->post('view-orderdetail', 'MyaccountController::viewOrderDetails', ['filter' => 'AuthFilter']);

// ProductList
$routes->post('quick-view-details', 'QuickViewController::quickViewDetails');
$routes->post('insert-cart', 'CartController::insertCart');
$routes->post('update-cart', 'CartController::updateCart');
$routes->post('delete-cart', 'CartController::deleteCart');

$routes->post('insert-buynow', 'CartController::insertBuynow');


// RazorpayController checkout controller
$routes->get('payment', 'RazorpayController::payment', ['filter' => 'PaymentAuth']);
$routes->post('payment-status', 'RazorpayController::paymentstatus');
$routes->get('payment-cancelled', 'RazorpayController::paymentcancel');
$routes->get('payment-failed', 'RazorpayController::paymentfail');
$routes->get('success', 'RazorpayController::Success');


// *************************** [Admin Routes] *************************************************************************

$routes->group('admin', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('/', 'AdminController::login');
    $routes->post('check-login', 'AdminController::checkLogin');
    $routes->get('dashboard', 'AdminController::dashboard', ['filter' => 'adminAuth']);
    $routes->get('logout', 'AdminController::logout');

});

$routes->group('admin/banner', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'BannerController::banner');
    $routes->post('insert-data', 'BannerController::insertData');
    $routes->post('get-data', 'BannerController::getData');
    $routes->post('delete-data', 'BannerController::deleteData');
    $routes->post('update-data', 'BannerController::updateData');
    $routes->post('update-status', 'BannerController::updateStatus');

});

$routes->group('admin/main-menu', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'MainmenuController::mainMenu');
    $routes->post('insert-data', 'MainmenuController::insertData');
    $routes->post('update-status', 'MainmenuController::updateStatus');
    $routes->post('update-data', 'MainmenuController::updateData');
    $routes->post('get-data', 'MainmenuController::getData');
    $routes->post('delete-data', 'MainmenuController::deleteData');

});

$routes->group('admin/sub-menu', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'SubmenuController::subMenu');
    $routes->post('insert-data', 'SubmenuController::insertData');
    $routes->post('get-data', 'SubmenuController::getData');
    $routes->post('update-data', 'SubmenuController::updateData');
    $routes->post('delete-data', 'SubmenuController::deleteData');
    $routes->post('update-status', 'SubmenuController::updateStatus');
});

$routes->group('admin/sub-category', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'SubCatController::subCategory');
    $routes->post('insert-data', 'SubCatController::insertData');
    $routes->post('get-data', 'SubCatController::getData');
    $routes->post('update-data', 'SubCatController::updateData');
    $routes->post('delete-data', 'SubCatController::deleteData');
    $routes->post('update-status', 'SubCatController::updateStatus');
});



// Filter Types
$routes->group('admin/filter-types', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'FilterTypeController::filterType');
    $routes->post('insert-data', 'FilterTypeController::insertData');
    $routes->post('get-data', 'FilterTypeController::getData');
    $routes->post('update-data', 'FilterTypeController::updateData');
    $routes->post('delete-data', 'FilterTypeController::deleteData');
    $routes->post('update-status', 'FilterTypeController::updateStatus');
});


//Filter Shapes
$routes->group('admin/filter-shapes', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'FilterShapeController::filterShape');
    $routes->post('insert-data', 'FilterShapeController::insertData');
    $routes->post('get-data', 'FilterShapeController::getData');
    $routes->post('update-data', 'FilterShapeController::updateData');
    $routes->post('delete-data', 'FilterShapeController::deleteData');
    $routes->post('update-status', 'FilterShapeController::updateStatus');
});

//Filter Sizes
$routes->group('admin/filter-size', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'FilterSizeController::filterSize');
    $routes->post('insert-data', 'FilterSizeController::insertData');
    $routes->post('get-data', 'FilterSizeController::getData');
    $routes->post('update-data', 'FilterSizeController::updateData');
    $routes->post('delete-data', 'FilterSizeController::deleteData');
    $routes->post('update-status', 'FilterSizeController::updateStatus');
});

$routes->group('admin/product-details', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'ProductController::ProductDetails');
    $routes->post('submenu', 'ProductController::getSubmenu');
    $routes->post('insert-data', 'ProductController::insertData');
    $routes->post('get-data', 'ProductController::getData');
    $routes->post('update-data', 'ProductController::updateData');
    $routes->post('delete-data', 'ProductController::deleteData');

});

$routes->group('admin/featured-products', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'ProductController::featuredProductDetails');
    $routes->post('getFeaturedProductDetails', 'ProductController::getFeaturedProductDetails');
    $routes->post('insert-data', 'ProductController::insertFeaturedData');
    $routes->post('update-data', 'ProductController::updateFeaturedData');
    $routes->post('delete-data', 'ProductController::deleteFeaturedData');

});



$routes->group('admin/customer-details', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'CustomerController::customerDetails');
    $routes->post('get-data', 'CustomerController::getData');
    $routes->post('insert-data', 'CustomerController::insertData');
    $routes->post('update-data', 'CustomerController::updateData');
    $routes->post('delete-data', 'CustomerController::deleteData');
});


$routes->group('admin/order-details', ['namespace' => 'App\Controllers\admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'OrderController::orderDetails');
    $routes->post('get-data', 'OrderController::getData');
    $routes->post('get-orderview', 'OrderController::getOrderView');
    $routes->post('update-trackingdetails', 'OrderController::updateTrackingDetails');
    $routes->post('get-trackingdetails', 'OrderController::getTrackingDetails');
    $routes->post('delete-data', 'OrderController::deleteData');
});