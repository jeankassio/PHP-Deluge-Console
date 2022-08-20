# PHP-Deluge-Console
Connection to Deluge client/server console via PHP, with pre-established functions and open console to send commands.

[![Total Downloads](https://poser.pugx.org/jeankassio/php-deluge-console/downloads)](https://packagist.org/packages/jeankassio/php-deluge-console)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)


Installation:
```bash
 composer require jeankassio/php-deluge-console
```

How to use:

```php
require dirname(__FILE__) . '/vendor/autoload.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;
 
 /*
 Here you configure the connection settings.
 */
 
 $config = array(
		'console_command' => 'deluge-console', 		//optional, default is 'deluge-console'
		'host' => 'localhost',  					//optional, default is 'localhost'
		'port' => '58846',  						//optional, default is '58846'
		'user' => 'username',
		'pass' => 'password',
	);
  
  /*
  Instancing a new Console
  */
  
  $console = new Console($config);
  
  /*
  Here you call the method you want.
  Let's in this example add a new torrent.
  */
  
  /*
  The first parameter is the Path where the file we are going to download will be saved.
  The second parameter is the Magnet Link or the location where the .torrent file is stored.
  */
  
  $id = 0; //Get id value from something
  $id++;
  $name = "file.torrent";
	$c_torrent = dirname(__FILE__, 2) . "/content/torrent/$name";
	$path = dirname(__FILE__, 2) . "/content/download/$id/";
		
	if (!file_exists($path)) {
	  mkdir($path, 0777, true); //Here I am creating a directory to save my file
	  chmod($path, 0777);       //Here I am setting the permissions to 777, this is the permission level that Deluge needs so that the download can start normally.
	}
  
  /*
  
  */
  
  $torrents = (new BasicFunctions($console))->addtorrent($path, $c_torrent);
 
```
