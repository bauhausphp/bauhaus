<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita3c2b383aed752996c0c273010af220c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'B' => 
        array (
            'Bauhaus\\Types\\Uri\\' => 18,
            'Bauhaus\\Types\\' => 14,
            'Bauhaus\\Tests\\' => 14,
            'Bauhaus\\ServiceResolver\\' => 24,
            'Bauhaus\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Bauhaus\\Types\\Uri\\' => 
        array (
            0 => __DIR__ . '/..' . '/bauhaus/type-uri/private',
        ),
        'Bauhaus\\Types\\' => 
        array (
            0 => __DIR__ . '/..' . '/bauhaus/type-uri/public',
        ),
        'Bauhaus\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Bauhaus\\ServiceResolver\\' => 
        array (
            0 => __DIR__ . '/..' . '/bauhaus/service-resolver/private',
        ),
        'Bauhaus\\' => 
        array (
            0 => __DIR__ . '/..' . '/bauhaus/service-resolver/public',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita3c2b383aed752996c0c273010af220c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita3c2b383aed752996c0c273010af220c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita3c2b383aed752996c0c273010af220c::$classMap;

        }, null, ClassLoader::class);
    }
}