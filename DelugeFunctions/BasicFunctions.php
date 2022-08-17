<?php
namespace Deluge\DelugeFunctions;

use Deluge\Console;

class BasicFunctions{
	
	public function addtorrent(string $path, $torrent){
        $content = $this->delugeConsole->command('add -p ' . $path . $torrent);

        return Torrent::fromData($this->parseTorrent($content));
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
        $torrentData['size'] = convertToBytes($this->parseLine('Size: .*?/([0-9\.]+ [\w]+)', $content));
        $torrentData['down_speed'] = $this->parseLine('State: .*?Down Speed: ([0-9\.]+ [\w/]+)', $content);
        $torrentData['progress'] = (float)$this->parseLine('Progress: ([0-9\.]+)%', $content);

        $contentFiles = $this->parseLine('::Files\n(.*?)\n  ::', $content) ?? '';

        $files = [];
        foreach (explode("\n", $contentFiles) ?? [] as $contentFile){
            $files[] = [
                'file' => $this->parseLine('([^ ]+) ', $contentFile),
                'size' => convertToBytes($this->parseLine('\(([0-9\.]+ [\w]+)\)', $contentFile)),
                'progress' => (float)$this->parseLine('Progress: ([0-9\.]+)%', $contentFile),
            ];
        }

        $torrentData['files'] = $files;

        return $torrentData;
    }
	
	public static function ConvertToBytes(string $bytes, $precision = 2){ 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 

		$bytes /= pow(1024, $pow);

		return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 
	
}