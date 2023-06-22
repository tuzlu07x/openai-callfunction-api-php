<?php

namespace Ftuzlu\OpenAI;

class OpenAI
{
    public function __construct(
        private $className,
        private Client $client,
    ) {
    }

    public function chat(array $functions, array $messages = [], string $classFunctionName): mixed
    {
        return new Chat($this->className, $this->client, $functions, $messages, $classFunctionName);
    }
}
