<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit32e99d71a66985f9be28f7e02c589e56
{
    public static $files = array (
        '547f39254e5312c66b30c9b6a7d3570f' => __DIR__ . '/..' . '/eleirbag89/telegrambotphp/Telegram.php',
        '221a7c0887f892e44dd08191321d3815' => __DIR__ . '/..' . '/eleirbag89/telegrambotphp/TelegramErrorLogger.php',
    );

    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'dgr\\nohup\\' => 10,
        ),
        'L' => 
        array (
            'LanguageDetection\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'dgr\\nohup\\' => 
        array (
            0 => __DIR__ . '/..' . '/dgr/nohup/src',
        ),
        'LanguageDetection\\' => 
        array (
            0 => __DIR__ . '/..' . '/patrickschur/language-detection/src/LanguageDetection',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit32e99d71a66985f9be28f7e02c589e56::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit32e99d71a66985f9be28f7e02c589e56::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}