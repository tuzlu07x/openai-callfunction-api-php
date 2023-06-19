<?php

namespace Ftuzlu\OpenAI;

abstract class BaseFunction
{
    abstract protected function name(): string;
    abstract protected function description(): string;
    abstract protected function type(): string;
    abstract protected function enum(): array;
    abstract protected function model(): string;
    abstract protected function options(): array;
    abstract protected function location(): array;
    abstract protected function required(): array;
    abstract protected function functions(): array;
    abstract protected function messages(): array;
    abstract protected function secondMessages(string $functionResponse, array $messages): array;
    abstract protected function secondOptions(string $functionResponse, array $message): array;

    protected function __construct(
        protected OpenAI $openAI
    ) {
    }

    public function callFunction()
    {
        $response = $this->openAI->chat('v1/chat/completions', static::options());
        return $response;
    }

    public function secondCallFunction(string $functionResponse, array $messages)
    {
        $response = $this->openAI->chat('v1/chat/completions', static::secondOptions($functionResponse, $messages));
        return $response;
    }
}
