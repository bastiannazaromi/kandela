<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] 										= 'login';
$route['404_override'] 												= '';
$route['translate_uri_dashes'] 										= FALSE;

$route['logout']													= 'login/logout';

$route['admin']														= 'admin';
$route['admin/dashboard']											= 'admin';
$route['admin/profile']												= 'admin';
$route['admin/updateFoto']											= 'admin';
$route['admin/updatePass']											= 'admin';

$route['admin/list_admin']											= 'admin/list_admin';
$route['admin/list_admin/(:any)']									= 'admin/list_admin';
$route['admin/list_admin/(:any)/(:any)']							= 'admin/list_admin';
$route['admin/list_admin/(:any)/(:any)/(:any)']						= 'admin/list_admin';

$route['admin/list_siswa']											= 'admin/list_siswa';
$route['admin/list_siswa/(:any)']									= 'admin/list_siswa';
$route['admin/list_siswa/(:any)/(:any)']							= 'admin/list_siswa';
$route['admin/list_siswa/(:any)/(:any)/(:any)']						= 'admin/list_siswa';

$route['admin/list_buku']											= 'admin/list_buku';
$route['admin/list_buku/(:any)']									= 'admin/list_buku';
$route['admin/list_buku/(:any)/(:any)']								= 'admin/list_buku';
$route['admin/list_buku/(:any)/(:any)/(:any)']						= 'admin/list_buku';

$route['admin/peminjaman']											= 'admin/peminjaman';
$route['admin/peminjaman/(:any)']									= 'admin/peminjaman';
$route['admin/peminjaman/(:any)/(:any)']							= 'admin/peminjaman';
$route['admin/peminjaman/(:any)/(:any)/(:any)']						= 'admin/peminjaman';

$route['admin/pengembalian']										= 'admin/pengembalian';
$route['admin/pengembalian/(:any)']									= 'admin/pengembalian';
$route['admin/pengembalian/(:any)/(:any)']							= 'admin/pengembalian';
$route['admin/pengembalian/(:any)/(:any)/(:any)']					= 'admin/pengembalian';

// siswa
$route['siswa']														= 'siswa';
$route['siswa/dashboard']											= 'siswa';
$route['siswa/profile']												= 'siswa';
$route['siswa/updateFoto']											= 'siswa';
$route['siswa/updatePass']											= 'siswa';
$route['siswa/peminjaman']											= 'siswa';
$route['siswa/pengembalian']										= 'siswa';
