<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = "project/index";
$route['home'] = "project/index";
$route['addItem'] = "project/addItem";
$route['ajax_list'] = "project/ajax_list";
$route['DeleteProduct/(:num)'] = "project/DeleteProduct/$1";
$route['UpdateProduct/(:num)'] = "project/UpdateProduct/$1";
$route['GetProduct/(:num)'] = "project/GetProduct/$1";

?>