<?php

namespace Controller;

use Src\Request;
use Src\View;
use Model\User as UserModel;
use Src\Auth\Auth;
use Src\Validator\Validator;

class User
{
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password'=> ['required']
            ], [
                'required'=> 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
    
            if($validator->fails()){
                return (new View())->render('site.signup',
                    ['message'=> json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
    
            $data = $request->all();
            $data['role'] = 'user'; 
    
            if (UserModel::create($data)) {
                app()->route->redirect('/login');
                return ''; 
            }
        }
        return (new View())->render('site.signup');
    }

    public function login(Request $request): string
    {
       if ($request->method === 'GET') {
           return (new View())->render('site.login');
       }
       if (Auth::attempt($request->all())) {
           app()->route->redirect('/hello');
           return ''; 
       }
       return (new View())->render('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
       Auth::logout();
       app()->route->redirect('/hello');
    }
}