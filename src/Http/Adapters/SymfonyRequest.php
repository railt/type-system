<?php
/**
 * This file is part of Railt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Railt\Http\Adapters;

use Railt\Http\RequestInterface;
use Railt\Http\Support\ConfigurableRequest;
use Railt\Http\Support\ConfigurableRequestInterface;
use Railt\Http\Support\InteractWithData;
use Railt\Http\Support\JsonContentTypeHelper;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SymfonyRequest
 * @package Railt\Http\Adapters
 */
class SymfonyRequest implements RequestInterface, ConfigurableRequestInterface
{
    use InteractWithData;
    use ConfigurableRequest;
    use JsonContentTypeHelper;

    /**
     * SymfonyRequest constructor.
     * @param Request $request
     * @throws \LogicException
     */
    public function __construct(Request $request)
    {
        $this->data = $this->isJson($request->headers->get('CONTENT_TYPE') ?? 'text/html')
            ? $this->getJsonQueryAttributes($request)
            : $this->getAllQueryAttributes($request);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \LogicException
     */
    private function getJsonQueryAttributes(Request $request): array
    {
        $input = $request->getContent();

        return (array)json_decode($input, true);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getAllQueryAttributes(Request $request): array
    {
        return array_merge($request->query->all(), $request->attributes->all(), $request->request->all());
    }
}
