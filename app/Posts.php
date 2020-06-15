<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
	protected $fillable = ['title', 'desc', 'slug', 'files', 'image', 'status', 'user_id'];
}