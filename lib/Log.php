<?php  

/**
* Created by sublime
* User : lizhi
* time : 05/09/2018
 */

/**
 * 使用方法介绍
 * 实例化对象
 * $logger = Logger::getInstance();   
 * 设置日志输出级别，分为5级
 * $logger -> setLogLevel(int) 0 1 2 3 4 5
 * 日志调用方法
 * $logger->debug($message, $name); 
 * $message 需要输出的信息
 * $name 当前路径下新建的文件名，作为存储日志用
 */

//定义日志文件的绝对路径,设置日志等级
define('DIR_ROOT', "/Users/lizhi/work/htmlcode/diff/");
define('LEVEL_FATAL' , 0);
define('LEVEL_ERROR' , 1);
define('LEVEL_WARN' , 2);
define('LEVEL_INFO' , 3);
define('LEVEL_DEBUG' , 4);

//记录操作过程中的日志信息
class Logger{
	
	static $LOG_LEVEL_NAMES = array(
		'FATAL',
		'ERROR',
		'WARN',
		'INFO',
		'DEBUG'
		);

	private $level = LEVEL_DEBUG;
	private $rootDir = DIR_ROOT;

	#调用方法进行实例化对象
	static function getInstance() {  
        		return new Logger;  
    	}  

    	/*
    	*  设置最小的日志级别，小于该级别的日志将会被忽略掉
    	*  @param  int $lv1 -- 最小的日志输出级别
    	*  @throw Exception 
    	 */
    	function setLogLevel($lv1){
    		if($lv1 >= count(Logger::$LOG_LEVEL_NAMES) || $lv1 < 0){
    			throw new Exception('invalid log level:' . $lv1);
    		}
    		$this -> level = $lv1;
    	}

    	#################输出各个级别的日志###############
    	function debug($message , $name = 'root'){
    		$this -> _log(LEVEL_DEBUG, $message, $name);
    	}

    	function info($message, $name = 'root'){
    		$this -> _log(LEVEL_INFO, $message, $name);
    	}

    	function warn($message, $name = 'root'){
    		$this -> _log(LEVEL_WARN, $message, $name);
    	}

    	function error($message, $name = 'root'){
    		$this -> _log(LEVEL_ERROR, $message, $name);
    	}

    	function fatal($message, $name = 'root'){
    		$this -> _log(LEVEL_FATAL, $message, $name);
    	}

    	/**
    	 * 记录log日志信息
    	 */
    	private function _log($level, $message, $name){

    		//检测日志级别，如果不满足设置的默认值，则不输出
    		if($level > $this ->level ){
    			return;
    		}

    		//检测文件路径是否存在，不存在创建
    		$dir_file_path = $this->rootDir . "/log/";
    		if(!is_dir($dir_file_path)){
			mkdir ($dir_file_path,0777,true);
		}
    		$log_file_path = $this->rootDir . "/log/" . $name . '.log';
    		$log_level_name = Logger::$LOG_LEVEL_NAMES[$this -> level];
    		$content = date('Y-m-d H:i:s') . '[' . $log_level_name . ']' . "$message" . "\n";
    		file_put_contents($log_file_path, $content, FILE_APPEND);
    	}

}

