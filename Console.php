<?php
namespace Deluge;

use DelugeFunctions\BasicFunctions;
use DelugeException\ExceptionConsole;

class Console{
	
    protected $consoleCommand;

    protected $host;

    protected $port;

    protected $user;

    protected $pass;
	
	public function __construct($config){
        
		$this->consoleCommand = $config['console_command'] ?? 'deluge-console';
        $this->host = $config['host'] ?? 'localhost';
        $this->port = $config['port'] ?? 58846;
        $this->user = $config['user'] ?? '';
        $this->pass = $config['pass'] ?? '';
		
    }
	
	public function command($str){
		
        $str = str_replace('"', '', $str);

        $line = shell_exec("{$this->consoleCommand} \" connect {$this->host}:{$this->port} {$this->user} {$this->pass}; $str; exit;\"");

        if (strpos($line, 'Failed to connect') !== false){
            throw new ExceptionConsole($line);
        }

        return $line;
    }
	
}