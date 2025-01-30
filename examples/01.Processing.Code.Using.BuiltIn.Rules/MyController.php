<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Cart\Money\MoneyFactory;

final class MyController
{
    // run ./vendor/bin/rector/process to replace deprecated MoneyFactory with the new one
    private MoneyFactory $moneyFactory;

    public function __construct(MoneyFactory $moneyFactory)
    {
        $this->moneyFactory = $moneyFactory;
    }
}

