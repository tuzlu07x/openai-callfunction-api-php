<h3 align="center">OpenAI Callfunction API PHP PACKAGE<br></h3>

## Installation

```
composer require tuzlu07x/openai
```

# Usage With Function

```php
<?php

use Ftuzlu\OpenAI\BaseFunction;
use Ftuzlu\OpenAI\Client;
use Ftuzlu\OpenAI\OpenAI;

class Example extends BaseFunction
{
    public function __construct(
        private $location = 'Londra',
        private $unit = 'farhenheit',
    ) {
    }

    public function properties(): array
    {
        return $this->parameters();
    }
    public static function required(): array
    {
        return ['location'];
    }

    public static function model(): string
    {
        return 'gpt-3.5-turbo-0613';
    }

    public static function name(): string
    {
        return 'get_current_weather';
    }

    public static function description(): string
    {
        return 'Get the current weather in a given location';
    }

    public static function type(): string
    {
        return 'object';
    }

    public function parameters(): array
    {
        $parameters = [
            static::parameter('location', 'string', 'The city and state, e.g. San Francisco, CA')->required(),
            static::parameter('unit', 'string')->enum(['celcius', 'fahrenheit']),
        ];
        return $this->baseParameter($parameters);
    }

    public function handle(): string
    {
        return $this->json([
            "location" => $this->location,
            "temperature" => "72",
            "unit" => $this->unit,
            "forecast" => ["sunny", "windy"],
        ]);
    }
}

$yourApiKey = 'XXXXXXXXXXXX';
$yourOrganization = 'XXXXXXXXXX';
$example = new Example();

$messages = [
    ["role" => "system", "content" => "Hello I am helper"],
];
$functions = [
    $example->function()
];
$client = new Client($yourApiKey, $yourOrganization);
$openAI = new OpenAI($example, $client);
$chat = $openAI->chat($functions, $messages, 'handle'); //handle is functionName on example
var_dump($chat->say('How is weather in London?'));


```

# First step, You call Client class

```php
<?php
    use Ftuzlu\OpenAI\Client;

    $yourAPIKey=XXXXXX;
    $yourOrganization=XXXXX;
    $baseUrl = 'https://api.openai.com/';
    $client = new Client($yourApiKey, $yourOrganization, $baseUrl);
```

# Second Step

```php
<?php
    use Ftuzlu\OpenAI\OpenAI;

   $example = new Example(); //Example is your Class
   $openAI = new OpenAI($example, $client);
   $chat = $openAI->chat($functions, $messages, 'handle'); //handle is also your class's functionName.
```
