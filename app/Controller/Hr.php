<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Department;
use Model\Employee;

class Hr
{
    public function departments(Request $request): string
    {
        if ($request->method === 'POST') {
            Department::create($request->all());
            app()->route->redirect('/hr/departments');
        }
        
        $departments = Department::all();
        return (new View())->render('hr.departments', ['departments' => $departments]);
    }

    public function employees(\Src\Request $request): string
    {
        $search = $request->get('search') ?? '';
        $query = \Model\Employee::query();
        
        if (!empty($search)) {
            $query->where('last_name', 'like', "%$search%");
        }
        
        $employees = $query->get();
        $departments = \Model\Department::all();


        if ($request->method === 'POST') {

            $validator = new \Src\Validator\Validator($request->all(), [
                'last_name' => ['required', 'name'],
                'first_name' => ['required', 'name'],
                'birth_date' => ['required']
            ], [
                'required' => 'Поле :field обязательно',
                'name' => 'В поле :field нельзя использовать цифры'
            ]);

            if ($validator->fails()) {
                return new \Src\View('hr.employees', [
                    'employees' => $employees,
                    'departments' => $departments,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'search' => $search
                ]);
            }

            $data = $request->all();
            
            unset($data['avatar']);

            $file = $request->files()['avatar'] ?? null;
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $data['avatar'] = '/pop-it-mvc/public/uploads/' . $filename;
                }
            }
            
            if (\Model\Employee::create($data)) {
                app()->route->redirect('/hr/employees');
                return '';
            }
        }

        return new \Src\View('hr.employees', [
            'employees' => $employees,
            'departments' => $departments,
            'search' => $search
        ]);
    }

    public function reports(Request $request): string
    {
        $query = Employee::query();
        $data = $request->all();

        if (isset($data['department_id']) && $data['department_id'] !== '') {
            $query->where('department_id', $data['department_id']);
        }

        if (isset($data['employee_type']) && $data['employee_type'] !== '') {
            $query->where('employee_type', $data['employee_type']);
        }

        $employees = $query->get();
        $departments = Department::all();
        $empCollection = \Collect\collection($employees->toArray());
        
        $averageAge = 0;
        
        if ($empCollection->count() > 0) {
            $totalAge = 0;
            
            $empCollection->each(function ($emp) use (&$totalAge) {
                $age = date_diff(date_create($emp['birth_date']), date_create('today'))->y;
                $totalAge += $age;
            });

            $averageAge = round($totalAge / $empCollection->count(), 1);
        }

        return (new View())->render('hr.reports', [
            'employees' => $employees,
            'departments' => $departments,
            'averageAge' => $averageAge
        ]);
    }
}