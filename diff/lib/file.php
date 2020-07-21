<?php 
/**
* Created by sublime
* User : lizhi
* time : 05/09/2018
 */

$dirlog = dirname(__FILE__);
require_once($dirlog."/Log.php");

//本类为文件处理的基本操作，读取内容，获取行数，数据格式处理
class Filehandle{

	//实例化log对象
	public function __construct(){ 
		$this->logger = Logger::getInstance();   
	}

	/**
	 * 获取文件内容
	 * @param  $filename 文件名 
	 * @param  $size   文件读取的大小
	 * @return   返回的内容为str
	 */
	function fileContent($filename){
		//判断文件是否存在，如果不存在退出
		if(file_exists($filename)){
			$content = fopen($filename, "r");
			$myfile    = fread($content, filesize($filename));
			fclose($content);
        			$this->logger->warn('[' . __LINE__ .']'.' file content obtain sucess :'.$filename, 'file'); 
			return $myfile = str_replace("\r\n", "<br />", $myfile);
		}else{
        			$this->logger->warn('[' . __LINE__ .']'.' file not found :'.$filename, 'file'); 
			die('file not found ');
		}
	}
}





