<?php 
/**
* Created by sublime
* User : lizhi
* time : 05/09/2018
 */
$direncode = dirname(dirname(__FILE__));
require_once($direncode."/lib/Log.php");

Class encodeSet{

	//实例化log对象
	public function __construct(){ 
		$this->logger = Logger::getInstance();   
	}

	/**
	 * 使用方法
	 * @param  [str] $keytitle [文本内容]
	 * @param  [str] $wishcode [要转成的期望编码]
	 * @return   成功返回内容，失败打印日志
	 */
	public function codeChange($keytitle,$wishcode){
		//获取内容的编码格式
		$encode = mb_detect_encoding($keytitle, array("GBK","UTF-8"));
			echo $encode;

		//比较编码的格式要求，不区分大小写，如果不满足转换
		if(strcasecmp($wishcode,$encode) != 0){
			$keytitle = iconv($encode,$wishcode,$keytitle);
        			$this->logger->debug('[' . __LINE__ .']'.'code change sucess ,content:'.$keytitle, 'encode'); 
			return $keytitle;
		}else{
        			$this->logger->debug('[' . __LINE__ .']'.'file code not change :'.$keytitle, 'encode'); 
		}
	}
}



