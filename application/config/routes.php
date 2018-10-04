<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'posts';
$route['posts/create'] = 'posts/create';
$route['pages/create'] = 'pages/create';
$route['categories/create'] = 'categories/create';
$route['categories/posts/(:any)'] = 'categories/posts/$1';
$route['404_override'] = '';
//$route['pages'] = 'pages';
$route['translate_uri_dashes'] = FALSE;
