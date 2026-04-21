<?php
use PHPUnit\Framework\TestCase;
use Model\User;

class SiteTest extends TestCase
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
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        if ($userData['login'] === 'login is busy') {
            $userData['login'] = User::get()->first()->login;
        }
 
        $request = $this->createMock(\Src\Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;
 
        $result = (new \Controller\Site())->signup($request);
 
        if (!empty($result)) {
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }
 
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        User::where('login', $userData['login'])->delete();
 
        if (function_exists('xdebug_get_headers')) {
          $this->assertContains($message, xdebug_get_headers());
      }
    }

    public static function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'login' => '', 'password' => ''], ''],
            ['POST', ['name' => '', 'login' => '', 'password' => ''], '{"name":["Поле name пусто"],"login":["Поле login пусто","Поле login должно быть уникально"],"password":["Поле password пусто"]}'],
            ['POST', ['name' => 'admin', 'login' => 'login is busy', 'password' => 'admin'], '{"login":["Поле login должно быть уникально"]}'],
            ['POST', ['name' => 'admin', 'login' => md5(time()), 'password' => 'admin'], 'Location: /pop-it-mvc/login'],
        ];
    }

    // тест авторизации

    /**
     * @dataProvider loginProvider
     * @runInSeparateProcess
     */
    public function testLogin(string $httpMethod, array $userData, string $message): void
    {
        if ($message === 'Location: /pop-it-mvc/hello') {
            \Model\User::create([
                'name' => 'test_user',
                'login' => $userData['login'],
                'password' => $userData['password'],
                'role' => 'user'
            ]);
        }

        $request = $this->createMock(\Src\Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;
        $result = (new \Controller\Site())->login($request);

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

        if ($message === 'Location: /pop-it-mvc/hello') {
            \Model\User::where('login', $userData['login'])->delete();
        }
    }

    public static function loginProvider(): array
    {
        return [
            ['GET', ['login' => '', 'password' => ''], ''],
            ['POST', ['login' => '', 'password' => ''], 'Неправильные логин или пароль'],
            ['POST', ['login' => 'wrong_login_999', 'password' => 'wrong_pass_999'], 'Неправильные логин или пароль'],
            ['POST', ['login' => 'test_login_' . time(), 'password' => '12345'], 'Location: /pop-it-mvc/hello'],
        ];
    }
}