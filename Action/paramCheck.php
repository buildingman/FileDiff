<?php 
/**
* Created by sublime
* User : lizhi
* time : 05/09/2018
 */

$dirparam = dirname(__FILE__);
require_once($dirparam."/../lib/Log.php");

/**
 * 参数介绍：
  * [0] => diff.php  	功能入口文件
  * [1] => -t	   	文件类型提示参数
  * [2] => xml | json	文件类型选定，决定调用那个方法处理数据
  * [3] => -l		左文件标识符
  * [4] => jsonlift.inc	左文件
  * [5] => -r		右文件标识符
  * [6] => jsonrift.inc	右文件	
  * [7] => -o		输出路径
  * [8] => jsonlift.inc.lz	输出文件
  * [9] => -e		编码类型提示符
  * [10] => utf8		需要将文件编码转换成此编码
 */

class ParamCheck{

	//定义规定的数组
	public $arrparam = array( '-t' , '-l' , '-r' , '-o' , '-e');
	public $arrtype = array( 'xml' , 'json' );
	public $arrencode = array( 'utf-8' , 'gbk');

	//实例化log对象
	public function __construct(){ 
		$this->logger = Logger::getInstance();   
	}

	/**
	 * 对比参数是否多余，是否满足要求。
	 * @param  [type] $arrobt [description]
	 * @return [type]         [description]
	 */
	function arrCheck($arrobt){

		//判断参数数量是否等于11
		if( count($arrobt) != 11){
        			$this->logger->debug('[' . __LINE__ .']'.'  param error  ,content:'.json_encode($arrobt), 'paramcheck'); 
			die("param  error please check!");
		}
		
		//将字母小写化
		foreach($arrobt as $key=>$value){
			$arrobt[$key] = strtolower($value);
		}

		//判断数组内部是否存在规定数组的给定的参数,不区分大小写
		foreach ($this->arrparam as  $value) {
			if(!in_array($value, $arrobt)){
        				$this->logger->debug('[' . __LINE__ .']'.'  param error  ,content:'.$value.'  run  lost ', 'paramcheck'); 
				die("param error :"."$value"."\trun lost \n");
			}
		}

		/** 
		 * 数据格式如下，类型str
		 * 增加对type + code 的判断逻辑
		 * 判断文件是否存在
		 * [-t] => xml
		 * [-l] => lift
		 * [-r] => right
		 * [-o] => lujing
		 * [-e] => gbk
		 */
		foreach($arrobt as $key => $value ){
			switch ($value) {
				case $value == '-t':
				if($arrobt[$key+1] != 'json' and $arrobt[$key+1] != 'xml'){
        					$this->logger->debug('[' . __LINE__ .']'.'  param type error ,content:'.$value.'=>'.$arrobt[$key+1], 'paramcheck'); 
					die('param type error content : '.$value.'=>'.$arrobt[$key+1]);
				}
				$arrformat[$value] = $arrobt[$key+1];break;

				case $value == '-l':
				if(!file_exists($arrobt[$key+1])){
        					$this->logger->debug('[' . __LINE__ .']'.'  lift file not fuond  ,content:'.$value.'=>'.$arrobt[$key+1], 'paramcheck'); 
					die('lift file not found  content : '.$value.'=>'.$arrobt[$key+1]);
				}
				$arrformat[$value] = $arrobt[$key+1];break;

				case $value == '-r':
				if(!file_exists($arrobt[$key+1])){
        					$this->logger->debug('[' . __LINE__ .']'.'  right file not fuond  ,content:'.$value.'=>'.$arrobt[$key+1], 'paramcheck'); 
					die('right file not found  content : '.$value.'=>'.$arrobt[$key+1]);
				}
				$arrformat[$value] = $arrobt[$key+1];break;

				case $value == '-o':$arrformat[$value] = $arrobt[$key+1];break;

				case $value == '-e':
				if($arrobt[$key+1] != 'utf-8' and $arrobt[$key+1] != 'gbk'){
        					$this->logger->debug('[' . __LINE__ .']'.'  param code error ,content:'.$value.'=>'.$arrobt[$key+1], 'paramcheck'); 
					die('param code error content : '.$value.'=>'.$arrobt[$key+1]);
				}
				$arrformat[$value] = $arrobt[$key+1];break;
			}
		}
		return $arrformat;
	}


}

