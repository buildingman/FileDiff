<?php

/**
 * 判断路径是否存在，不存在创建
 * 判断文件是否存在，存在删除
 * 保存文件到制定路径的文件内。
 */

$dirout = dirname(__FILE__);
require_once($dirout."/../lib/Log.php");
require_once($dirout."/../Data/Common.php");

class saveContent{

	//实例化log对象
  	public function __construct(){ 
 	       $this->logger = Logger::getInstance();   
 	}

	public function checkFile($fileName){
		#判断路径是否存在，如果不存在创建
		if(!is_dir(dirname($fileName))){
			mkdir (dirname($fileName),0777,true);
          			$this->logger->debug('[' . __LINE__ .']'.' filepath not exist, mkdir filepath  success:'.$fileName, 'output'); 
		}
		#先判断文件是否存在，如果存在，先清空
		if(file_exists($fileName)){
			unlink(basename($fileName));
          			$this->logger->debug('[' . __LINE__ .']'.' filename is already exist, delete it  success:'.$fileName, 'output'); 
		} 
	}

	/**
	 * 保存文件到制定的文件
	 * @param  [string] $file [文件名]
	 * @param  [string] $data [内容]
	 */
	public function saveCont($file,$data){
		if ($f = file_put_contents($file, $data,FILE_APPEND)){
			return;
		}else{
			file_put_contents($file, "@@@@@@@@@@@写入失败@@@@@@@@@@@@",FILE_APPEND);
			#log
		}
	}
}




