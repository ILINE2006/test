<style>
    .mockup-content {
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        padding: 30px;
        width: 100%;
        max-width: 800px; 
        margin: 0 auto;   
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    
    .mockup-content h2 { font-size: 22px; color: #2c3e50; margin-top: 0; margin-bottom: 20px; }
    .mockup-content h3 { font-size: 18px; color: #2c3e50; margin-top: 10px; margin-bottom: 15px; }

    .mockup-divider { border: 0; border-top: 1px solid #eaeaea; margin: 30px 0; }


    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }


    .full-width { grid-column: 1 / -1; }

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
    
    .form-control:focus { outline: none; border-color: #27ae60; }


    .btn-green {
        background-color: #2C3E50;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
        margin-top: 20px;
    }
    
    .employee-photo {
        width: 50px;          
        height: 50px;         
        object-fit: cover;   
        border-radius: 50%;   
        border: 1px solid #ddd; 
    }

    .mockup-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
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
    <h2>Управление сотрудниками</h2>

    <div class="search-box">
        <form method="get">
            <div style="display: flex; gap: 10px;">
                <input type="text" name="search" class="form-control" placeholder="Поиск по фамилии..." value="<?= $search ?? '' ?>">
                <button type="submit" class="btn-green" style="margin-top:0">Найти</button>
                <a href="<?= app()->route->getUrl('/hr/employees') ?>" style="line-height: 40px; text-decoration: none; color: #666;">Сбросить</a>
            </div>
        </form>
    </div>

    <div class="message" style="color: red;"><?= $message ?? ''; ?></div>

    <form method="post" enctype="multipart/form-data">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="form-grid">
            <div class="form-group">
                <label>Фамилия (без цифр)</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Имя (без цифр)</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Фото (Загрузка файла)</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender" class="form-control">
                    <option>Мужской</option>
                    <option>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Должность</label>
                <input type="text" name="position" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Подразделение</label>
                <select name="department_id" class="form-control" required>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept->id ?>"><?= $dept->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Состав</label>
                <select name="employee_type" class="form-control">
                    <option value="ППС">ППС</option>
                    <option value="УВП">УВП</option>
                    <option value="АХЧ">АХЧ</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label>Адрес прописки</label>
                <input type="text" name="address" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn-green">Сохранить сотрудника</button>
    </form>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

    <h3>Список сотрудников</h3>
    <table class="mockup-table">
        <thead>
            <tr>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Подразделение</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td>
                    <?php if ($emp->avatar): ?>
                        <img src="<?= $emp->avatar ?>" class="employee-photo">
                    <?php else: ?>
                        <div style="width:50px; height:50px; background:#eee; border-radius:50%; text-align:center; line-height:50px; font-size:10px; color:#999;">Нет фото</div>
                    <?php endif; ?>
                </td>
                <td><?= $emp->last_name ?> <?= $emp->first_name ?></td>
                <td><?= $emp->position ?></td>
                <td><?= $emp->department->name ?? 'Не указано' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>