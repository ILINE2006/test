<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ИС «Отдел кадров»</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            background-color: #f4f4f9;
            color: #333333;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }


        .site-header {
            background-color: #ffffff;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        }
        
        .site-header .logo {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .main-nav {
            display: flex;
            align-items: center;
        }

        .main-nav a {
            text-decoration: none;
            color: #555555;
            margin-left: 20px;
            font-size: 14px;
            font-weight: bold;
            transition: color 0.2s;
        }
        
        .main-nav a:hover { color: #3498db; }


        .main-content {
            flex-grow: 1;
            padding: 40px 20px;
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="logo">ИС «Отдел кадров»</div>
    <nav class="main-nav">
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        
        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php else: ?>
            <?php if(isset(app()->auth::user()->role) && app()->auth::user()->role === 'hr'): ?>
                <a href="<?= app()->route->getUrl('/hr/departments') ?>">Отделы</a>
                <a href="<?= app()->route->getUrl('/hr/employees') ?>">Сотрудники</a>
                <a href="<?= app()->route->getUrl('/hr/reports') ?>">Отчеты</a>
            <?php elseif(isset(app()->auth::user()->role) && app()->auth::user()->role === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/admin/add-hr') ?>">Добавить HR</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>" style="color: #e74c3c; margin-left: 30px;">
                Выход (<?= app()->auth::user()->name ?>)
            </a>
        <?php endif; ?>
    </nav>
</header>

<main class="main-content">
    <?= $content ?? '' ?>
</main>

</body>
</html>