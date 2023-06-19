<h3 align="center">OpenAI Callfunction API PHP PACKAGE<br></h3>

## Installation

```
composer require tuzlu07x/openai
```

## Basic Usage

# First step, You call Client class

```php
<?php
    use Ftuzlu\OpenAI\Client;

    $yourAPIKey=XXXXXX;
    $yourOrganization=XXXXX;
    $baseUrl = 'https://api.openai.com/';
    $client = new Client(env('API_KEY'), env('ORGANIZATION'), $baseUrl);
```

# Second step, The first thing we need to do is to call the necessary variables and include them in our class.

```
Variable: functionName
Description: The name of the function being called, in this case, it is get_current_weather.

Variable: description
Description: A description of the purpose or intent of the function. In this example, it is "Bugün Antalya'da hava nasıl?" which translates to "How is the weather in Antalya today?"

Variable: type
Description: The data type expected as the response from the function. In this case, it is an object.

Variable: enum
Description: A list of possible values for a particular parameter. In this example, it is an array containing 'celsius' and 'fahrenheit'.

Variable: model
Description: The specific model to be used for the API call. In this case, it is 'gpt-3.5-turbo-0613'.

Variable: location
Description: The parameter representing the city and state for which weather information is requested. It is of type string and has a description indicating the format of the location, e.g., "San Francisco, CA".

Variable: required
Description: An array indicating which parameters are required for the function call. In this example, the location parameter is marked as required.
```

```php
<?php
    use Ftuzlu\OpenAI\Client;
    use Ftuzlu\OpenAI\OpenAI;
    use Ftuzlu\OpenAI\GetCurrentFunction;

    $data =[
        'functionName' => 'get_current_weather',
            'description' => 'Bugün Antalya\'da hava nasıl?',
            'type' => 'object',
            'enum' => ['celsius', 'fahrenheit'],
            'model' => 'gpt-3.5-turbo-0613',
            'location' => [
                "type" => "string",
                "description" => "The city and state, e.g. San Francisco, CA",
            ],
            'required' => ['location'],
    ]
    $openAI = new OpenAI($client);

    $getCurrentFunction = new GetCurrentFunction(
            $openAI,
            $data['functionName'],
            $data['description'],
            $data['type'],
            $data['enum'],
            $data['model'],
            $data['location'],
            $data['required']
        );
```

## The final step is to provide the information about what you want to ask ChatGPT. Here's the translation:

<p>Burada ExampleSecondResponse diye bir ornekten ilham alarak ilerleyecegiz</p>

```php
<?php

    use Ftuzlu\OpenAI\GetCurrentFunction;

    $example = new ExampleClass($getCurrentFunction);
```

<p>You need to call it in the example class GetResponse Chat that I wrote above here</p>

```php
<?php

    use Ftuzlu\OpenAI\ExampleClass;

    $getResponseChat = new GetResponseChat($example);
    $exampleRes = $example->getResponse() // This is the second request part where we receive a response to the question in line with the question asked to chatgpt.
    $getResponseChat->classFunction($exampleRes); // This is the part where the Class you made the second request in line with the question asked from Chatgpt is received.
```

<p>I hope I could help.</p>
