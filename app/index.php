<?php
define("APP_PATH",dirname(__FILE__));
define("SP_PATH",dirname(__FILE__).'/SpeedPHP');
$spConfig = array(
	'view' => array(
		'enabled' => TRUE, // 开启视图
		'config' =>array(
			'template_dir' => APP_PATH.'/tpl', // 模板目录
			'compile_dir' => APP_PATH.'/tmp', // 编译目录
			'cache_dir' => APP_PATH.'/tmp', // 缓存目录
			'left_delimiter' => '<{',  // smarty左限定符
			'right_delimiter' => '}>', // smarty右限定符
		),
	), 
	"db" => array( 					// 数据库设置
                'host' => 'localhost',  // 数据库地址，一般都可以是localhost
                'login' => 'root', // 数据库用户名
                'password' => '8641683', // 数据库密码
                'database' => 'gist', // 数据库的库名称
        ),
);
require(SP_PATH."/SpeedPHP.php");
spRun();