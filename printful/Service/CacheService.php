<?php

namespace Printful\Service;

use CacheInterface;

class CacheService implements CacheInterface
{
    private const CACHE_DIR = __DIR__ . '/../../cache';
    private const CACHE_DIR_CONTENT = self::CACHE_DIR . '/';

    public function set(string $key, $value, int $duration)
    {
        if (! file_exists(self::CACHE_DIR) || ! is_dir(self::CACHE_DIR)) {
            mkdir(self::CACHE_DIR);
        }

        $expirationMicrotime = (int) (microtime(true) + $duration);
        $cacheFile = self::CACHE_DIR_CONTENT . $key . '-' . $expirationMicrotime;
        $cachedAll = glob(self::CACHE_DIR_CONTENT . $key . '-*');

        foreach ($cachedAll as $cached) {
            $filename = pathinfo($cached, PATHINFO_FILENAME);
            $explodedCached = explode('-', $filename);
            array_pop($explodedCached);
            $cachedKey = pathinfo(implode('-', $explodedCached), PATHINFO_FILENAME);

            if ($cachedKey === $key) {
                unlink($cached);
            }
        }

        file_put_contents($cacheFile, $value);

        return $value;
    }

    public function get(string $key)
    {
        $cachedAll = glob(self::CACHE_DIR_CONTENT . $key . '-*');

        foreach ($cachedAll as $cached) {
            $filename = pathinfo($cached, PATHINFO_FILENAME);
            $explodedCached = explode('-', $filename);
            $microtime = (int) array_pop($explodedCached);
            $cachedKey = pathinfo(implode('-', $explodedCached), PATHINFO_FILENAME);

            if ($cachedKey !== $key) {
                continue;
            }

            if ($microtime > microtime(true)) {
                return file_get_contents($cached);
            }

            unlink($cached);
        }

        return null;
    }
}