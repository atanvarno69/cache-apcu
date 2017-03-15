<?php
/**
 * @package   Atanvarno\Cache-APCu
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atanvarno\Cache\Apcu;

/** Parent package use block. */
use Atanvarno\Cache\Driver;

class APCuDriver implements Driver
{
    public function get(string $key, $default = null)
    {
        $success = false;
        $return = apcu_fetch($key, $success);
        if (!$success) {
            return $default;
        }
        return $return;
    }

    public function set(string $key, $value, int $ttl = null): bool
    {
        return apcu_store($key, $value, $ttl ?? 0);
    }

    public function delete(string $key): bool
    {
        return apcu_delete($key);
    }

    public function clear(): bool
    {
        return apcu_clear_cache();
    }

    public function has(string $key): bool
    {
        return apcu_exists($key);
    }
}
