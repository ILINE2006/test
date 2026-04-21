<?php

namespace Controller;

use Model\Post;
use Src\Request;
use Src\View;

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
}