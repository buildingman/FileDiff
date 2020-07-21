<?php 
/**
 * 按照日志的条数来处理，读取对应的子弹内容
 * 公共类
 * 李志
 */
require_once("../Action/output.php");

class FetchLog{

	public $runner;
	public function __construct(){
		return $this->runner = new saveContent();
	}
	/**
	 * 处理文件夹，遍历里面的文件
	 * 调用处理函数读取文件内的日志信息
	 */
	public function fetchContent($name){
		if(is_dir($name)){
			///如果是文件夹，遍历文件名之后递归
			$handler = opendir($name);
			if($handler){
				while(($dir = readdir($handler)) != false){
					if($dir != '.' && $dir != '..'){
						$this->fileCatch($dir);
					}
				}
			}
		}

		$this->fileCatch($name);
		return;
	}

	/**
	 * 读取文件内的内容，行作为基本单位
	 * @param  [string] $name [文件名]
	 * @return 调用保存方法
	 */
	public function fileCatch($name){
		if(!is_dir($name)){
			$shell = "tail -f $name";
			system($shell , $array);
			echo 1;
			echo 1;
			while(true){
				$cont = fgets($file);
				if($cont){
					$this->runner->saveCont('lizhi.txt',$file);
				}
			}
		}
	}

	/**
	 * 转化json数据，提取里面的内容。
	 */
	public function contentJson(){

	}

	/**
	 * 通过循环来重复运行
	 */
	public function loopRun(){

	}
}

$dir = '../log/file.log';
$test = new FetchLog();
$test->fetchContent($dir);
