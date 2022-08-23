# PHP-Deluge-Console
Connection to Deluge-Torrent client/server console via PHP, with pre-established functions and open console to send commands.

[![Total Downloads](https://poser.pugx.org/jeankassio/php-deluge-console/downloads)](https://packagist.org/packages/jeankassio/php-deluge-console)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Php package from [deluge console](https://dev.deluge-torrent.org/wiki/UserGuide/ThinClient#Console)

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
	'console_command' => 'deluge-console', 	//optional, default is 'deluge-console'
	'host' => 'localhost',  		//optional, default is 'localhost'
	'port' => '58846',  			//optional, default is '58846'
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
Here I am finally submitting the information and adding the torrent to Deluge
*/

$response = (new BasicFunctions($console))->addtorrent($path, $c_torrent);
 
```

# Other existing methods

Get torrent list

```php

require dirname(__FILE__) . '/vendor/autoload.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;

$config = array(
	'console_command' => 'deluge-console', 	//optional, default is 'deluge-console'
	'host' => 'localhost',  		//optional, default is 'localhost'
	'port' => '58846',  			//optional, default is '58846'
	'user' => 'username',
	'pass' => 'password',
);

$console = new Console($config);

$torrents = (new BasicFunctions($console))->torrentList();

foreach($torrents as $torrent){

	var_dump($torrent);			

}

```

Get a single Torrent

```php

require dirname(__FILE__) . '/vendor/autoload.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;

$config = array(
	'console_command' => 'deluge-console', 	//optional, default is 'deluge-console'
	'host' => 'localhost',  		//optional, default is 'localhost'
	'port' => '58846',  			//optional, default is '58846'
	'user' => 'username',
	'pass' => 'password',
);

$console = new Console($config);

$torrent_id = "9c62d55c744642ef3f6f6daa3448055fb490a12e";

$torrent = (new BasicFunctions($console))->torrent($torrent_id);

var_dump($torrent);

```

Console, to make your own calls

```php

require dirname(__FILE__) . '/vendor/autoload.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;

$config = array(
	'console_command' => 'deluge-console', 	//optional, default is 'deluge-console'
	'host' => 'localhost',  		//optional, default is 'localhost'
	'port' => '58846',  			//optional, default is '58846'
	'user' => 'username',
	'pass' => 'password',
);

$console = new Console($config);

$command = "status";

$response = (new BasicFunctions($console))->console($command);

var_dump($response);

```

# New Methods
All these functions always return null

```php

require dirname(__FILE__) . '/vendor/autoload.php';

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\BasicFunctions;

$config = array(
	'console_command' => 'deluge-console', 	//optional, default is 'deluge-console'
	'host' => 'localhost',  		//optional, default is 'localhost'
	'port' => '58846',  			//optional, default is '58846'
	'user' => 'username',
	'pass' => 'password',
);

$console = new Console($config);

$bFunction = new BasicFunctions($console);


$bFunction->pause(true); //Pause all torrents

$bFunction->pause(false, array("9c62d55c744642ef3f6f6daa3448055fb490a12e","57a30a85b4a8375fc7a05a05c5f47e28b34da087")); //Pause only torrents listed with your ID



$bFunction->recheck(true); //Recheck on all torrents

$bFunction->recheck(false, array("9c62d55c744642ef3f6f6daa3448055fb490a12e","57a30a85b4a8375fc7a05a05c5f47e28b34da087")); //Recheck only on torrents listed with your ID



$bFunction->resume(true); //Resume all torrents

$bFunction->resume(false, array("9c62d55c744642ef3f6f6daa3448055fb490a12e","57a30a85b4a8375fc7a05a05c5f47e28b34da087")); //Resume only torrents listed with your ID



$bFunction->remove(array("9c62d55c744642ef3f6f6daa3448055fb490a12e","57a30a85b4a8375fc7a05a05c5f47e28b34da087")); //Delete the torrent without deleting the files

$bFunction->remove(array("9c62d55c744642ef3f6f6daa3448055fb490a12e","57a30a85b4a8375fc7a05a05c5f47e28b34da087"), true); //Delete the torrent and the files





```


Package modification of [deluge-php](https://github.com/NEOSoftWare/deluge-php)
