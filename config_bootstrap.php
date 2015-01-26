<?php

// This file needs to be included in both config.php & database.php with a line similar to this, if you place it in the same config folder:
// require(realpath(dirname(__FILE__) . '/config_bootstrap.php'));

$config['site_label'] = 'Site Name';
$config['cp_url'] = '/custom344.php';
$config['webmaster_email'] = 'your@email.com';

if(!defined('NSM_ENV')) {

  define('NSM_SYSTEM_FOLDER', 'system');

  define('NSM_SERVER_NAME', $_SERVER['SERVER_NAME']);
  define('NSM_BASEPATH', dirname(__FILE__));
  define('NSM_SITE_URL', "//".NSM_SERVER_NAME);

  switch ($_SERVER['SERVER_NAME']) {
    case 'website.dev':
    define('NSM_ENV', 'local');
    break;
  }

  if ( ! defined('NSM_ENV')) {
    switch ($_SERVER['SERVER_NAME']) {
      case 'website.dev':
      define('NSM_ENV', 'local');
      break;
      case 'staging.website.com':
      define('NSM_ENV', 'staging');
      break;
      case 'www.website.com':
      default:
      define('NSM_ENV', 'production');
      break;
    }
  }

  if(isset($_GET['debug_config_bootstrap'])) {
    die('The current environment is: '.NSM_ENV);
  }
}

$env_config = array();
$env_db_config = array();
$env_global_vars = array();

if ('local' === NSM_ENV) {
  $env_db_config = array(
    'hostname' => '',
    'username' => '',
    'password' => '',
    'database' => '',
    );
    $env_config = array();
    $env_global_vars = array();
    $config['assets_site_url'] = 'http://website.dev/';
    $config['site_url'] = 'http://website.dev/';
    $config['debug'] = '1';
    $config['template_debugging'] = 'y';
  }
  elseif('staging' === NSM_ENV) {
    $env_db_config = array(
    'hostname' => 'localhost',
    'username' => '',
    'password' => '',
    'database' => '',
    );
    $env_config = array();
    $env_global_vars = array();
    $config['assets_site_url'] = 'http://staging.website.com';
    $config['site_url'] = 'http://staging.website.com';
    $config['theme_folder_path'] = NSM_BASEPATH . '/../../../themes/';
    $db['expressionengine']['cachedir'] = NSM_BASEPATH . '/cache/db_cache/';
    $config['debug'] = '1';
    $config['template_debugging'] = 'y';
  }
  elseif('production' === NSM_ENV) {
    $env_db_config = array(
    'hostname' => 'localhost',
    'username' => '',
    'password' => '',
    'database' => '',
    );
    $env_config = array();
    $env_global_vars = array();
    $config['assets_site_url'] = 'http://www.website.com';
    $config['site_url'] = 'http://www.website.com';
    $config['theme_folder_path'] = NSM_BASEPATH . '/../../../themes/';
    $db['expressionengine']['cachedir'] = NSM_BASEPATH . '/cache/db_cache/';
    $config['debug'] = '0';
    $config['template_debugging'] = 'n';
  }


  if(isset($config)) {

    $default_global_vars = array(
    'global:env'	=> NSM_ENV,
    'global:disable_all' => 'disable="categories|category_fields|custom_fields|member_data|pagination|trackbacks"',
    'global:disable_most' => 'disable="categories|category_fields|member_data|pagination|trackbacks"',
    'global:disable_basic' => 'disable="member_data|pagination|trackbacks"',
    );

    global $assign_to_config;

    if(!isset($assign_to_config['global_vars'])) {
      $assign_to_config['global_vars'] = array();
    }

    $assign_to_config['global_vars'] = array_merge($assign_to_config['global_vars'], $default_global_vars, $env_global_vars);

    $config['save_tmpl_files'] = 'y';
    $default_config = array(
      'tmpl_file_basepath' => NSM_BASEPATH . '/../../../templates/',
      'upload_preferences' => array(
        1 => array(                                                            // ID of upload destination
          'name'        => 'Image Uploads',                          // Display name in control panel
          'server_path' => NSM_BASEPATH . '/../../../public_html/uploads/images/', // Server path to upload directory
          'url'         => '/uploads/images/'      // URL of upload directory
        ),
        2 => array(                                                            // ID of upload destination
          'name'        => 'File Uploads',                          // Display name in control panel
          'server_path' => NSM_BASEPATH . '/../../../public_html/uploads/files/', // Server path to upload directory
          'url'         => '/uploads/files/'      // URL of upload directory
        )
      ),
    );


    $config = array_merge($config, $default_config, $env_config);
  }

  if(isset($db['expressionengine']))
  {
    $default_db_config = array(
    "cachedir" => APPPATH . "cache/db_cache/"
    );
    $db['expressionengine'] = array_merge($db['expressionengine'], $default_db_config, $env_db_config);
  }

  // Misc
  $config['date_format'] = '%d %F %Y';
  $config['time_format'] = '24';
  $config['include_seconds'] = 'y';
  $config['default_site_timezone'] = 'Europe/London';
  $config['ip2nation'] = 'n'; // don't need ip2nation

  $config['enable_online_user_tracking'] = "n";
  $config['enable_hit_tracking'] = "n";
  $config['enable_entry_view_tracking'] = "n";
  $config['dynamic_tracking_disabling'] = "";
  $config['allow_extensions'] = "y"; // yes we want extensions...
  $config['banish_masked_ips'] = 'n'; // don't want autobanning
  $config['cp_session_type'] = 'c'; // Sets the control panel to be cookies only (doesn't have long random query strings)
