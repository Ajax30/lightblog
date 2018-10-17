<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'posts';
$route['post/(:any)'] = 'posts/post/$1';
$route['create-post'] = 'posts/create';
$route['create-page'] = 'dashboard/pages/create';
$route['create-category'] = 'dashboard/categories/create';
$route['categories/posts/(:any)'] = 'categories/posts/$1';
$route['manage-authors'] = 'dashboard/users';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
