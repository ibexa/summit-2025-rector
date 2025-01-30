<?php

namespace Rector\Tests\TypeDeclaration\Rector\FooToBarMethodCallRector\Fixture;

use App\Service\FooBarServiceInterface;

final class SomeClass
{
    private FooBarServiceInterface $fooBarService;

    private \stdClass $someOtherProperty;

    public function __construct(FooBarServiceInterface $fooBarService)
    {
        $this->fooBarService = $fooBarService;
    }

    public function someMethod(): void
    {
        $this->fooBarService->foo();
        $this->someOtherProperty->foo();
    }
}

?>
-----
<?php

namespace Rector\Tests\TypeDeclaration\Rector\FooToBarMethodCallRector\Fixture;

use App\Service\FooBarServiceInterface;

final class SomeClass
{
    private FooBarServiceInterface $fooBarService;

    private \stdClass $someOtherProperty;

    public function __construct(FooBarServiceInterface $fooBarService)
    {
        $this->fooBarService = $fooBarService;
    }

    public function someMethod(): void
    {
        $this->fooBarService->bar();
        $this->someOtherProperty->foo();
    }
}

?>
