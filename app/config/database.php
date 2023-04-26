<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'maindb';
$active_record = TRUE;

$db['master']['hostname'] = 'dbhost:3306';
$db['master']['username'] = 'username';
$db['master']['password'] = 'password';
$db['master']['database'] = 'database';
$db['master']['dbdriver'] = 'mysqli';
$db['master']['dbprefix'] = '';
$db['master']['pconnect'] = TRUE;
$db['master']['db_debug'] = (DEBUG === true); // (ENVIRONMENT !== 'production');
$db['master']['cache_on'] = FALSE;
$db['master']['cachedir'] = FCPATH . 'data/cache/db';
$db['master']['char_set'] = 'utf8';
$db['master']['dbcollat'] = 'utf8_general_ci';
$db['master']['swap_pre'] = '';
$db['master']['autoinit'] = TRUE;
$db['master']['stricton'] = FALSE;
$db['master']['save_queries'] = TRUE; // Query Loging
