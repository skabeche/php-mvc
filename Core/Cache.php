<?php

namespace Core;

use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

/**
 * Caching system.
 * 
 * Use Phpfastcache
 * @see https://www.phpfastcache.com/
 * @see https://github.com/PHPSocialNetwork/phpfastcache
 */
class Cache {
  private $cacheFolderPath = '';
  private static $cachedInstance;
  private static $tag = 'php-mvc';

  public function __construct() {
    $this->cacheFolderPath = __DIR__ . '/../cache';
    self::setFilePath();
  }

  /**
   * Check if cache is enabled from config file.
   */
  private static function isEnabled(): bool {
    if ($_ENV['ENABLE_CACHE'] == 'false') {
      return false;
    }

    return true;
  }

  public function setFilePath(): mixed {
    // Setup File Path on config files.
    return CacheManager::setDefaultConfig(new ConfigurationOption([
      "path" => $this->cacheFolderPath,
      "itemDetailedDate" => false
    ]));
  }

  private function createInstance(): mixed {
    if (empty(self::$cachedInstance)) {
      self::$cachedInstance = CacheManager::getInstance('files');
    }

    return self::$cachedInstance;
  }

  public static function setKey(string $keyName): string {
    // @todo Something more sofisticated.
    return $keyName;
  }

  public function getCachedItem(string $keyName): mixed {
    $instanceCache = $this->createInstance();
    $cachedItem = $instanceCache->getItem($keyName);

    return $cachedItem;
  }

  public function isCached(string $keyName): bool {
    // Disabe cache as set in config.
    if (self::isEnabled() == false) {
      return false;
    }

    $key = self::setKey($keyName);
    $cachedItem = $this->getCachedItem($key);

    // It is cached.
    if ($cachedItem->isHit()) {
      // d('Cache hit', $keyName);
      return true;
    }

    // d('Cache NO hit', $keyName);
    return false;
  }

  public function get(string $keyName): mixed {
    $key = self::setKey($keyName);
    $cachedItem = $this->getCachedItem($key);

    return $cachedItem->get();
  }

  /**
   * Create cache for a given item.
   * 
   * @param array $item
   *   Item to be cached.
   * @param string $keyName
   *   Keyword of the cached element.
   * @param int $ttl
   *   (optional) Time-to-live, expiration time in seconds.
   *   Defaults to 900 (15min).
   */
  public function set($item, $keyName, $ttl = 900): void {
    $key = self::setKey($keyName);
    $instanceCache = $this->createInstance();
    $cachedItem = $this->getCachedItem($key);

    $cachedItem->addTag(self::$tag);
    $cachedItem->set($item)->expiresAfter($ttl);
    $instanceCache->save($cachedItem);
  }

  /**
   * Remove everything from the cache.
   */
  public function clearAll(): void {
    $instanceCache = $this->createInstance();
    $instanceCache->clear();
  }

  /**
   * Delete item from the cache specifiying the key.
   * 
   * @param string $key
   *   Keyword of the cached element.
   */
  public function deleteItemByKey($key): void {
    $instanceCache = $this->createInstance();
    $instanceCache->deleteItem($key);
  }

  /**
   * Delete multiple items from the cache specifiying the key.
   * 
   * @param array $keys
   *   Keywords of the cached elements intended to be deleted.
   */
  public function deleteItemsByKey($keys): void {
    $instanceCache = $this->createInstance();
    $instanceCache->deleteItems($keys);
  }

  /**
   * Get all keys stored in cache.
   * 
   * @see https://github.com/PHPSocialNetwork/phpfastcache/wiki/%5BV5%CB%96%5D-Fetching-all-keys
   */
  public function getAllKeys(): array {
    $instanceCache = $this->createInstance();

    // Get the items by a specific tag.
    $keys = $instanceCache->getItemsByTag(self::$tag);
    $output = array();
    foreach ($keys as $index => $key) {
      $output[$index] = $key->get();
    }

    return $output;
  }
}
