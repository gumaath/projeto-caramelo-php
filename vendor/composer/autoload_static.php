<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit42ce0e0210f5c932846899975a5ed41e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/php',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit42ce0e0210f5c932846899975a5ed41e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit42ce0e0210f5c932846899975a5ed41e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit42ce0e0210f5c932846899975a5ed41e::$classMap;

        }, null, ClassLoader::class);
    }
}
