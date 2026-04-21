
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
    
    .mockup-content h2 { font-size: 22px; color: #2c3e50; margin-top: 0; margin-bottom: 25px; }


    .stats-card {
        background-color: #ACD8F6;
        padding: 20px 25px;
        border-radius: 6px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    



    .filter-box {
        background-color: #f8f9fa;
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .filter-box h4 { margin-top: 0; margin-bottom: 15px; color: #2c3e50; font-size: 16px; font-weight: 600; }


    .filter-grid {
        display: flex;
        gap: 15px;
        align-items: flex-end; 
        flex-wrap: wrap;
    }

    .form-group { display: flex; flex-direction: column; flex-grow: 1; min-width: 180px; }
    .form-group label { margin-bottom: 8px; font-weight: 500; color: #333; font-size: 13px; }
    
    .form-control {
        width: 100%; padding: 10px 12px; border: 1px solid #ccc;
        border-radius: 6px; font-size: 14px; background-color: #fff;
        box-sizing: border-box; transition: border-color 0.3s;
        height: 42px;
    }
    .form-control:focus { outline: none; border-color: #3498db; }

    .btn-dark {
        background-color: #2c3e50;
        color: white; border: none; padding: 0 20px; border-radius: 6px;
        cursor: pointer; font-weight: 600; font-size: 14px;
        height: 42px; display: inline-flex; align-items: center; gap: 8px;
        transition: background-color 0.2s;
    }
    .btn-dark:hover { background-color: #1a252f; }

    .btn-reset {
        color: #e74c3c; text-decoration: none; font-size: 14px; font-weight: 500;
        padding: 0 15px; height: 42px; display: inline-flex; align-items: center; gap: 6px;
        border: 1px solid transparent; border-radius: 6px; transition: 0.2s;
    }
    .btn-reset:hover { background-color: #fcebeb; border-color: #fadada; }

    .mockup-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .mockup-table th, .mockup-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e1e4e8; font-size: 14px; }
    .mockup-table th { background-color: #f8f9fa; font-weight: 600; color: #2c3e50; }
    .mockup-table tbody tr:hover { background-color: #fcfcfc; }
</style>

<div class="mockup-content">
    <h2>Отчеты и аналитика</h2>

    <div class="stats-card">
        <div class="info">
            <h3>Средний возраст сотрудников: <?= $averageAge ?> лет</h3>
            <p>Всего найдено сотрудников: <?= count($employees) ?></p>
        </div>
        <div class="icon">
            <i class="fa-solid fa-chart-pie"></i>
        </div>
    </div>

    <div class="filter-box">
        <h4><i class="fa-solid fa-filter" style="color: #7f8c8d; margin-right: 5px;"></i> Фильтры</h4>
        
        <form method="GET" action="<?= app()->route->getUrl('/hr/reports') ?>">
            <div class="filter-grid">
                
                <div class="form-group">
                    <label>Подразделение</label>
                    <select name="department_id" class="form-control">
                        <option value="">Все подразделения</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept->id ?>" <?= (isset($_GET['department_id']) && $_GET['department_id'] == $dept->id) ? 'selected' : '' ?>>
                                <?= $dept->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Состав</label>
                    <select name="employee_type" class="form-control">
                        <option value="">Весь состав</option>
                        <option value="ППС" <?= (isset($_GET['employee_type']) && $_GET['employee_type'] == 'ППС') ? 'selected' : '' ?>>ППС</option>
                        <option value="УВП" <?= (isset($_GET['employee_type']) && $_GET['employee_type'] == 'УВП') ? 'selected' : '' ?>>УВП</option>
                        <option value="АХЧ" <?= (isset($_GET['employee_type']) && $_GET['employee_type'] == 'АХЧ') ? 'selected' : '' ?>>АХЧ</option>
                    </select>
                </div>

                <button type="submit" class="btn-dark">Применить</button>
                <a href="<?= app()->route->getUrl('/hr/reports') ?>" class="btn-reset">
                    <i class="fa-solid fa-xmark"></i> Сбросить
                </a>
                
            </div>
        </form>
    </div>

    <table class="mockup-table">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Дата рождения</th>
                <th>Должность</th>
                <th>Состав</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?= $emp->last_name ?> <?= $emp->first_name ?> <?= $emp->middle_name ?></td>
                <td><?= date('d.m.Y', strtotime($emp->birth_date)) ?></td>
                <td><?= $emp->position ?></td>
                <td><?= $emp->employee_type ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if (count($employees) === 0): ?>
            <tr>
                <td colspan="4" style="text-align: center; color: #777; padding: 20px;">Сотрудники по заданным фильтрам не найдены</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>