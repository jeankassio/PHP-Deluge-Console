<?php
namespace JeanKassio\Deluge\DelugeFunctions;

use JeanKassio\Deluge\Console;
use JeanKassio\Deluge\DelugeFunctions\Torrent;

class BasicFunctions{
	
	protected $delugeConsole;

    public function __construct(Console $delugeConsole)
    {
        $this->delugeConsole = $delugeConsole;
    }
	
	
	public function console(string $command){
        $content = $this->delugeConsole->command($command);

        return $content;
    }
	
	public function resume(bool $all, $torrents = array()){
        $content = $this->delugeConsole->command("resume ". ($all ? "[*]" : preg_replace('/[\["]|[\]]/i', "", str_replace(",", " ", json_encode($torrents)))));

        return $content;
    }
	
	public function recheck(bool $all, $torrents = array()){
        $content = $this->delugeConsole->command("recheck ". ($all ? "*" : preg_replace('/[\["]|[\]]/i', "", str_replace(",", " ", json_encode($torrents)))));

        return $content;
    }
	
	public function pause(bool $all, $torrents = array()){
        $content = $this->delugeConsole->command("pause ". ($all ? "[*]" : preg_replace('/[\["]|[\]]/i', "", str_replace(",", " ", json_encode($torrents)))));

        return $content;
    }
	
	public function remove($torrents, bool $data = NULL){
        $content = $this->delugeConsole->command("rm ". preg_replace('/[\["]|[\]]/i', "", str_replace(",", " ", json_encode($torrents))) . " " . ($data ? "--remove_data" : ""));

        return $content;
    }
	
	public function addtorrent(string $path, string $torrent){
        $content = $this->delugeConsole->command("add -p '" . $path . "' " . $torrent);

        return $content;
    }
	
	public function parseInfo(string $content){
        $torrents = [];
        $lines = explode("\n \n", $content);

        foreach ($lines ?? [] as $lineTorrent){
            $torrents[] = Torrent::fromData($this->parseTorrent($lineTorrent));
        }

        return $torrents;
    }
	
	public function torrentList(){
        $content = $this->delugeConsole->command('info -v');
        $torrents = [];
        $lines = explode("\n \n", $content);

        foreach ($lines ?? [] as $lineTorrent){
            $torrents[] = Torrent::fromData($this->parseTorrent($lineTorrent));
        }

        return $torrents;
    }
	
    public function torrent(string $torrentId){
        $content = $this->delugeConsole->command('info -v ' . $torrentId);

        return Torrent::fromData($this->parseTorrent($content));
    }
	
	protected function parseLine($pattern, $content){
        $pattern = str_replace('/', '\/', $pattern);

        preg_match('/' . $pattern . '/iums', $content, $row);

        return $row[1] ?? null;
    }
	
    protected function parseTorrent($content){
        $torrentData = [];

        $torrentData['name'] = $this->parseLine('Name: ([^\n]+)', $content);
        $torrentData['torrent_id'] = $this->parseLine('ID: ([^\n]+)', $content);
        $torrentData['state'] = $this->parseLine('State: (\w+)', $content);
        $torrentData['eta'] = $this->parseLine('State: .*?ETA: ([^\n]+)', $content);
        $torrentData['size'] = $this->convertToBytes($this->parseLine('Size: .*?/([0-9\.]+ [\w]+)', $content));
        $torrentData['down_speed'] = $this->parseLine('State: .*?Down Speed: ([0-9\.]+ [\w/]+)', $content);
        $torrentData['progress'] = (float)$this->parseLine('Progress: ([0-9\.]+)%', $content);

        $contentFiles = $this->parseLine('::Files\n(.*?)\n  ::', $content) ?? '';

        $files = [];
        foreach (explode("\n", $contentFiles) ?? [] as $contentFile){
            $files[] = [
                'file' => $this->parseLine('([^ ]+) ', $contentFile),
                'size' => $this->convertToBytes($this->parseLine('\(([0-9\.]+ [\w]+)\)', $contentFile)),
                'progress' => (float)$this->parseLine('Progress: ([0-9\.]+)%', $contentFile),
            ];
        }

        $torrentData['files'] = $files;

        return $torrentData;
    }
	
	public function convertToBytes($from){
        $units = ['Byte', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];

        $data = explode(' ', $from);

        $number = (float) $data[0] ?? 0;
        $suffix = $data[1] ?? null;

        $exponent = array_flip($units)[$suffix] ?? null;
        if ($exponent === null) {
            return null;
        }

		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

		$bytes = $number * (1024 ** $exponent); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 

		$bytes /= (1 << (10 * $pow)); 

		return (round($bytes, 2) . ' ' . $units[$pow]); 
		
		
    }
	
}