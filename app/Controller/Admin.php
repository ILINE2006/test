<?php
namespace Controller;

use Src\View;
use Src\Request;

class Admin
{

    public function addHr(\Src\Request $request): string
{

    if ($request->method === 'POST') {
        $data = $request->all();
        

        $data['role'] = 'hr'; 


        if (\Model\User::create($data)) {

            return (new \Src\View())->render('admin.add_hr', ['message' => 'HR успешно добавлен!']);
        }
    }
    

    return (new \Src\View())->render('admin.add_hr');
}
}