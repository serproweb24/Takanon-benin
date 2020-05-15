<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'spw';

//Clients
$route['clients'] = 'clients/clients';
$route['clients/(:any)'] = 'clients/$1';
$route['clients/(:any)/([0-9]+)'] = 'clients/$1';
$route['clients/(:any)/([0-9]+)/([0-9]+)'] = 'clients/$1';
$route['clients/(:any)/([0-9]+)/([0-9]+)/([0-9]+)'] = 'clients/$1';
$route['clients/(:any)/(:any)'] = 'clients/$1/$2';


//Admin
$route['admin'] = 'admin/admin';
$route['admin/(:any)'] = 'admin/$1';
$route['admin/(:any)/([0-9]+)'] = 'admin/$1';
$route['admin/(:any)/([0-9]+)/([0-9]+)'] = 'admin/$1';
$route['admin/(:any)/([0-9]+)/([0-9]+)/([0-9]+)'] = 'admin/$1';
$route['admin/(:any)/(:any)'] = 'admin/$1/$2';


//Users
$route['users'] = 'users/users';
$route['users/(:any)'] = 'users/$1';
$route['users/(:any)/([0-9]+)'] = 'users/$1';
$route['users/(:any)/([0-9]+)/([0-9]+)'] = 'users/$1';
$route['users/(:any)/([0-9]+)/([0-9]+)/([0-9]+)'] = 'users/$1';
$route['users/(:any)/(:any)'] = 'users/$1/$2';




$route['logout'] = 'spw/logout';
$route['home'] = 'spw/home';
$route['(:any)'] = '$1';
$route['(:any)/([0-9]+)'] = '$1';


$route['(:any)/(:any)'] = '$1/$2';
$route['(:any)/(:any)/(:any)'] = '$1/$2/$3';
$route['(:any)/(:any)/([0-9]+)'] = '$1/$2/$3';
$route['(:any)/(:any)/([0-9]+)/([0-9]+)'] = '$1/$2/$3/$4';




$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
