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
class Controller_User extends Controller_SuperAction {
	public function post_login() {
		$username = \Input::post('username');
		$password = \Input::post('password');
	  Log::error("login+". print_r($username,true));
		$user = Model_User::query()->where('username', $username)->where('password',$password)->get_one();
		$token = bin2hex(random_bytes(20));
		if ($user) {
			Log::error("user=".print_r($user,true));
			$user['token'] = $token;
			Log::error("user1=".print_r($user,true));
			$user->save();
		}
		Log::error("login+ddd". print_r($username,true));
		$this->setState('OK');
		$this->addRet('token', $token);
		$this->resp();

	}

	public function post_update() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$user->username = \Input::post('username');
			$user->password = \Input::post('password');
			$user->save();
			$this->setState('OK');
			$this->addRet('data', $user);
			$this->resp();
		} else {
			$this->setState('error');
			$this->addRet('data', array("message" => "This user didn't exist"));
			$this->resp();
		}

	}

	public function post_add() {
		$username = \Input::post('username');
		$password = \Input::post('password');
		Log::error("go here=". print_r($username,true));
		$token = bin2hex(random_bytes(64));
		$user = Model_User::forge(array(
			'username' => $username,
			'password' => $password,
			'token' => $token,
		));
		$user->save();
		Log::error("go here=". print_r($user,true));
		$this->setState('OK');
		$this->addRet('data', $user);
		$this->resp();
	}

	public function post_logout() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$user->token = "";
			$user->save();
			$this->setState('OK');
			$this->addRet('data', $user);
			$this->resp();
		} else {
			$this->setState('error');
			$this->addRet('data', array("message" => "This user didn't exist"));
			$this->resp();
		}

	}
}
