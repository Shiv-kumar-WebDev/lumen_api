<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Friends extends Model {
   protected $fillable = ['id', 'name', 'email', 'mobile'];
   protected $table = 'details';
}