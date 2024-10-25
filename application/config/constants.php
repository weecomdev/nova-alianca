<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// CONSTANTS FOR SITE
define('SITE_TITLE', 'Nova Aliança');

// CONSTANTS FOR UPLOAD
define('UPLOAD_PATH', BASEPATH.'../_files/');

define('BANNERS_PATH', '_files/banners/');
define('BANNERS_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.BANNERS_PATH);

define('ABOUT_US_IMAGES_PATH', '_files/about_us_images/');
define('ABOUT_US_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.ABOUT_US_IMAGES_PATH);

define('NOTICIAS_IMAGES_PATH', '_files/noticias/');
define('NOTICIAS_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.NOTICIAS_IMAGES_PATH);

define('DICAS_IMAGES_PATH', '_files/dicas/');
define('DICAS_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.DICAS_IMAGES_PATH);

define('PREMIACOES_IMAGES_PATH', '_files/premiacoes/');
define('PREMIACOES_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.PREMIACOES_IMAGES_PATH);

define('COMPRAS_IMAGES_PATH', '_files/compras/');
define('COMPRAS_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.COMPRAS_IMAGES_PATH);

define('PRODUCTS_PATH', '_files/products/');
define('PRODUCTS_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.PRODUCTS_PATH);

define('AR_PATH', '_files/area_restrita/');
define('AR_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.AR_PATH);

define('TEXT_IMAGES_PATH', '_files/text/');
define('TEXT_IMAGES_UPLOAD_PATH', str_replace('/system/','',BASEPATH).'/'.TEXT_IMAGES_PATH);

// CONSTANTS FOR LAYOUT
define('ASSETS', '_assets/');
define('ASSETS_MANAGER', '_assets/manager/');
define('IMG_MANAGER', ASSETS_MANAGER.'images/');
define('JS_MANAGER', ASSETS_MANAGER.'js/');
define('JS', ASSETS.'js/');
define('IMG', '_assets/images/');

// GENERAL USE
define('LATIN1_UC_CHARS', "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝºª");
define('LATIN1_LC_CHARS', "àáâãäåæçèéêëìíîïðñòóôõöøùúûüýºª");

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */