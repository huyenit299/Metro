<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Session extends Orm\Model {
	protected static $_table_name = 'session';

	protected static $_properties = array(
		'id' => array('data_type' => 'bigint'),
		'user_id' => array('data_type' => 'int'),
		'date',
		'target',
		'traffic',
		'from',
		'to',
		'fare',
		'remarks'
	);
	protected static $_has_one = array('favorite');
}
