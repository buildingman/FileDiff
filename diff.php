<?php
/**
* Created by sublime
* User : lizhi
* time : 05/09/2018
 */

//功能的入口
$dir = dirname(__FILE__);
require_once($dir."/Action/paramCheck.php");
require_once($dir."/lib/Log.php");
require_once($dir."/lib/file.php");
require_once($dir."/Action/help.php");
require_once($dir."/Action/xmlout.php");
require_once($dir."/Action/output.php");
require_once($dir."/Action/filecheck.php");
require_once($dir."/Data/Common.php");
require_once($dir."/Action/diff/jsondiff.php");
require_once($dir."/Action/diff/xmldiff.php");
require_once($dir."/Action/encode.php");

$test1 = new Filehandle();
$file = $test1->fileContent("product_relation_bi.txt");
$test = new encodeSet();
$test ->codeChange($file,'gbk');
die();

//获取参数数组,第二个参数提出判断参数，h ，v
$paramArr = $argv;
$hvparamArr = $paramArr[1];

//判断首个参数是否满足要求
$hChecker = new Help();

//判断-h -v
if($hvparamArr == '-h'){
	$hChecker->hCheck($hvparamArr);
}elseif($hvparamArr == '-v'){
	$hChecker->vCheck($hvparamArr);
}

/**
 * 判断参数是否正确，如果正确整理数据
 * 数据格式 demo $arrdiff
 * [-t] => xml
 * [-l] => lift
 * [-r] => right
 * [-o] => lujing
 * [-e] => gbk
 */
$pchecker = new ParamCheck();
$arrdiff = $pchecker->arrCheck($paramArr);

//判断文件类型是xml 还是 json
if($arrdiff['-t'] == 'json'){
	//调用json格式校验方法
	$jsonchecker = new FileCheck();
	if($jsonchecker ->JsonCheck($arrdiff['-l']) != 1 or $jsonchecker ->JsonCheck($arrdiff['-r']) !=1){
		echo Data_Common::JSONFILEERR."\n";
	}
}else{
	//调用XML格式校验方法
	$xmlchecker = new FileCheck();
	if($xmlchecker ->xmlParser($arrdiff['-l']) != 1 or $xmlchecker ->xmlParser($arrdiff['-r']) !=1){
		echo Data_Common::JSONFILEERR."\n";
	}
}

//检查要存储的目标路径是否存在，如果存在，将原文件删除。
$outfile = new saveContent();
$outfile -> checkFile($arrdiff['-o']);
//创建编码校验对象以及文本获取对象
$codechang = new encodeSet();
$fileobt = new Filehandle();
//获取左右文件内容
$filelift = $fileobt -> fileContent($arrdiff['-l']);
$fileright = $fileobt -> fileContent($arrdiff['-r']);
//判断编码类型并进行转换，文件内容，期望编码
$filelift = $codechang -> codeChange($filelift,$arrdiff['-e']);
$fileright = $codechang -> codeChange($fileright,$arrdiff['-e']);

//判断文件类型来调用对应的方法
if($arrdiff['-t'] == 'xml'){
	$xmlhandle = new XmlDiff();
	//读取文件转化数组
	$xmlfilelift = $xmlhandle-> xmlArr($arrdiff['-l']);
	$xmlfileright = $xmlhandle-> xmlArr($arrdiff['-r']);
	//数组一维化
	$liftcheck = $xmlhandle->xmlArrHandle2($xmlfilelift);
	$rightcheck = $xmlhandle->xmlArrHandle2($xmlfileright);
	print_r($liftcheck);
	print_r($rightcheck);
	//对比两个数组的不同处,统计不同的点数
	$xmldiff = $xmlhandle->xmlDiffArr($liftcheck,$rightcheck);
	//通过节点来获取对应文件内的值
	$xmldifflift = $xmlhandle->diffArrCont($xmldiff,$liftcheck);
	$xmldiffright = $xmlhandle->diffArrCont($xmldiff,$rightcheck);
	//实例化输出对象
	$xmlfileout = new XmlOut();
	$diffLineArr = $xmlfileout->xmlPush($xmldiff,$xmldifflift,$xmldiffright);
	//调用保存方法
	foreach($diffLineArr as $value){
	$outfile -> saveCont($arrdiff['-o'],$value);
	}
	die(Data_Common::XMLQUIT);
}

