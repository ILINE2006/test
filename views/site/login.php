<style>
    .form-card {
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        padding: 40px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }
    
    .form-card h2 { text-align: center; margin-bottom: 20px; color: #2c3e50; }
    

    .form-card h3.error-msg { text-align: center; font-size: 14px; color: #d32f2f; margin-bottom: 15px; font-weight: normal; min-height: 20px; }
    

    .form-card h3.welcome-msg { text-align: center; font-size: 18px; color: #27ae60; margin-bottom: 15px; }

    label { display: block; margin-bottom: 15px; font-weight: bold; font-size: 14px; color: #555; }
    
    input {
        display: block; width: 100%; padding: 12px; margin-top: 5px;
        background-color: #fafafa; border: 1px solid #ccc;
        border-radius: 6px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;
    }
    
    input:focus { border-color: #3498db; outline: none; background-color: #fff; }

    button {
        width: 100%; padding: 14px; background-color: #3498db; color: #ffffff;
        border: none; border-radius: 8px; font-size: 16px; font-weight: bold;
        cursor: pointer; transition: background-color 0.2s; margin-top: 10px;
    }
    
    button:hover { background-color: #2980b9; }
</style>

<div class="form-card">
    <h2>Авторизация</h2>
    
    <h3 class="error-msg"><?= $message ?? ''; ?></h3>

    <h3 class="welcome-msg"><?= app()->auth->user()->name ?? ''; ?></h3>
    
    <?php
    if (!app()->auth::check()):
       ?>
       <form method="post">
       <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
           <label>Логин <input type="text" name="login"></label>
           <label>Пароль <input type="password" name="password"></label>
           <button>Войти</button>
       </form>
    <?php endif; ?>
</div>