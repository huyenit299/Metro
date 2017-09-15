<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'user/add' => 'user/add',
	'user/login' => 'user/login',
	'user/logout' => 'user/logout',
	'user/update' => 'user/update',
	'session/list' => 'session/list',
	'session/list_date' => 'session/list_date',
	'session/add' => 'session/add',
	'session/update' => 'session/update',
	'session/delete' => 'session/delete',
	'session/month' => 'session/month',
	'favorite/list' => 'favorite/list',
	'favorite/add' => 'favorite/add',
	'favorite/update' =>'favorite/update',
	'favorite/delete' => 'favorite/delete',
	'search' => 'session/search',
	'fare' => 'session/fare',
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
