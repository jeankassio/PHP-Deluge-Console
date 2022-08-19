<?php

namespace JeanKassio\Deluge\DelugeFunctions;

/**
 * Class Torrent
 * @package NEOSoftWare\Deluge\Type
 *
 * @property string $name
 * @property string $torrent_id
 * @property string $state
 * @property string $eta
 * @property int $size
 * @property string $down_speed
 * @property float $progress
 * @property TorrentFile[] $files
 */
class Torrent extends BaseType
{
    public const STATE_ACTIVE = 'Active';
    public const STATE_ALLOCATING = 'Allocating';
    public const STATE_CHECKING = 'Checking';
    public const STATE_DOWNLOADING = 'Downloading';
    public const STATE_SEEDING = 'Seeding';
    public const STATE_PAUSED = 'Paused';
    public const STATE_ERROR = 'Error';
    public const STATE_QUEUED = 'Queued';

    /**
     * @var array
     */
    protected static $types = [
        'files' => [TorrentFile::class],
    ];
}
