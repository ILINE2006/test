<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Department;
use Model\Employee;
use Model\Position;
use Model\Status;
use Model\Address;
use Model\User;

class Hr
{
    // --- УПРАВЛЕНИЕ ПОДРАЗДЕЛЕНИЯМИ ---
    public function departments(Request $request): string
    {
        if ($request->method === 'POST') {
            Department::create($request->all());
            app()->route->redirect('/hr/departments');
            return '';
        }
        
        $departments = Department::all();
        return (new View())->render('hr.departments', ['departments' => $departments]);
    }

    // --- УПРАВЛЕНИЕ СОТРУДНИКАМИ ---
    public function employees(Request $request): string
    {
        $search = $request->get('search') ?? '';
        
        // Магия Eloquent: загружаем сотрудников сразу со всеми связанными названиями
        $query = Employee::with(['department', 'position', 'status', 'address', 'user']);
        
        if (!empty($search)) {
            $query->where('last_name', 'like', "%$search%");
        }
        
        $employees = $query->get();
        
        // Вытягиваем все справочники из БД для выпадающих списков <select>
        $departments = Department::all();
        $positions = Position::all();
        $statuses = Status::all();
        $addresses = Address::all();
        $users = User::all();

        if ($request->method === 'POST') {
            $validator = new \Src\Validator\Validator($request->all(), [
                'last_name' => ['required', 'name'],
                'first_name' => ['required', 'name'],
                'birth_date' => ['required'],
                'department_id' => ['required'],
                'position_id' => ['required']
            ], [
                'required' => 'Поле :field обязательно',
                'name' => 'В поле :field нельзя использовать цифры'
            ]);

            if ($validator->fails()) {
                return (new View())->render('hr.employees', [
                    'employees' => $employees,
                    'departments' => $departments,
                    'positions' => $positions,
                    'statuses' => $statuses,
                    'addresses' => $addresses,
                    'users' => $users,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'search' => $search
                ]);
            }

            $data = $request->all();
            

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
            
            if (Employee::create($data)) {
                app()->route->redirect('/hr/employees');
                return '';
            }
        }

        // Передаем всё добро в HTML-шаблон
        return (new View())->render('hr.employees', [
            'employees' => $employees,
            'departments' => $departments,
            'positions' => $positions,
            'statuses' => $statuses,
            'addresses' => $addresses,
            'users' => $users,
            'search' => $search
        ]);
    }

    // --- ОТЧЕТЫ ---
    public function reports(Request $request): string
    {
        $query = Employee::with(['department', 'position']);
        $data = $request->all();

        // Фильтр по подразделению
        if (isset($data['department_id']) && $data['department_id'] !== '') {
            $query->where('department_id', $data['department_id']);
        }

        if (isset($data['status_id']) && $data['status_id'] !== '') {
            $query->where('status_id', $data['status_id']);
        }
        
        // Фильтр по составу (заменили employee_type на фильтр по должности)
        if (isset($data['position_id']) && $data['position_id'] !== '') {
            $query->where('position_id', $data['position_id']);
        }

        $employees = $query->get();
        $departments = Department::all();
        $positions = Position::all();
        
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
            'positions' => $positions,
            'averageAge' => $averageAge
        ]);
    }
}