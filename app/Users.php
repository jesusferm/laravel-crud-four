<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = ['id', 'name', 'email', 'email_verified_at', 'password', 'created_at', 'updated_at', 'files', 'image'];
}
