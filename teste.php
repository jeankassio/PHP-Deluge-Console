<?php
ini_set('log_errors', 1);
require dirname(__FILE__) . '/vendor/autoload.php';
//require dirname(__FILE__) . '/src/Console.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;
	
	$config = array(
		'host' => 'localhost',
		'user' => 'jeankassios',
		'pass' => 'a1a2a5a4',
	);
	
	$console = new Console($config);
	
	//$torrents = $console->torrentList();
	
	$torrents = (new BasicFunctions($console))->torrentList();
	
	echo '<pre>';
	
	var_dump($torrents);
	exit();
	
	foreach($torrents as $torrent){
		
		var_dump($torrent);			
		
	}
	
	exit();