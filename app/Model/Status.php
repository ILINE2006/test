<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    public $timestamps = false;
    protected $fillable = ['name'];
}