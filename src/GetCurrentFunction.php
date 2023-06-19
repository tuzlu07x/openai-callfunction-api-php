<?php

namespace Ftuzlu\OpenAI;

class GetCurrentFunction extends BaseFunction
{
    public function __construct(
        protected OpenAI $openAI,
        protected string $name,
        protected string $description,
        protected string $type,
        protected array $enum,
        protected string $model,
        protected array $location,
        protected array $required,
    ) {
        parent::__construct($openAI);
    }

    protected function name(): string
    {
        return $this->name;
    }

    protected function description(): string
    {
        return $this->description;
    }

    protected function type(): string
    {
        return $this->type;
    }

    protected function enum(): array
    {
        return $this->enum;
    }

    protected function model(): string
    {
        return $this->model;
    }

    protected function options(): array
    {
        return [
            'json' => [
                'model' => $this->model(),
                'messages' => $this->messages(),
                'functions' => $this->functions()
            ],
        ];
    }

    protected function location(): array
    {
        return $this->location;
    }

    protected function required(): array
    {
        return $this->required;
    }

    protected function messages(): array
    {
        return [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => $this->description()
            ]

        ];
    }

    protected function secondMessages(string $functionResponse, array $message): array
    {
        return [
            [
                "role" => "system",
                "content" => "You are a helpful assistant.",
            ],
            [
                "role" => "user",
                "content" => $this->description,
            ],
            $message,
            [
                "role" => "function",
                "name" => $this->name,
                "content" => $functionResponse,
            ],
        ];
    }

    protected function functions(): array
    {
        return [
            [
                'name' => $this->name,
                'description' => $this->description,
                'parameters' => [
                    'type' => $this->type,
                    "properties" => [
                        "location" => $this->location
                    ],
                    'unit' => [
                        'type' => 'string',
                        'enum' => $this->enum,
                    ]
                ],
                'required' => $this->required,
            ]
        ];
    }

    protected function secondOptions(string $functionResponse, array $message): array
    {
        return [
            'json' => [
                'model' => $this->model,
                'messages' => $this->secondMessages($functionResponse, $message),
            ]
        ];
    }
}
