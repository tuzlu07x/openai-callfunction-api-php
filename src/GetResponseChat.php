<?php

namespace Ftuzlu\OpenAI;

class GetResponseChat
{
    public function __construct(
        protected $className,
    ) {
    }

    public function classFunction(array ...$parameters): mixed
    {
        $function = new $this->className(...$parameters);
        return call_user_func([$function, 'say']);
    }
}
