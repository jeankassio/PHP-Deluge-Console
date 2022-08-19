<?php

namespace JeanKassio\Deluge\DelugeFunctions;

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

    protected static $types = [
        'files' => [TorrentFile::class],
    ];
}
