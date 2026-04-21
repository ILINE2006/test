<style>
    .mockup-content {
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        padding: 30px;
        width: 100%;
        max-width: 700px; 
        margin: 0 auto;   
        box-sizing: border-box; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    
    .mockup-content h2 {
        font-size: 22px;
        color: #2c3e50;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .mockup-divider {
        border: 0;
        border-top: 1px solid #eaeaea;
        margin-bottom: 25px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    
    .form-control:focus { outline: none; border-color: #3498db; }

    .btn-blue {
        background-color: #2C3E50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }
    
    .message { color: #27ae60; font-size: 14px; margin-bottom: 15px; font-weight: 500; }

    .mockup-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }
    
    .mockup-table th, .mockup-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e1e4e8;
        font-size: 14px;
    }
    
    .mockup-table th { background-color: #f8f9fa; font-weight: 600; color: #2c3e50; }
    .mockup-table tbody tr:hover { background-color: #fcfcfc; }
</style>

<div class="mockup-content">
    <h2>Управление подразделениями</h2>
    <hr class="mockup-divider">

    <div class="message"><?= $message ?? ''; ?></div>

    <form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="form-grid">
            <div class="form-group">
                <label>Название подразделения</label>
                <input type="text" name="name" class="form-control" required placeholder="Введите название">
            </div>
            
            <div class="form-group">
                <label>Вид подразделения</label>
                <select name="type" class="form-control">
                    <option value="Кафедра">Кафедра</option>
                    <option value="Деканат">Деканат</option>
                    <option value="Управление">Управление</option>
                    <option value="Хозяйственная часть">Хозяйственная часть</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn-blue">
            <i class="fa-solid fa-plus"></i> Добавить
        </button>
    </form>

    <table class="mockup-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Название</th>
                <th>Вид</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($departments)): ?>
                <?php foreach ($departments as $dept): ?>
                <tr>
                    <td><?= $dept->id ?></td>
                    <td><?= $dept->name ?></td>
                    <td><?= $dept->type ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: #777; padding: 20px;">Подразделения пока не добавлены</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>