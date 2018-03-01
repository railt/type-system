<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Routing;

use Railt\Routing\Contracts\RegistryInterface;

/**
 * Class DataResolver
 */
class Registry implements RegistryInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $key
     * @param $data
     * @return void
     */
    public function set(string $key, $data): void
    {
        if ($data instanceof \Generator) {
            $data = \iterator_to_array($data);
        }

        $this->data[$key] = $data;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->data);
    }
}