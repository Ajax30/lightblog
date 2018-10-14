<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'posts';
$route['create-post'] = 'posts/create';
$route['create-page'] = 'dashboard/pages/create';
$route['create-category'] = 'dashboard/categories/create';
$route['categories/posts/(:any)'] = 'categories/posts/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
