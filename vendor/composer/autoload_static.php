<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit73d8f9562343a2472b2ea91ed8be5248
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'GraphQL\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'GraphQL\\' => 
        array (
            0 => __DIR__ . '/..' . '/webonyx/graphql-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit73d8f9562343a2472b2ea91ed8be5248::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit73d8f9562343a2472b2ea91ed8be5248::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit73d8f9562343a2472b2ea91ed8be5248::$classMap;

        }, null, ClassLoader::class);
    }
}
