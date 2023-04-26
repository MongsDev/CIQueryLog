<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'maindb';
$active_record = TRUE;

$db['tranggle3']['hostname'] = 'dbhost:3306';
$db['tranggle3']['username'] = 'username';
$db['tranggle3']['password'] = 'password';
$db['tranggle3']['database'] = 'database';
$db['tranggle3']['dbdriver'] = 'mysqli';
$db['tranggle3']['dbprefix'] = '';
$db['tranggle3']['pconnect'] = TRUE;
$db['tranggle3']['db_debug'] = (DEBUG === true); // (ENVIRONMENT !== 'production');
$db['tranggle3']['cache_on'] = FALSE;
$db['tranggle3']['cachedir'] = FCPATH . 'data/cache/db';
$db['tranggle3']['char_set'] = 'utf8';
$db['tranggle3']['dbcollat'] = 'utf8_general_ci';
$db['tranggle3']['swap_pre'] = '';
$db['tranggle3']['autoinit'] = TRUE;
$db['tranggle3']['stricton'] = FALSE;
$db['tranggle3']['save_queries'] = TRUE; // Query Loging
