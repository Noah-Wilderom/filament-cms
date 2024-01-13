<?php

use NoahWilderom\FilamentCMS\Providers\FilamentCMSServiceProvider;

if (! function_exists('getVersionMajor')) {
    function getVersionMajor() {
        $versionParts = explode('.', FilamentCMSServiceProvider::$version);
        return isset($versionParts[0]) ? (int)$versionParts[0] : 0;
    }
}

if (! function_exists('getVersionMinor')) {
    function getVersionMinor() {
        $versionParts = explode('.', FilamentCMSServiceProvider::$version);
        return isset($versionParts[1]) ? (int)$versionParts[1] : 0;
    }
}

if (! function_exists('getVersionPatch')) {
    function getVersionPatch() {
        $versionParts = explode('.', FilamentCMSServiceProvider::$version);
        return isset($versionParts[2]) ? (int)$versionParts[2] : 0;
    }
}