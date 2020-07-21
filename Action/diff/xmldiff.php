<?php 
/**
* Created by sublime
* User : lizhi
* time : 07/09/2018
 */

$dirxmldiff = dirname(__FILE__);
require_once($dirxmldiff."/../../lib/Log.php");
require_once($dirxmldiff."/../../lib/file.php");

class XmlDiff {

	

	/**
	 * 将xml文件转换为数组
	 * key   对应节点
	 * value对应属性
	 */
	function xmlArr($xmlfile){
		$xml_object = simplexml_load_file($xmlfile); 
 	 	$xml_json    = json_encode($xml_object);
	    	$xml_array   = json_decode($xml_json,true);
	    	return $xml_array;
	}

	/**
	 * 将整体的数组遍历到一个一维数组中进行对比 
	 * 数组形式xml所有的note value 均在数组内作为value，如果出现多个相同的节点，这个问题还需要解决
	 */
	public function xmlArrHandle1($xmlarr){
		static $xmlhandlearr1 = array();
		foreach($xmlarr as $key => $value){
			if(is_array($value)){
				array_push($xmlhandlearr1,$key);
				$this->xmlArrHandle1($value);
			}else{
				array_push($xmlhandlearr1,$key,$value);
			}
		}
		return $xmlhandlearr1;
	}

	/** 不知道怎么解决静态变量释放的问题，暂且写两个吧 */
	public function xmlArrHandle2($xmlarr){
		static $xmlhandlearr2 = array();
		foreach($xmlarr as $key => $value){
			if(is_array($value)){
				array_push($xmlhandlearr2,$key);
				$this->xmlArrHandle2($value);
			}else{
				array_push($xmlhandlearr2,$key,$value);
			}
		}
		return $xmlhandlearr2;
	}

	/** 对比数组长度，将长的放在左侧 */
	function xmlDiffArr($arr1 , $arr2){
		if(count($arr1) > count($arr2)){
			$arrdiffcont = array_diff($arr1, $arr2);
			return $arrdiffcont;
		}else{
			$arrdiffcont = array_diff($arr2, $arr1);
			return $arrdiffcont;
		}
	}

	/**
	 * 通过对比节点来获取相应的对应文件内的不同值
	 * @param  [arr] $nodediff [存储的是对比之后的结果信息，节点为主]
	 * @param  [arr] $arrbase [对比数据其中一个的原始数据，通过节点获取value]
	 * @return [arr]        [返回的信息是对应数组内的value]
	 */
	function diffArrCont($nodediff , $arrbase){
		foreach($nodediff as $key=>$value){
			if(isset($arrbase[$key])){
				$arrcont[] = $arrbase[$key];
			}
		}
		return $arrcont;
	}
}




