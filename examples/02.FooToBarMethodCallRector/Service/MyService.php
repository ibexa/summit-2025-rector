<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Service;

final class MyService
{
    private FooBarService $fooBarService;

    public function __construct(FooBarService $fooBarService)
    {
        $this->fooBarService = $fooBarService;
    }

    public function doSomething(): void
    {
        $this->fooBarService->foo();
    }
}
