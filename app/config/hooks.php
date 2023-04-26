<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 쿼리 로깅 2023.4.18
$hook['post_system'] = array(
	'class' => 'DbLog',
	'function' => 'logQueries',
	'filename' => 'db_log.php',
	'filepath' => 'hooks',
	'params' => array()
);
