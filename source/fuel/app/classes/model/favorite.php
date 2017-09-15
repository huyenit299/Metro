<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Favorite extends Orm\Model {
	protected static $_table_name = 'favorite';

	protected static $_properties = array(
		'id' => array('data_type' => 'bigint'),
		'user_id' => array('data_type' => 'bigint'),
		'session_id',
		'common',
	);
}
