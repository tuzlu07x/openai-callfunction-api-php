<?php

namespace Ftuzlu\OpenAI;

class Parameter
{
    public string $name;
    public string $type;
    public ?string $description = null;
    public array $enum = [];
    public bool $required;

    public function __construct(string $name, string $type, ?string $description = null, bool $required = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->required = $required;
    }

    public function enum(array $enum)
    {
        $this->enum = $enum;
        return $this;
    }

    public function required(bool $required = true)
    {
        $this->required = $required;
        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->type,
        ];

        if ($this->description)
            $array['description'] = $this->description;
        if ($this->enum)
            $array['enum'] = $this->enum;

        return $array;
    }
}
