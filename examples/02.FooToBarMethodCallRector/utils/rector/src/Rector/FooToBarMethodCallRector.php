<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use App\Service\FooBarServiceInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Rector\AbstractRector;
use Rector\Reflection\ReflectionResolver;
use Rector\Tests\TypeDeclaration\Rector\FooToBarMethodCallRector\FooToBarMethodCallRectorTest;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see FooToBarMethodCallRectorTest
 */
final class FooToBarMethodCallRector extends AbstractRector
{
    private ReflectionResolver $reflectionResolver;
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionResolver $reflectionResolver, ReflectionProvider $reflectionProvider)
    {
        $this->reflectionResolver = $reflectionResolver;
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('// @todo fill the description', [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    private FooBarService $fooBarService;

    public function someMethod(): void
    {
        $this->fooBarService->foo();
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    private FooBarService $fooBarService;

    public function someMethod(): void
    {
        $this->fooBarService->bar();
    }
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
        return [MethodCall::class];
    }

    /**
     * @param \PhpParser\Node\Expr\MethodCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isPropertyOfType($node, FooBarServiceInterface::class)) {
            return null;
        }

        if ('foo' === $this->getName($node->name)) {
            $node->name->name = 'bar';

            return $node;
        }

        return null;
    }

    private function isPropertyOfType(MethodCall $node, string $targetClass): bool
    {
        $classReflection = $this->reflectionResolver->resolveClassReflectionSourceObject($node);
        if (!$classReflection instanceof ClassReflection || !$this->reflectionProvider->hasClass($targetClass)) {
            return false;
        }

        $targetClassReflection = $this->reflectionProvider->getClass($targetClass);
        if ($classReflection->getName() === $targetClassReflection->getName()) {
            return true;
        }

        return false;
    }
}
