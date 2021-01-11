<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'PostController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['oos'] = 'PostController';

$route['items'] = 'PostController/items';
$route['items/checkout'] = 'PostController/checkout';
$route['uncategorized'] = 'PostController/items';
$route['items/(:any)'] = 'PostController/items/$1';
$route['category'] = 'PostController/category';
$route['track_order'] = 'PostController/trackOrder';
$route['createsession'] = 'PostController/createSession';

//$route[URL STRING] = class name
$route['test'] = 'PostController/test';
// createsession

$route['add_cart'] = 'PostController/add_cart';
$route['check_promo'] = 'PostController/check_promo';
$route['update_Bag_Item'] = 'PostController/updateBagItemQty';
$route['post-order'] = 'PostController/postOrderPage';
$route['items/remove/(:any)'] = 'PostController/item_remove/$1';