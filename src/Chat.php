<?php

namespace Ftuzlu\OpenAI;

class Chat
{
    protected string $model;
    protected array $messages;
    protected array $functions;
    protected string $classFunctionName;

    public function __construct(protected $className, private Client $client, array $functions, array $messages, string $classFunctionName)
    {
        $this->model = 'gpt-3.5-turbo-0613';
        $this->messages = $messages;
        $this->functions = $functions;
        $this->classFunctionName = $classFunctionName;
    }

    public function data(): array
    {
        return [
            'model' => $this->model,
            'messages' => $this->messages,
            'functions' => $this->functions,
            'function_call' => "auto",
        ];
    }

    public function secondData(): array
    {
        return [
            'model' => $this->model,
            'messages' => $this->messages,
        ];
    }

    public function classFunction($functionName, $className, array ...$parameters): mixed
    {
        $function = new $className(...$parameters);
        return $function->$functionName();
    }

    public function handle(): array
    {
        $response = $this->client->chat($this->data());
        if (isset($response['error'])) return $response['error']['message'];

        $message = $response["choices"][0]["message"];
        $this->messages[] = $message;

        if (isset($message['function_call'])) {
            $functionName = $message["function_call"]["name"];
            $result = $this->classFunction($this->classFunctionName, $this->className, $this->messages);
            $this->messages[] = [
                'role' => 'function',
                'name' => $functionName,
                'content' => $result,
            ];
            $response = $this->client->chat($this->secondData());
            return $response;
        }

        return $message['content'];
    }


    public function say(string $message)
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message,
        ];

        return $this->handle();
    }
}
