<?php
session_start();
if(!defined('__DIR__')) {
	$iPos = strrpos(__FILE__, "/");
	define("__DIR__", substr(__FILE__, 0, $iPos) . "/");
}
//引入配置文件
include_once __DIR__.'config.php';
//引入自动载入函数
include_once __DIR__.'autoloader.php';
//调用自动载入函数
AutoLoader::register();