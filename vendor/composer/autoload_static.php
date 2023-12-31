<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitadf53f5b9a812ddd3bad863663667059
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'myframework\\' => 12,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'myframework\\' => 
        array (
            0 => __DIR__ . '/..' . '/myframework',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitadf53f5b9a812ddd3bad863663667059::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitadf53f5b9a812ddd3bad863663667059::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitadf53f5b9a812ddd3bad863663667059::$classMap;

        }, null, ClassLoader::class);
    }
}
