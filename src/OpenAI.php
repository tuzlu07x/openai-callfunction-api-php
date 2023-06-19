<?php

namespace Ftuzlu\OpenAI;

class OpenAI
{
    public function __construct(
        protected Client $client,
        protected array $extraData = [],
    ) {
    }

    public function chat(string $url, array $options): mixed
    {
        if ($this->extraData !== [])
            $options = array_merge($options, $this->extraData);

        return $this->client->post($url, $options);
    }
}
