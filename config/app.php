<?php
return [
   'prefix' => '',
   'auth' => \Src\Auth\Auth::class,
   'identity' => \Model\User::class,
   'routeMiddleware' => [
       'auth' => \Middlewares\AuthMiddleware::class,
   ],
   'validators' => [
       'required' => \Validators\RequireValidator::class,
       'unique' => \Validators\UniqueValidator::class,
       'name' => \Validators\NameValidator::class
   ],
'routeAppMiddleware' => [
   'csrf' => \Middlewares\CSRFMiddleware::class,
   'trim' => \Middlewares\TrimMiddleware::class,
   'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
],




];
