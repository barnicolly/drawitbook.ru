<?php

namespace App\Ship\Parents\Tests\Optimization;

trait ClearTestPropertiesAfterTestTrait
{

    protected function clearProperties(): void
    {
        foreach ((new \ReflectionObject($this))->getProperties() as $prop) {
            if ($prop->isStatic() || strpos($prop->getDeclaringClass()->getName(), 'PHPUnit\\') === 0) {
                continue;
            }

            try {
                unset($this->{$prop->getName()});
            } catch (\Throwable $exception) {
                // Cannot access private property App\Containers\Program\Tests\Functional\V1\Folder\GetAllProgramModuleFoldersTest::$programFolderName
                // не может получить доступа к свойствам трейтов для очистки
            }
        }
    }
}