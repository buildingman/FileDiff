<?php

require_once("/Users/lizhi/work/htmlcode/diff/Data/Common.php");

class FileCheck{

/**
 * 检测文件内容是否符合json格式，采用的json_decode的方法，如果返回的type是obj则满足
 * 行内容为空不进行比较
 * 逐行进行比对
 * 如果最后返回1，则证明文件内容OK
 */
	public function jsonCheck($inputfile){

		#获取json文件内容,以及行数
		$file = fopen($inputfile,'a+');
		$lineNo = count(file($inputfile));

		#遍历文章的行数
		for($i=0 ; $i< $lineNo ; $i++){
			#按照文件行数读取文件,并获取内容类型。
			$leng = trim(fgets($file));
			if(strlen($leng)>0){
				//不是空行，获取内容格式
				$jsonType = gettype(json_decode($leng));
				if($jsonType != 'object' ){
					die(Data_Common::JSONFILEERR);
				}
			}
		}
		return 1;
		fclose($file);
	}

/**
 * 调用xml解析器进行校验xml文件
 * 文件内容为xml格式
 * 成功返回1，失败结束die
 */

	public function xmlParser($xmlcont){
		//创建xml解析器
		$xmlparser = xml_parser_create();
		//判断文件是否是xml文件
		$file = fopen($xmlcont,'a+');
		$xmlfile = fread($file,filesize($xmlcont));
		if(!xml_parse($xmlparser,$xmlfile,true)){
			xml_parser_free($xmlparser);
			die(Data_Common::XMLFILEERR);
		}
		return 1;
	}
}



	
