<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'posts';
$route['migrate'] = 'migrate';
$route['register'] = 'register';
$route['login'] = 'login';
$route['dashboard'] = 'dashboard';
$route['manage-authors'] = 'dashboard/users';
$route['404_override'] = '';
$route['create-post'] = 'posts/create';
$route['create-page'] = 'dashboard/pages/create';
$route['create-category'] = 'dashboard/categories/create';
$route['categories/posts/(:any)'] = 'categories/posts/$1';
$route['(:any)'] = 'posts/post/$1';
$route['translate_uri_dashes'] = FALSE;
