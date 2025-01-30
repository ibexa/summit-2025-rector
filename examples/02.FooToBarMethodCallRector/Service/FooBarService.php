<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Service;

final class FooBarService implements FooBarServiceInterface
{
    /**
     * @deprecated 2.0.0 use {@see bar()} instead.
     */
    public function foo(): void
    {
        // do nothing
    }

    public function bar(): void
    {
        // do nothing
    }
}
