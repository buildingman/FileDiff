<?php 

$dir = '../lib';

$hand = opendir($dir);
if($hand){
    while(($f = readdir($hand)) != false){
        if($f != '.' && $f != '..'){
            echo $f."\n";
        }
    }
}
