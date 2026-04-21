<style>
    .admin-card {
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        padding: 40px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }
    
    .admin-card h2 { 
        text-align: center; 
        margin-top: 0;
        margin-bottom: 20px; 
        color: #2c3e50; 
        font-size: 20px;
        line-height: 1.4;
    }
    
    .message { 
        text-align: center; 
        margin-bottom: 20px; 
        font-size: 14px; 
        color: #27ae60; 
        font-weight: bold; 
        min-height: 20px; 
    }

    label { display: block; margin-bottom: 15px; font-weight: bold; font-size: 14px; color: #555; }
    
    input {
        display: block; width: 100%; padding: 12px; margin-top: 5px;
        background-color: #fafafa; border: 1px solid #ccc;
        border-radius: 6px; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;
    }
    
    input:focus { border-color: #3498db; outline: none; background-color: #fff; }

    .btn-admin {
        width: 100%; padding: 14px; background-color: #2c3e50; color: #ffffff;
        border: none; border-radius: 8px; font-size: 16px; font-weight: bold;
        cursor: pointer; transition: background-color 0.2s; margin-top: 10px;
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    
    .btn-admin:hover { background-color: #1a252f; }
</style>

<div class="admin-card">
    <h2>Добавление сотрудника Отдела Кадров</h2>
    
    <div class="message"><?= $message ?? ''; ?></div>
    
    <form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Имя 
            <input type="text" name="name" required placeholder="ФИО специалиста">
        </label>
        
        <label>Логин 
            <input type="text" name="login" required placeholder="Придумайте логин">
        </label>
        
        <label>Пароль 
            <input type="password" name="password" required placeholder="Назначьте пароль">
        </label>
        
        <button type="submit" class="btn-admin">
            <i class="fa-solid fa-user-shield"></i> Добавить HR
        </button>
    </form>
</div>