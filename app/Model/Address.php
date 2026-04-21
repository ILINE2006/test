<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    public $timestamps = false;
    protected $fillable = ['region', 'city', 'house_building', 'street'];
}