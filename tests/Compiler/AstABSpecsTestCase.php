<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Tests\Compiler;

use Railt\Compiler\Compiler;
use Railt\Reflection\Document;
use Railt\Support\File;
use Railt\Tests\AbstractTestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AstABSpecsTestCase
 * @package Railt\Tests\Compiler
 * @group large
 */
class AstABSpecsTestCase extends AbstractTestCase
{
    /**
     * @var string
     */
    protected $specDirectory = __DIR__ . '/../.resources/ast-ab-spec-tests';

    /**
     * @dataProvider positiveTests
     * @param string $file
     * @throws \Railt\Exceptions\UnrecognizedTokenException
     */
    public function testPositiveCompilation($file): void
    {
        $compiler = new Compiler();

        $ast = $compiler->parse(File::path($file));

        var_dump(dump($ast));

        $this->assertTrue(true, $file . ' compilation fail');
    }

    /**
     * @dataProvider negativeTests
     * @param string $file
     * @throws \Railt\Exceptions\UnrecognizedTokenException
     */
    public function testNegativeCompilation($file): void
    {
        $this->expectException(\Throwable::class);

        $compiler = new Compiler();

        $ast = $compiler->parse(File::path($file));

        $this->assertFalse(true,
            $file . ' must throw an error but complete successfully: ' . "\n" .
            trim(dump($ast))
        );
    }

    /**
     * @return array
     */
    public function positiveTests(): array
    {
        $finder = (new Finder())
            ->files()
            ->in($this->specDirectory)
            ->name('+*');

        return $this->formatProvider($finder->getIterator());
    }

    /**
     * @param \Traversable|SplFileInfo[] $files
     * @return array
     */
    private function formatProvider(\Traversable $files): array
    {
        $tests = [];

        foreach ($files as $test) {
            $tests[] = [$test->getRealPath()];
        }

        return $tests;
    }

    /**
     * @return array
     */
    public function negativeTests(): array
    {
        $finder = (new Finder())
            ->files()
            ->in($this->specDirectory)
            ->name('-*');

        return $this->formatProvider($finder->getIterator());
    }
}
