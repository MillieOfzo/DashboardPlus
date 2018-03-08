<?php 
/* 
==========================================================================================================

	Name: Common file
	Functie: 
			
	Version: 1.0.8
	Author:	Roelof Jan van Golen - <r.vangolen@asb.nl>

==========================================================================================================
*/	
	define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"]);
	
	$env = parse_ini_file(ROOT_PATH.'/Mdb/env.ini', true);	
	
	// DB connectie for mdb database
	define('DB_HOST', $env['LOCAL_DB']['HOST']);
	define('DB_USER', $env['LOCAL_DB']['USER']);
	define('DB_PASS', $env['LOCAL_DB']['PASS']);
	define('DB_NAME', $env['LOCAL_DB']['NAME']);

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
     
    try 
    { 
        $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, $options); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to connect to the database: " . $ex->getMessage());
    } 
     
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
	
	define('URL_ROOT', $env['APP']['URL_ROOT']);
	define('URL_ROOT_OTAP', getSetting($db, 'URL_ROOT_OTAP'));
	define('URL_ROOT_IMG', $env['APP']['URL_ROOT_IMG']);
	define('GOOGLE_API', $env['APP']['GOOGLE_API']);
	define('APP_NAME', getSetting($db, 'APP_NAME'));
	define('APP_TITLE', getSetting($db, 'APP_TITLE'));
	define('APP_EMAIL', getSetting($db, 'APP_EMAIL'));
	define('APP_ENV', $env['APP']['ENV']);
	define('APP_LANG', getSetting($db, 'APP_LANG'));
	define('APP_LAT', (int)getSetting($db, 'APP_LAT'));
	define('APP_LNG', (int)getSetting($db, 'APP_LNG'));
	define('APP_DEBUG', $env['APP']['DEBUG']);
	define('APP_INITIALIZE', (int)getSetting($db, 'APP_INITIALIZE'));
	
	// Define SCS conn
	define('SCS_DB_HOST', $env['SCS_DB']['HOST']);
	define('SCS_DB_USER', $env['SCS_DB']['USER']);
	define('SCS_DB_PASS', $env['SCS_DB']['PASS']);
	define('SCS_DB_NAME', $env['SCS_DB']['NAME']);
	define('SCS_DB_CONN', array(
		'host' 	=> SCS_DB_HOST, 
		'user' 	=> SCS_DB_USER, 
		'pass' 	=> SCS_DB_PASS, 
		'db' 	=> SCS_DB_NAME
	));
	
	// Define RMS conn
	define('RMS_DB_HOST', $env['RMS_DB']['HOST']);
	define('RMS_DB_USER', $env['RMS_DB']['USER']);
	define('RMS_DB_PASS', $env['RMS_DB']['PASS']);
	define('RMS_DB_NAME', $env['RMS_DB']['NAME']);		
	define('RMS_DB_CONN', array(
		'host' 	=> RMS_DB_HOST, 
		'user' 	=> RMS_DB_USER, 
		'pass' 	=> RMS_DB_PASS, 
		'db' 	=> RMS_DB_NAME
	));
	
	// Include file router
	require ROOT_PATH."/Mdb/Src/file_package.php";
	
	// Function files
	require ROOT_PATH.ROOT_FILE['functions'];
	require ROOT_PATH.ROOT_FILE['error_handler'];	
	require ROOT_PATH.ROOT_FILE['ssp_class'];	
	
	// Libs
	require ROOT_PATH.ROOT_FILE['phpmailer'];	
	
	// Class files
	require ROOT_PATH.ROOT_FILE['safemysql'];
	require ROOT_PATH.ROOT_FILE['google'];
	require ROOT_PATH.ROOT_FILE['login'];
	require ROOT_PATH.ROOT_FILE['location'];
	require ROOT_PATH.ROOT_FILE['home'];
	
	// Define function to get settings
	function getSetting($db_conn, $setting_name){
		$stmt 	= $db_conn->prepare("SELECT * FROM app_settings LIMIT 1");
		$stmt->execute();	
		
		$row 	= $stmt->fetch(); 

		return $row[strtolower($setting_name)];
	}
	
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
	
    // Set header content
    header('Content-Type: text/html; charset=UTF-8'); 
    // Start session
	session_start(); 
	
	// Set package const as variable
	$arr_css 	= ROOT_CSS;
	$arr_js 	= ROOT_JS;

	//$user_db 		= new SafeMySQL();
	//$user_ini		= @htmlentities($_SESSION['user']['user_id'], ENT_QUOTES, 'UTF-8');	
	//$user_cols  	= $user_db->getRow("SELECT * FROM app_users WHERE user_status = 'Active' AND user_id =  ?i",$user_ini);	
	
	// Get url and set view relative to view folder
	$url_arr 		= parse_url($_SERVER['REQUEST_URI']);
	
	// Prevent access to errors and layout folders
	if($url_arr['path'] == '/mdb/view/errors/' || $url_arr['path'] == '/mdb/view/layout/'){
		http_response_code(404);
		include ROOT_PATH.'/mdb/view/errors/page_404.php';
		die();
	} else {
		$view_content = preg_replace('{/$}', '.view.php', $url_arr['path']);	
	}
	
	