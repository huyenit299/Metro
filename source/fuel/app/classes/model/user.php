<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author DELL
 */
class Model_User extends \Orm\Model {
	protected static $_table_name = 'users';

	protected static $_properties = array(
		'id' => array('data_type' => 'bigint'),
		'username',
		'password',
		'token',
	);
}
