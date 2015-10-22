<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:22 AM
 */

spl_autoload_register(function($class)
{
	$class = str_replace('ZayconDev\\', '', $class);

	if (file_exists(__DIR__.'/'.$class.'.php'))
	{
		require_once(__DIR__.'/'.$class.'.php');
	}
});