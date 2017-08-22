<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Compiler\Autoloader;

/**
 * Interface Rule
 * @package Railt\Compiler\Autoloader
 */
interface Rule
{
    /**
     * @param string $type
     * @return null|string
     */
    public function __invoke(string $type): ?string;
}
