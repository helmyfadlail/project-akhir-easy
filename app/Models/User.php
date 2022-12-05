<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'nim';
    protected $fillable = [
        'nim', 'nama', 'angkatan', 'password', 'token'
    ];
    protected $hidden = [];
}   
// 205150701111018
// Muhammad Helmy Fadlail Albab