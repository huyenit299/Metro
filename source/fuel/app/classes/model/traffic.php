<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Traffic extends Controller_SuperAction {
	protected static $_table_name = 'traffic';

	protected static $_properties = array(
		'id' => array('data_type' => 'bigint'),
		'name'
	);
}