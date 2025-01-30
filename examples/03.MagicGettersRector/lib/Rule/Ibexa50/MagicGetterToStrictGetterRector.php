<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Rule\Ibexa50;

use Ibexa\Core\Repository\Values\Content\Content;
use PhpParser\Node;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\TypeDeclaration\Rector\MagicGetterToStrictGetterRector\MagicGetterToStrictGetterRectorTest
 */
final class MagicGetterToStrictGetterRector extends AbstractRector
{
    private const array GETTER_MAP = [
        'id' => 'getId',
        'contentInfo' => 'getContentInfo',
    ];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('// @todo fill the description', [
            new CodeSample(
                <<<'CODE_SAMPLE'
function foo(Content $content): void
{
    $content->id;
    $content->contentInfo->getName();
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
function foo(Content $content): void
{
    $content->getId();
    $content->getContentInfo->getName();
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Node\Expr\PropertyFetch::class];
    }

    /**
     * @param \PhpParser\Node\Expr\PropertyFetch $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isPropertyOfType($node->var, Content::class)) {
            return null;
        }
        $propertyName = $this->getName($node->name);
        if (!isset(self::GETTER_MAP[$propertyName])) {
            return null;
        }

        return new Node\Expr\MethodCall($node->var, self::GETTER_MAP[$propertyName], []);
    }

    private function isPropertyOfType(Node\Expr\Variable $node, string $targetClass): bool
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if ($scope === null) {
            return false;
        }

        return $scope->getType($node)->getClassName() === $targetClass;
    }
}
