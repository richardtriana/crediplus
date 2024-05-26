<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFile extends Model
{
    use HasFactory;

    protected $fillable = [
      'file',
      'title',
      'description',
      'category',
      'url_path',
      'metadata'
    ];
}
