<?php

//default autoload
//spl_autoload_register();
//$writer = new classes\Writer();

//custom autoload
function myAutoload($className){
    if(file_exists($file = str_replace(['/','\\','_'],DIRECTORY_SEPARATOR,__DIR__.'/'.$className.'.php'))){
        require_once ($file);
    }
}

spl_autoload_register('myAutoload');

$writer = new classes\User();
