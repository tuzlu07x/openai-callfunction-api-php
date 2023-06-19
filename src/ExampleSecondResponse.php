<?php

namespace Ftuzlu\OpenAI;

class ExampleSecondResponse
{
    public function __construct(
        private GetCurrentFunction $getCurrentFunction,
        private array $message = []
    ) {
    }

    public function say(string $location, string $unit = 'fahrenheit')
    {
        $info = [
            'location' => $location,
            'temperature' => '72',
            'unit' => $unit,
            'forecast' => ['sunny', 'windy'],
        ];
        return json_encode($info);
    }

    public function message(): array
    {
        $this->message = $this->getCurrentFunction->callFunction();
        if (isset($this->message['error'])) return $this->message;

        return $this->message['choices'][0]['message'];
    }

    public function getResponse()
    {
        $this->message = $this->message();
        if (isset($this->message['function_call'])) {
            $functionArguments = json_decode($this->message['function_call']['arguments'], true);
            $response = $this->say(
                $functionArguments['location'],
                $functionArguments['unit'] ?? 'fahrenheit'
            );
            $data = $this->getCurrentFunction->secondCallFunction($response, $this->message);
            var_dump($data);
        }
    }
}
