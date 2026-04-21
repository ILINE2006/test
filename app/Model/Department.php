<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Указываем точное имя таблицы, чтобы система не искала "departments"
    protected $table = 'department'; 

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type'
    ];
}