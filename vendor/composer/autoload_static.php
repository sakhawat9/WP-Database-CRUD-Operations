<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3bc756cedebb41727302de5f796873b6
{
    public static $files = array (
        '4781eac0c23ed5c4fe544231943c05f7' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fixolab\\WpDatabaseCrudOperations\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fixolab\\WpDatabaseCrudOperations\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3bc756cedebb41727302de5f796873b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3bc756cedebb41727302de5f796873b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3bc756cedebb41727302de5f796873b6::$classMap;

        }, null, ClassLoader::class);
    }
}
