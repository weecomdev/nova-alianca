<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'err/err_404';

$route['noticias'] = "noticias/index";
$route['noticias/detalhes/(:any)'] = "noticias/detalhes/$1";
$route['noticias/get_detalhes/(:any)'] = "noticias/get_detalhes/$1";
$route['noticias/get/(:num)'] = "noticias/get/$1/$2/$3";
$route['dicas'] = "dicas/index";
$route['dicas/detalhes/(:any)'] = "dicas/detalhes/$1";
$route['dicas/get_detalhes/(:any)'] = "dicas/get_detalhes/$1";
$route['dicas/get/(:num)'] = "dicas/get/$1/$2/$3";
$route['premiacoes'] = "premiacoes/index";
$route['premiacoes/detalhes/(:any)'] = "premiacoes/detalhes/$1";
$route['premiacoes/get_detalhes/(:any)'] = "premiacoes/get_detalhes/$1";
$route['premiacoes/get/(:num)'] = "premiacoes/get/$1/$2/$3";
$route['onde_comprar'] = "onde_comprar/index";
$route['onde_comprar/detalhes/(:any)'] = "onde_comprar/detalhes/$1";
$route['onde_comprar/get_detalhes/(:any)'] = "onde_comprar/get_detalhes/$1";
$route['onde_comprar/get/(:num)'] = "onde_comprar/get/$1/$2/$3";
$route['produtos/get_product_list/(:any)'] = "produtos/get_product_list/$1";
$route['produtos/get_marcas_list/(:any)'] = "produtos/get_marcas_list/$1";
$route['produtos/(:any)/(:any)'] = "produtos/detalhes/$1/$2/";
$route['produtos/(:any)'] = "produtos/detalhes/$1/";
$route['area_restrita/agenda/(:any)'] = "area_restrita/agenda/$1/$2/$3";

// manager
$route['gerenciador'] = "gerenciador/login";
$route['gerenciador/login/(:any)'] = "gerenciador/login/$1/$2/$3";
$route['gerenciador/products/(:num)'] = "gerenciador/products/index/$1/1";
$route['gerenciador/products/(:num)/(:num)'] = "gerenciador/products/index/$1/$2/";
$route['gerenciador/ar_files/(:num)'] = "gerenciador/ar_files/index/$1/1";
$route['gerenciador/ar_files/(:num)/(:num)'] = "gerenciador/ar_files/index/$1/$2/";
$route['gerenciador/ar_files_categories/(:num)'] = "gerenciador/ar_files_categories/index/$1/1";
$route['gerenciador/ar_files_categories/(:num)/(:num)'] = "gerenciador/ar_files_categories/index/$1/$2/";

/* End of file routes.php */
/* Location: ./application/config/routes.php */