<?php 
require_once APPPATH.'/config/common.config.php'; // Common configuration
require_once APPPATH.'/config/db.config.php'; // Database configuration
require_once APPPATH.'/config/i18n.config.php'; // i18n configuration

// ASCII Secure random crypto key
define("CRYPTO_KEY", "def00000fac32eb6bbde786c6a9012e80fa51f8ef575befdd680d7ff193537af7a0b42731da8e5d6e35053712336e4371ff6ebb80e8d7cc4de197c6b6f27d3b0d10204b1");

// General purpose salt
define("NP_SALT", "v7AdABlMBP5YKOw5");


// Path to instagram sessions directory
define("SESSIONS_PATH", APPPATH . "/sessions");
// Path to temporary files directory
define("TEMP_PATH", ROOTPATH . "/assets/uploads/temp");


// Path to themes directory
define("THEMES_PATH", ROOTPATH . "/inc/themes");
// URI of themes directory
define("THEMES_URL", APPURL . "/inc/themes");


// Path to plugins directory
define("PLUGINS_PATH", ROOTPATH . "/inc/plugins");
// URI of plugins directory
define("PLUGINS_URL", APPURL . "/inc/plugins");

// Path to ffmpeg binary executable
// NULL means it's been installed on global path
// If you set the value other than null, then it will only be 
// validated during posting the videos
define("FFMPEGBIN", NULL);

// Path to ffprobe binary executable
// NULL means it's been installed on global path
// If you set the value other than null, then it will only be 
// validated during posting the videos
define("FFPROBEBIN", NULL);
