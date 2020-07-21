<?php 

$dirjsondiff = dirname(__FILE__);
require_once($dirjsondiff."/../../lib/Log.php");

//本类定义的是json文件的处不处理功能。
class JsonDiff{

	//实例化log对象
	public function __construct(){ 
		$this->logger = Logger::getInstance();   
	}

	//获取文件行数
	public function lineNoObt($fileLine){
		$lineNo = count(file($fileLine));
        		$this->logger->debug('[' . __LINE__ .']'.' file lineno obtain sucess filename :'.$fileLine, 'jsondiff'); 
		return($lineNo);
	}

	//将文件内容读出并转化到数组内。
	public function fileObt($arrName){

		//打开文件 获取文本行数
		$jsonFile = fopen($arrName,"r");
		$lineNo = $this -> lineNoObt($arrName);
        		$this->logger->debug('[' . __LINE__ .']'.' file open sucess filename :'.$arrName, 'jsondiff'); 

		//遍历文章的行数,并赋值给数组
		for($i=0 ; $i< $lineNo ; $i++){
			$jsonCont[] = fgets($jsonFile);
		}
        		$this->logger->debug('[' . __LINE__ .']'.' file change array  sucess content  :'.json_encode($jsonCont), 'jsondiff'); 
		return($jsonCont);
	}
	/**
	 * 将json内容进行对比并存储到数组内
	 * @param  [type] $arr1 [对比的左文件]
	 * @param  [type] $arr2 [对比的右文件]
	 * @return [array]       [返回的结果是一个二维数组]
	 * $demo = array(
	 * 	0 => 1 ;     行数
	 * 	1 => array(
	 * 		1 => value  key是不同的节点处    value 是不同的内容
	 * 		),
	 * 	2 => 2,
	 * 	3 => array(
	 * 	)
	 * );
	 */
	public function oneCheck($arr1,$arr2){
		foreach($arr1 as $value){ $i++; }
		foreach($arr2 as $value){ $o++; }
		//如果相等，说名在行数上面一样，不存在添加
		if ($i == $o){
			for($a = 0 ; $a< $i ;$a++){
				//判断行是否相等，如果相等，不进行下一步比较。
				if($arr1[$a] != $arr2[$a]){
					//对数组1进行处理，取出json的key value
					$arrErr = $arr1[$a]; preg_match_all('/\"(.*?)\"/',$arrErr,$ahar1); $ahar1 = $ahar1[0];
					$arrErr = $arr2[$a]; preg_match_all('/\"(.*?)\"/',$arrErr,$ahar2); $ahar2 = $ahar2[0];
					$line  = $a+1 ; //计算不同行的行数，节点数+1
					$Msg[] = $line;  //记录行数
					//获取此行数组的长度，数组长度较长的作为左边array_diff($arr1,$arr2)的$arr1
					$leng1 = count($ahar1);
					$leng2 = count($ahar2);
					if($leng1 >= $leng2){
						//获取不同的信息存储进数组，保存到数组的二维
						$Msg[] = array_diff_assoc($ahar1,$ahar2);
					}else{
						//获取不同的信息存储进数组，保存到数组的二维
						$Msg[] = array_diff_assoc($ahar2,$ahar1);
					}
				}
			}
        			$this->logger->debug('[' . __LINE__ .']'.' file diff  sucess content  :'.json_encode($Msg), 'jsondiff'); 
			return($Msg);
		}else{
			if ($i < $o ){
				$o = $i;
			}
			//对比相等的行数
			for($a = 0 ; $a< $o ;$a++){			
				//判断行是否相等，如果相等，不进行下一步比较。
				if($arr1[$a] != $arr2[$a]){
					//对数据进行处理,通过正则抽出 " " 中的单词
					$arrErr = $arr1[$a]; preg_match_all('/\"(.*?)\"/',$arrErr,$ahar1); $ahar1 = $ahar1[0];
					$arrErr = $arr2[$a]; preg_match_all('/\"(.*?)\"/',$arrErr,$ahar2); $ahar2 = $ahar2[0];
					//获取行数，并存储进数组作为行数的表示，一维表示
					$line  = $a+1  ;
					$Msg[] = $line;
					//获取此行数组的长度，数组长度较长的作为左边array_diff($arr1,$arr2)的$arr1
					$leng1 = count($ahar1);
					$leng2 = count($ahar2);
					if($leng1 >= $leng2){
						//获取不同的信息存储进数组，保存到数组的二维
						$Msg[] = array_diff_assoc($ahar1,$ahar2);
					}else{
						//获取不同的信息存储进数组，保存到数组的二维
						$Msg[] = array_diff_assoc($ahar2,$ahar1);
					}
				}
			}
        			$this->logger->debug('[' . __LINE__ .']'.' file diff  sucess content diff  :'.json_encode($Msg), 'jsondiff'); 
			return($Msg);
		}

	}

	//针对行数增加的情况进行对比
	public function lineCheck($arr1,$arr2){
		foreach($arr1 as $value){ $i++; }
		foreach($arr2 as $value){ $o++; }
		//如果行数不等，将对比过的内容释放，然后赋值给$msg
		if ($i > $o ){
			for($a = 0 ; $a < $o ;$a ++){
				unset($arr1[$a]);
			}
			$msg = $arr1;
        			$this->logger->debug('[' . __LINE__ .']'.' file diff  sucess content line diff   :'.json_encode($msg), 'jsondiff'); 
			return($msg);
		}else{
			for($a = 0 ; $a < $i ;$a ++){
				unset($arr2[$a]);
			}
			$msg = $arr2;
        			$this->logger->debug('[' . __LINE__ .']'.' file diff  sucess content line diff   :'.json_encode($msg), 'jsondiff'); 
			return($msg);
		}
	}
}













