<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    // Указываем таблицу (на всякий случай, чтобы фреймворк не запутался)
    protected $table = 'employees';

    public $timestamps = false;

    // Разрешаем заполнять только новые поля (с _id на конце)
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'birth_date',
        'address_id',
        'position_id',
        'status_id',
        'user_id',
        'department_id',
        'avatar'
    ];

    // --- МАГИЯ СВЯЗЕЙ (Relationships) ---

    // Связь с таблицей подразделений
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // Связь с таблицей должностей
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    // Связь с таблицей адресов
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    // Связь с таблицей статусов
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    // Связь с таблицей пользователей (учетка для входа)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}