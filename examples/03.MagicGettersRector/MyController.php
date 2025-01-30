<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Core\Repository\Values\Content\Content;
use Symfony\Component\HttpFoundation\Response;

final class MyController
{
    public function doSomeAction(Content $content): Response
    {
        return new Response(
            sprintf(
                'Content: [%d] %s',
                $content->id,
                $content->contentInfo->getName()
            )
        );
    }
}
