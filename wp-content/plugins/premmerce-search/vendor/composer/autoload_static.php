<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc5c7510f67bb69008570bb91bae68b0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Premmerce\\Search\\' => 17,
            'Premmerce\\SDK\\' => 14,
        ),
        'B' => 
        array (
            'Behat\\Transliterator\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Premmerce\\Search\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Premmerce\\SDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/premmerce/wordpress-sdk/src',
        ),
        'Behat\\Transliterator\\' => 
        array (
            0 => __DIR__ . '/..' . '/behat/transliterator/src/Behat/Transliterator',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc5c7510f67bb69008570bb91bae68b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc5c7510f67bb69008570bb91bae68b0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdc5c7510f67bb69008570bb91bae68b0::$classMap;

        }, null, ClassLoader::class);
    }
}
