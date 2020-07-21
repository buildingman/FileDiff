<?php 
/**
* Created by sublime
* User : lizhi
* time : 10/09/2018
 */

class XmlOut{

	/**
	 * 参数介绍
 	* xmldifffile 比对两个文件的不同的数组。节点为主
 	* xmllift  左文件整理成一位数组之后的array
 	* xmlright  右文件整理成一位数组之后的array
 	* xmlcontlift 左文件内容不同处，对应的是原内容
 	* xmlcontright 右文件内容不同处，对应的是原内容
 	*/
	function xmlPush($xmldifffile,$xmlcontlift,$xmlcontright){

		
		$diffContArr = array();
		//统计共有多少不同点
		$diffcount = count($xmldifffile);
		$diffContArr[] = "+++++++++++++共有"."$diffcount"."处不同++++++++++++++\n\n";
		//将节点相同的输入进数组
		for($i = 0 ; $i<$diffcount ;$i++){
			$a = $i+1;
			$diffContArr[] = "diff".$a."-----------------------\n";
			$diffContArr[] = '>    '.$xmlcontlift[$i]."\n";
			$diffContArr[] = '<    '.$xmlcontright[$i]."\n";
		}
		return $diffContArr;
	}

	function jsonPush(){

		
	}
}
