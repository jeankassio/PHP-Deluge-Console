<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4ead60b9a458342fae7d623b52bf94f0
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JeanKassio\\Deluge\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JeanKassio\\Deluge\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4ead60b9a458342fae7d623b52bf94f0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4ead60b9a458342fae7d623b52bf94f0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4ead60b9a458342fae7d623b52bf94f0::$classMap;

        }, null, ClassLoader::class);
    }
}