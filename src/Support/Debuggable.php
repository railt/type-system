<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Support;

/**
 * Trait Debuggable
 * @package Railt\Support
 */
trait Debuggable
{
    /**
     * @var bool
     */
    private $debug = false;

    /**
     * @param bool $enabled
     * @return $this|self|Debuggable
     */
    public function enableDebug(bool $enabled = true): self
    {
        $this->debug = $enabled;

        return $this;
    }
}
