<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_SuperAction extends \Controller_Rest
{
	//ログファイル
	var $logfile;
	var $logtitle;
	
	// URL
	var $baseURLApp 			= '';
	var $baseURLAppNoAuthBasic	= '';
	var $baseURLImg 			= '';
	var $imgURL  				= array();
	
	// S3のバケット
	var $S3Bucket = '';
	
	// iPhoneプロビジョニングファイル
	var $appProvisioning = '';
	
	// レスポンスステータス
	var $state 		= "";
	var $state_des 	= "";
	var $error_str 	= "";
	var $error_type = 0;
	var $errors 	= array();
	var $ret 		= array();
	
	// ベンチマーク
	var $banchmark_time;
	var $banchmark_micro;
	
	/**
	 * before
	 */
	public function before()
	{
				
		parent::before();
		
	}
	
	/**
	 * before
	 */
	public function sample()
	{
		return "sampleメソッド";
	}

	/* !ログ */
	/**
	 * ログの出力
	 * 
	 */
	protected function logWrite()
	{
		Log::write('----- start log', '');
		
		Log::write('real_ip', Input::real_ip());
		Log::write('uri', Input::uri());
		Log::write('user_agent', Input::user_agent());
		
		ob_start();
   		var_dump(Input::all());
   		Log::write('Input::all', ob_get_contents());
   		ob_end_clean();
   		
   		ob_start();
   		var_dump(Session::get());
   		Log::write('Session::get', ob_get_contents());
   		ob_end_clean();
   		
   		Log::write('----- end log', '');
	}
	
	/**
	 * 
	 */
	public function setLogFile($logtitle, $url)
	{
		$this->logtitle = $logtitle;
		$this->logfile = $url;
		
		
		
		if(file_exists($this->logfile)) unlink($this->logfile);
		$this->log("start LOG <br>\n");
		chmod($this->logfile, 0777);
		
	}
	
	/**
	 * 
	 */
	public function log($str)
	{
		if(!$this->logfile) retun;
		error_log("【".$this->logtitle."】".$str."\n", 3, $this->logfile);
	}
	
	/**
	 * try exception
	 * 
	 */
	protected function exception_handler($e)
	{
				
		
		$json = json_encode(array("error"=>(string)$e));
		print $json;
	}

	/**
	 * set state
	 */
	protected function setState($str)
	{
		$this->state = $str;
	}
	
	/**
	 * set state destination
	 */
	protected function setStateDes($str)
	{
		$this->state_des = $str;
	}
	
	
	/**
	 * Set error type
	 *	0：No error
	 *	1：DB error
	 *	
	 */
	protected function setErrorType($str)
	{
		$this->error_type = $str;

	}
	
	
	/**
	 * Set error string
	 */
	protected function setErrorStr($str)
	{
		$this->error_str = $str;

	}
	
	
	/**
	 * Validation error
	 */
	protected function onValidationError($val)
	{
		//ステート
		$this->setState("ValidationError");
		$this->setStateDes(implode(",", $val->error()));
        
        $this->resp();
	}
	
	/**
	 * Return value
	 */
	protected function addRet($key, $val)
	{
		$this->ret[$key] = $val;
	}
	
	/* 
	 * Response value
	 */
	protected function resp()
	{
		$this->ret['state'] = $this->state;
		$this->ret['state_des'] = $this->state_des;
		$profiler = \Profiler::output();
		$success = true;
		if ($this->error_type != 0) {
			$success = false;
		}
		$this->response(array(
			"data"=>$this->ret, 
			"error" => array(
				"resultMessage" => $this->error_str,
				"resultCode" => $this->error_type,
			),
			"success" => $success,
			'profiler' => $profiler,
		));
	}
	
}