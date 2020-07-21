<?php 

#本章节给出的是基本的话术

class Data_Common
{
    const PROGRAMRUN   = '运行命令 ->php diff.php -t [json|xml] -l leftFile -r rightFile -o outFile -e utf8';

    const TYPE                     = '-t ->待DIFF的数据/文件类型，测试题要求实现json/xml两种类型的DIFF功能';

    const LIFTFILE                = '-l ->待DIFF的左文件';

    const RIGHTFILE            = '-r ->待DIFF的右文件';

    const OUTFILE                = '-o ->存储对比结果的文件';

    const ENCODE                = '-e ->编码格式，支持gbk和utf-8，默认为utf-8';

    const HELPERR               = '如果要查看帮助信息，请输入: php diff.php -h';

    const VERSION                = 'version 1.0';

    const VERSIONERR        = '如果要查看版本信息，请输入：php diff.php -v';

    const JSONFILEERR       = '内容不是json格式';

    const XMLFILEERR          = '内容不是XML格式';

    const JSONQUITE           = 'json 对比完成';
    
    const XMLQUIT                = 'XML 对比完成';

}

