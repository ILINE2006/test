<style>
    .mockup-content {
        background-color: #ffffff;
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        padding: 20px; /* Уменьшили отступы */
        width: 100%;
        max-width: 900px; 
        margin: 0 auto;   
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    
    .mockup-content h2 { font-size: 20px; color: #2c3e50; margin-top: 0; margin-bottom: 15px; }
    .mockup-content h3 { font-size: 16px; color: #2c3e50; margin-top: 10px; margin-bottom: 10px; }

    /* Делаем сетку компактнее: 3 колонки вместо 2 */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .full-width { grid-column: 1 / -1; }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #444;
        font-size: 13px; /* Уменьшили шрифт */
    }

    .form-control {
        width: 100%;
        padding: 8px 10px; /* Уменьшили высоту полей */
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 13px;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }
    
    .form-control:focus { outline: none; border-color: #27ae60; }

    .btn-green {
        background-color: #2C3E50;
        color: white;
        border: none;
        padding: 8px 16px; /* Более компактная кнопка */
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
        margin-top: 15px;
    }
    
    .employee-photo {
        width: 40px;          
        height: 40px;        
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
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #e1e4e8;
        font-size: 13px;
    }
    
    .mockup-table th { background-color: #f8f9fa; font-weight: 600; color: #2c3e50; }
    .mockup-table tbody tr:hover { background-color: #fcfcfc; }
</style>

<div class="mockup-content">
    <h2>Управление сотрудниками</h2>

    <div class="search-box" style="margin-bottom: 15px;">
        <form method="get">
            <div style="display: flex; gap: 10px;">
                <input type="text" name="search" class="form-control" style="max-width: 250px;" placeholder="Поиск по фамилии..." value="<?= $search ?? '' ?>">
                <button type="submit" class="btn-green" style="margin-top:0">Найти</button>
                <a href="<?= app()->route->getUrl('/hr/employees') ?>" style="line-height: 34px; text-decoration: none; color: #666; font-size: 13px;">Сбросить</a>
            </div>
        </form>
    </div>

    <div class="message" style="color: red; font-size: 13px; margin-bottom: 10px;"><?= $message ?? ''; ?></div>

    <form method="post" enctype="multipart/form-data">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        
        <div class="form-grid">
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="middle_name" class="form-control">
            </div>

            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Пол</label>
                <select name="gender" class="form-control">
                    <option value="Мужской">Мужской</option>
                    <option value="Женский">Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Фото (Аватар)</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>Подразделение</label>
                <select name="department_id" class="form-control" required>
                    <option value="">Выберите...</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept->id ?>"><?= $dept->name ?> (<?= $dept->type ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Должность</label>
                <select name="position_id" class="form-control" required>
                    <option value="">Выберите...</option>
                    <?php foreach ($positions as $pos): ?>
                        <option value="<?= $pos->id ?>"><?= $pos->title ?> (<?= $pos->category ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Текущий статус</label>
                <select name="status_id" class="form-control">
                    <option value="">Выберите...</option>
                    <?php foreach ($statuses as $stat): ?>
                        <option value="<?= $stat->id ?>"><?= $stat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Адрес прописки</label>
                <select name="address_id" class="form-control">
                    <option value="">Выберите из справочника...</option>
                    <?php foreach ($addresses as $addr): ?>
                        <option value="<?= $addr->id ?>"><?= $addr->region ?>, г. <?= $addr->city ?>, ул. <?= $addr->street ?>, д. <?= $addr->house_building ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Учетная запись (Пользователь)</label>
                <select name="user_id" class="form-control">
                    <option value="">Нет учетки</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u->id ?>"><?= $u->login ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-green">Сохранить сотрудника</button>
    </form>

    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

    <h3>Список сотрудников</h3>
    <table class="mockup-table">
        <thead>
            <tr>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Подразделение</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td>
                    <?php if ($emp->avatar): ?>
                        <img src="<?= $emp->avatar ?>" class="employee-photo">
                    <?php else: ?>
                        <div style="width:40px; height:40px; background:#eee; border-radius:50%; text-align:center; line-height:40px; font-size:9px; color:#999;">Нет</div>
                    <?php endif; ?>
                </td>
                <td><?= $emp->last_name ?> <?= $emp->first_name ?> <?= $emp->middle_name ?></td>
                <td><?= $emp->position->title ?? '—' ?></td>
                <td><?= $emp->department->name ?? '—' ?></td>
                <td><?= $emp->status->name ?? '—' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>