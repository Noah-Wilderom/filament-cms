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

if(! function_exists('getField')) {
    function getField(string $name, string $modelId = null) {
        $field = app(\NoahWilderom\FilamentCMS\Contracts\FilamentCMSField::class)
            ->where('name', $name)
            ->first();

        if(is_null($modelId)) {
            return $field?->values()->whereNull('model_id')->first()?->toValue();
        }

        return $field?->values()->where('model_id', $modelId)->first()->toValue();
    }
}

if (! function_exists('getPosts')) {
    function getPosts(array $args = [], int $limit = -1): \NoahWilderom\FilamentCMS\Collections\PostCollection {
        return app(\NoahWilderom\FilamentCMS\Contracts\FilamentCMSPost::class)
            ->published()
            ->limit($limit)
            ->withArgs($args)
            ->get();
    }
}