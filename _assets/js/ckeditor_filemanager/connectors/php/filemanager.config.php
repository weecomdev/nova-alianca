<?php

/**
 *	Filemanager PHP connector configuration
 *
 *	filemanager.config.php
 *	config for the filemanager.php connector
 *
 *	@license	MIT License
 *	@author		Riaan Los <mail (at) riaanlos (dot) nl>
 *	@author		Simon Georget <simon (at) linea21 (dot) com>
 *	@copyright	Authors
 */


/**
 *	Check if user is authorized
 *
 *	@return boolean true is access granted, false if no access
 */
function auth() {
	return true;
	$ci_session = $_COOKIE['cms_ci_session'];
	$ci_session = stripslashes($ci_session);
	$ci_session = unserialize($ci_session);
	$ci_session_id = $ci_session['session_id'];
	
	$dbhost = 'mysql05.esafety.com.br';
	$dbuser = 'esafety4';
	$dbpass = 'k0UbAKPQ5Ef2';
	$dbnya = 'esafety4';
	
	$ci_session_con = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$ci_session_con) die("Não foi possível conectar ao banco.");
	$query = "SELECT user_data FROM tbl_users_sessions  WHERE session_id = '$ci_session_id' LIMIT 1";
	mysql_select_db($dbnya, $ci_session_con);
	$result = mysql_query($query, $ci_session_con);
	if (!$result) die("Query Inválida");

	$row = mysql_fetch_assoc($result);
	$data = unserialize($row['user_data']);
	
	if($data['logado']== 'true')
		return true;
	else
		return false;
}


/**
 *	Language settings
 */
$config['culture'] = 'pt';

/**
 *	PHP date format
 *	see http://www.php.net/date for explanation
 */
$config['date'] = 'd M Y H:i';

/**
 *	Icons settings
 */
$config['icons']['path'] = 'images/fileicons/';
$config['icons']['directory'] = '_Open.png';
$config['icons']['default'] = 'default.png';

/**
 *	Upload settings
 */
$config['upload']['overwrite'] = false; // true or false; Check if filename exists. If false, index will be added
$config['upload']['size'] = false; // integer or false; maximum file size in Mb; please note that every server has got a maximum file upload size as well.
$config['upload']['imagesonly'] = false; // true or false; Only allow images (jpg, gif & png) upload?

/**
 *	Images array
 *	used to display image thumbnails
 */
$config['images'] = array('jpg', 'jpeg','gif','png');


/**
 *	Files and folders
 *	excluded from filtree
 */
$config['unallowed_files']= array('.htaccess', '.DS_Store');
$config['unallowed_dirs']= array('_thumbs','.CDN_ACCESS_LOGS', 'cloudservers');

/**
 *	FEATURED OPTIONS
 *	for Vhost or outside files folder
 */
// $config['doc_root'] = '/home/user/userfiles'; // No end slash


/**
 *	Optional Plugin
 *	rsc: Rackspace Cloud Files: http://www.rackspace.com/cloud/cloud_hosting_products/files/
 */
$config['plugin'] = null;
//$config['plugin'] = 'rsc';



//	not working yet
//$config['upload']['suffix'] = '_'; // string; if overwrite is false, the suffix will be added after the filename (before .ext)

?>