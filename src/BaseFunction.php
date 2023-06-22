<?php

namespace Ftuzlu\OpenAI;

abstract class BaseFunction
{
    abstract protected static function name(): string;
    abstract protected static function description(): string;
    abstract protected static function type(): string;
    abstract protected static function model(): string;
    abstract protected static function required(): array;
    abstract protected function handle(): string;
    abstract protected function parameters(): array;
    abstract protected function properties(): array;

    public function function(): array
    {
        return [
            "name" => static::name(),
            "description" => static::description(),
            "parameters" => [
                "type" => static::type(),
                "properties" => static::properties(),
                "required" => static::required()
            ],
        ];
    }

    protected function json(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    protected static function parameter(string $name, string $type, ?string $description = null, bool $required = false): Parameter
    {
        return new Parameter($name, $type, $description, $required);
    }

    protected function baseParameter(array $parameters): array
    {
        $properties = [];
        foreach ($parameters as $key => $value) {
            $properties[$value->name] = $value->toArray();
        }
        return $properties;
    }
}