/** 实例化json对比的对象 ,  进行对应输出，应该抽离出来的通用的，但是由于比人最初的设计不全，凑活吧，以后再进行修改吧 */
$difftest = new JsonDiff();
//定义内容不同储存的数组。
$diffContArr = array();
//定义新增行的数组。
$diffLineArr = array();
//获取数据
$arr1 = $difftest -> fileObt($arrdiff['-l']);
$arr2 = $difftest -> fileObt($arrdiff['-r']);
//对比文件1和文件2的不同
 $diffcont = $difftest -> oneCheck($arr1,$arr2);
 //计算存在不同的数量
 foreach($diffcont as $value){
 	if(is_array($value)){
 		foreach($value as $v){
 			$a1++;
 		}
 	}
 }
//获取文件的行数，计算是否存在新增
$lineadd1 = $difftest -> lineNoObt($arrdiff['-l']);
$lineadd2 = $difftest -> lineNoObt($arrdiff['-r']);
//新增行的不同处统计
if ($lineadd1 > $lineadd2){
	$i = $lineadd1 - $lineadd2;
}else{
	$i = $lineadd2 - $lineadd1;
}
//计算总共有几处不同
$count = $i + $a1;
$diffContArr[] = "+++++++++++++共有"."$count"."处不同++++++++++++++\n";
$diffContArr[] = "+++++++++每个单词作为一个节点++++++++++++++\n\n";
//输出行数相同的不同之处。
foreach($diffcont as $key1 => $value1){
	if(!is_array($value1)){
		$diffContArr[] = "第".$value1."行的不同处\n\n";
		//处理数据一维化
		$n = $value1 - 1;
		preg_match_all('/\"(.*?)\"/',$arr1[$n],$ahar1);
		$ahar1 = $ahar1[0];
		preg_match_all('/\"(.*?)\"/',$arr2[$n],$ahar2);
		$ahar2 = $ahar2[0];
	}else{
		foreach($value1 as $key2 => $value2 ){
			$diffContArr[] = "节点".$key2."\n"."--------------------------------------\n";
			$diffContArr[] = "左文件："."$ahar1[$key2]"."\n";
			$diffContArr[] = "右文件："."$ahar2[$key2]"."\n\n";
		}
	}
}
//将文件逐行输入到指定文件
foreach($diffContArr as $value){
	$outfile -> saveCont($arrdiff['-o'],$value);
}
//输出行数不同的结果
if($lineadd1 == $lineadd2){
	return;
}elseif($lineadd1 > $lineadd2){
	$diffLineArr[] =  "左文件存在新增行".$i."行\n\n";
	$diffLineArr[] = "+++++++++++++新增行开始++++++++++++++\n";
	$msg = $difftest -> lineCheck($arr1,$arr2);
	foreach($msg as $key =>$value ){
		$diffLineArr[] = "\n";
		$diffLineArr[] = "左文件:节点".$key."=>".$value."\n";
	}
	$diffLineArr[] = "+++++++++++++新增行结束++++++++++++++\n";
}else{
	$diffLineArr[] = "右文件存在新增行".$i."行\n\n";
	$diffLineArr[] = "+++++++++++++新增行开始++++++++++++++\n";
	$msg = $difftest -> lineCheck($arr1,$arr2);
	foreach($msg as $key => $value ){
		$diffLineArr[] = "\n";
		$diffLineArr[] = "右文件:节点".$key."=>".$value."\n";
	}
	$diffLineArr[] = "+++++++++++++新增行结束++++++++++++++\n";
}
//将文件逐行输入到指定文件
foreach($diffLineArr as $value){
	$outfile -> saveCont($arrdiff['-o'],$value);
}
die(Data_Common::JSONQUITE);








