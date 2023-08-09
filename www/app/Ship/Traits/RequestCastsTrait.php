<?php

namespace App\Ship\Traits;

use App\Ship\Contracts\Cast;
use RuntimeException;

/**
 * Расширяем класс Request. Добавляем возможность приводить аттрибуты к нужным типам прямо в нем
 *
 * @see https://laravel.com/docs/7.x/eloquent-mutators#attribute-casting
 */
trait RequestCastsTrait
{
    protected array $casts = [];

    /**
     * Приводи
     */
    protected function casts(array $requestData): array
    {
        $attributes = $requestData;

        foreach ($this->getCasts() as $key => $value) {
            if (!array_key_exists($key, $requestData)) {
                continue;
            }

            // Here we will cast the attribute. Then, if the cast is a date or datetime cast
            // then we will serialize the date for the array. This will convert the dates
            // to strings based on the date format specified for these Request Apiato.
            $attributes[$key] = $this->castAttribute(
                $key,
                $attributes[$key]
            );
        }

        return $attributes;
    }

    /**
     * Get the casts array.
     */
    public function getCasts(): array
    {
        return $this->casts;
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return null;
        }

        switch ($this->getCastType($key)) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
        }

        if ($this->isClassCastable($key)) {
            return $this->getCastableClass($key)->cast($value);
        }

        return $value;
    }

    private function isClassCastable(string $key): bool
    {
        $castType = $this->getCasts()[$key];

        /**
         * Проверяем что существует такой класс $castType
         * И то что он implements от @see Cast::class
         */
        return class_exists($castType) && $this->isClassImplementsCast($castType);
    }

    /**
     * @param class-string $class
     */
    private function isClassImplementsCast(string $class): bool
    {
        $isCast = array_key_exists(Cast::class, class_implements($class));

        if ($isCast) {
            return true;
        }

        throw new RuntimeException($class . ' должен быть имплементирован от Cast');
    }

    private function getCastableClass($key): Cast
    {
        $castType = $this->getCasts()[$key];
        return new $castType();
    }

    /**
     * Get the type of cast for a model attribute.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getCastType($key)
    {
        return trim(strtolower($this->getCasts()[$key]));
    }

    /**
     * Decode the given JSON back into an array or object.
     *
     * @param string $value
     * @param bool $asObject
     *
     * @return mixed
     */
    public function fromJson($value, $asObject = false)
    {
        return json_decode($value, !$asObject);
    }
}
