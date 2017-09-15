<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Session  extends Controller_SuperAction {
	public function get_list() {
		$user = Model_User::query()->where("token", \Input::get('token'))->get_one();
		Log::error("ssssrkkkk=".print_r($user,true));
		if ($user) {
			$month = \Input::get('month');
			$param = array();
			$listSession = array();
			if($month) {
				Log::error("month=".print_r($month,true));
				$listSession = Model_Session::query()->where('user_id', $user->id)->where('date','LIKE', $month.'%')->get();
			} else {
				$listSession = Model_Session::query()->where('user_id', $user->id)->get();
			}
			$this->setErrorStr("Get list successfully!");
			$this->addRet('listSession', $listSession);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function get_list_date() {
		$user = Model_User::query()->where("token", \Input::get('token'))->get_one();
		if ($user) {
			$start = \Input::get("start");
			$end = \Input::get("end");
			$listSession = Model_Session::query()->where('user_id', $user->id)->where('date','>=', $start)->where('date','<=', $end)->get();
			$this->setErrorStr("Get list successfully!");
			$this->addRet('listSession', $listSession);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function get_month() {
		$user = Model_User::query()->where("token", \Input::get('token'))->get_one();
		Log::error("get month=".print_r($user,true));
		if ($user) {
			$query = DB::select("session.date") -> from("session")->distinct()->group_by(DB::expr('YEAR(session.date)'), DB::expr('MONTH(session.date)'))->order_by("session.date","DESC");
			$listSession = \DB::query($query)->execute()->as_array();
			Log::error("list month=".print_r($listSession,true));
			$this->setErrorStr("Get list month successfully!");
			$this->addRet('listMonth', $listSession);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function get_search() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$keyword = \Input::get('keyword');
			$listSession = Model_Session::query()->where('target',"LIKE",'%'+$keyword+"%");
			$this->setErrorStr("Get list successfully!");
			$this->addRet('data', $listSession);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}
	}

	public function post_add() {
		Log::error("go hereeeeee");
		$token = \Input::post('token');
		Log::error("tokeneeeee=".print_r($token,true));
		$user = Model_User::query()->where('token', $token)->get_one();
		Log::error("userkkkk=".print_r($user,true));
		if ($user) {
			Log::error("user session add=".print_r($user,true));
			$user_id = $user->id;
			$date = \Input::post('date');
			$target = \Input::post('target');
			$traffic = \Input::post('traffic');
			$from = \Input::post('from');
			$to = \Input::post('to');
			$fare = \Input::post('fare');
			$remarks = \Input::post('remarks');

			$session = Model_Session::forge(array(
				'user_id' => $user_id,
				'date' => $date,
				'target' => $target,
				'traffic' => $traffic,
				'from' => $from,
				'to' => $to,
				'fare' => $fare,
				'remarks' => $remarks
			));
			$session->save();
			$this->setErrorStr("Save session successfully!");
			$this->addRet('data', $session);
			$this->resp();
		} else {
			$this->setState('OK');
			$this->setErrorStr("Add session.Your session expired. Please login again");
			$this->setErrorType("101");
			$this->resp();
		}

	}

	public function post_update() {
		$user = Model_User::query()->where("token", \Input::post('token'))->get_one();
		if ($user) {
			$user_id = $user->id;
			$id = \Input::post('id');
			$date = \Input::post('date');
			$target = \Input::post('target');
			$traffic = \Input::post('traffic');
			$from = \Input::post('from');
			$to = \Input::post('to');
			$fare = \Input::post('fare');
			$remarks = \Input::post('remarks');

			$session = Model_Session::find($id);
			Log::error('dateee+'.print_r($date,true));
			if ($session) {
				Log::error('session+'.print_r($session,true));
				$session->user_id = $user_id;
				$session->date = $date;
				$session->target = $target;
				$session->traffic = $traffic;
				$session->from = $from;
				$session->to = $to;
				$session->fare = $fare;
				$session->remarks = $remarks;
				$session->save();

				$this->setErrorStr("Save session successfully!");
				$this->addRet('data', $session);
				$this->resp();
			}else {
				$this->setState('OK');
				$this->setErrorStr("This session doesn't exist.");
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
			$session = Model_Session::find($id);
			if($session) {
				$session->delete();
				$this->setErrorStr("Delete session successfully!");
				$this->addRet('data', $session);
				$this->resp();
			}else {
				$this->setState('OK');
				$this->setErrorStr("This session doesn't exist.");
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
