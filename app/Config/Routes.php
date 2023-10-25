<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\ErrorHandler::pageNotFound');

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/reservation', 'Home::reservationForm');
$routes->get('/confirmation', 'Home::confirmBookingPayment');
$routes->get('/cancel', 'Home::cancelBookingGateway');

$routes->post('api/car/list', 'Home::getAvailableCarsList');

$routes->post('api/booking/save', 'Home::saveBooking');
$routes->post('api/booking/cancel', 'Home::cancelBookingGateway');

$routes->get('api/checkout/create', 'Home::testStripePayment');
$routes->get('api/sms/send', 'Home::testClickSend');

$routes->get('api/configurations/list', 'Home::getConfigList');
$routes->post('api/coupons/validate', 'CouponController::validateCoupon');

$routes->get('policy', 'Home::getPrivacyAndPolicy');

$routes->post('api/user/get', 'UserController::getUserDataFromBookingForm');
$routes->post('api/email/validate', 'UserController::validateRegisterAccountEmail');

// test/update pdf receipt UI
$routes->get('test-pdf-receipt', 'Home::generateSampleBookingReceipt');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
