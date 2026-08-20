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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin Page
$route['admin'] = '/admin/dashboard/index';
$route['admin/dashboard2'] = '/admin/dashboard/dashboard_pelatihan';
$route['admin/login'] = '/admin/user/login';
$route['admin/logout'] = '/admin/user/logout';

// Kegiatan & Daftar Hadir
$route['daftar_hadir_(:any)/(:num)/(:num)'] = 'kegiatan/daftar_hadir/$1/$2/$3';
$route['admin/item/(:num)/(:any)'] = 'admin/kegiatan/item/$1/$2/';
$route['admin/data_dukung/(:num)'] = 'admin/kegiatan/data_dukung/$1/'; 
$route['kegiatan/registrasi_(:any)/(:num)'] = 'kegiatan/registrasi/$1/$2';
$route['download/sppd_(:any)/(:num)'] = 'download/sppd/$1/$2';
$route['download/sppd_(:any)/(:num)/(:any)'] = 'download/sppd/$1/$2/$3';

//master
$route['admin/komponen_kegiatan/'] = 'admin/master/komponen_kegiatan/index';
$route['master_komponen_kegiatan/create'] = 'master_komponen_kegiatan/create';
$route['master_komponen_kegiatan/edit/(:num)'] = 'master_komponen_kegiatan/edit/$1';
$route['master_komponen_kegiatan/store'] = 'master_komponen_kegiatan/store';
$route['master_komponen_kegiatan/update/(:num)'] = 'master_komponen_kegiatan/update/$1';
$route['master_komponen_kegiatan/delete/(:num)'] = 'master_komponen_kegiatan/delete/$1';

