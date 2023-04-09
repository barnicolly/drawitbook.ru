<?php

namespace App\Ship\Parents\Tests\Optimization;

use ReflectionObject;
use Throwable;
trait ClearTestPropertiesAfterTestTrait
{

    protected function clearProperties(): void
    {
        foreach ((new ReflectionObject($this))->getProperties() as $prop) {
            if ($prop->isStatic() || str_starts_with($prop->getDeclaringClass()->getName(), 'PHPUnit\\')) {
                continue;
            }

            try {
                unset($this->{$prop->getName()});
            } catch (Throwable) {
                // Cannot access private property App\Containers\Program\Tests\Functional\V1\Folder\GetAllProgramModuleFoldersTest::$programFolderName
                // не может получить доступа к свойствам трейтов для очистки
            }
        }
    }
}
