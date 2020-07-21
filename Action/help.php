<?php

// 本章节定义-h的功能
$dirhelp = dirname(__FILE__);
require_once($dirhelp."/../lib/Log.php");
require_once($dirhelp."/../Data/Common.php");

class Help{

    //实例化log对象
    public function __construct(){ 
        $this->logger = Logger::getInstance();   
    }

    //-h的提示信息数组	
    private $helparr = array(
        Data_Common::VERSION,
        Data_Common::PROGRAMRUN,
        Data_Common::TYPE,
        Data_Common::LIFTFILE,
        Data_Common::RIGHTFILE,
        Data_Common::OUTFILE,
        Data_Common::ENCODE,
        );

    //-h的错误信息数组	
    private $helperr  = array(
        Data_Common::HELPERR
        );

    //-v的提示信息数组
    private $versionarr  = array(
        Data_Common::VERSION,
        );

    //-v的错误信息数组
    private $versionerr = array(
        Data_Common::VERSIONERR
        );

    //如果第一个参数为-h，则提示信息，不考虑后面的参数
    public function hCheck($param1)
    {
        if($param1 == '-h')
        {
            echo "--help\n\n";
            foreach($this->helparr as $value)
            {
                echo $value."\n\n";
            }
            $this->logger->debug('[' . __LINE__ .']'.' Instructions for use success :'.$param1, 'help'); 
            die();
        }
    }

    //-v如果第一个参数为-v则提示信息
    public function vCheck($param1)
    {
        if($param1 == '-v')
        {
            foreach($this->versionarr as $value)
            {
                echo $value."\n\n";
            }
            $this->logger->debug('[' . __LINE__ .']'.' version for use  success:'.$param1, 'help'); 
            die();
        }
    }
}



