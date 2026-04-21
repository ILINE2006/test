<?php

use PHPUnit\Framework\TestCase;
use Model\Employee;

class HrTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = 'C:/xampp/htdocs';

        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/path.php',
        ]));

        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

    /**
     * @dataProvider employeeProvider
     * @runInSeparateProcess
     */
    public function testAddEmployee(string $httpMethod, array $postData, string $message): void
    {
        $request = $this->createMock(\Src\Request::class);
        $request->expects($this->any())->method('all')->willReturn($postData);
        $request->expects($this->any())->method('get')->willReturn('');
        $request->expects($this->any())->method('files')->willReturn([]);
        $request->method = $httpMethod;

        $result = (new \Controller\Hr())->employees($request);

        if (!empty($result)) {
            $messageRegex = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($messageRegex);
            $this->assertTrue(true);
        } else {
            if (function_exists('xdebug_get_headers')) {
                $this->assertContains($message, xdebug_get_headers());
            } else {
                $this->assertSame('', $result);
            }
        }

        if ($message === 'Location: /pop-it-mvc/hr/employees') {
            Employee::where('last_name', $postData['last_name'])->delete();
        }
    }

    public static function employeeProvider(): array
    {
        return [
            ['GET', [], ''],
            ['POST', ['last_name' => '', 'first_name' => '', 'birth_date' => ''], '{"last_name":["Поле last_name обязательно","В поле last_name нельзя использовать цифры"],"first_name":["Поле first_name обязательно","В поле first_name нельзя использовать цифры"],"birth_date":["Поле birth_date обязательно"]}'],
            ['POST', ['last_name' => 'Тестовый', 'first_name' => 'Иван', 'birth_date' => '1990-01-01', 'gender' => 'Мужской', 'position' => 'Специалист', 'department_id' => 1, 'employee_type' => 'ППС', 'address' => 'г. Москва'], 'Location: /pop-it-mvc/hr/employees'],
        ];
    }
}