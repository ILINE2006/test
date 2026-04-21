<?php

namespace Controller;

use Model\Post;
use Src\Request;
use Src\View;
use Model\User;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);
    }
  

    public function hello(): string
    {
        return (new View())->render('site.hello', ['message' => 'hello working']);
    }
   

public function signup(\Src\Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new \Src\Validator\Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password'=> ['required']
            ], [
                'required'=> 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
    
            if($validator->fails()){
                return (new \Src\View())->render('site.signup',
                    ['message'=> json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
    
            $data = $request->all();
            $data['role'] = 'user'; 
    
            if (\Model\User::create($data)) {
                app()->route->redirect('/login');
                return ''; 
            }
        }
        return (new \Src\View())->render('site.signup');
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
