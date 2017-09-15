<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Favorite  extends Controller_SuperAction {
	public function get_list() {
		$user = Model_User::query()->where("token", \Input::get('token'))->get_one();
		if ($user) {
			$type = \Input::get("type");
			$listFavorite = \DB::query("SELECT * FROM session, favorite WHERE session.id = favorite.session_id AND favorite.user_id = ".$user->id." AND common = ".$type) -> execute() ->as_array();
			// $listFavorite = DB::query("SELECT * FROM session, favorite WHERE session.id = favorite.session_id AND favorite.user_id = ".$user->id).execute()->as_array();
			Log::error("List favorite=".print_r($listFavorite,true));
			$this->setErrorStr("Get list favorite successfully!");
			$this->addRet('listFavorite', $listFavorite);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function post_add() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$user_id = $user->id;
			$session_id = \Input::post('session_id');
			$common = \Input::post('common');
			$favorite = Model_Favorite::forge(array(
				'user_id' => $user_id,
				'session_id' => $session_id,
				'common' => $common,
			));
			$favorite->save();
			$this->setErrorStr("Save favorite successfully!");
			$this->addRet('data', $favorite);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}

	}

	public function post_update() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$user_id = $user->id;
			$id = \Input::post('id');
			$session_id = \Input::post('session_id');
			$common = \Input::post('target');

			$favorite = Model_Favorite::find($id);
			if($favorite) {
				$favorite->user_id = $user_id;
				$favorite->session_id = $session_id;
				$favorite->common = $common;
				$favorite->save();

				$this->setErrorStr("Save favorite successfully!");
				$this->addRet('data', $favorite);
				$this->resp();
			}else {
				$this->setState('OK');
				$this->setErrorStr("This favorite doesn't exist.");
				$this->setErrorType("101");
				$this->resp();
			}
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function  post_delete() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$id = \Input::post('id');
			$favorite = Model_Favorite::find($id);
			if($favorite) {
				$favorite->delete();
				$this->setErrorStr("Delete favorite successfully!");
				$this->addRet('data', $favorite);
				$this->resp();
			}else {
				$this->setState('OK');
				$this->setErrorStr("This favorite doesn't exist.");
				$this->setErrorType("101");
				$this->resp();
			}
		}else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}
}
