<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    public $timestamps = false;


    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'birth_date',
        'address',
        'position',
        'employee_type',
        'department_id',
        'user_id',
        'avatar'
    ];
}