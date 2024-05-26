<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainBox extends Model
{
	use HasFactory;

	protected $fillable = [
		'initial_balance',
		'current_balance',
		'input',
		'output',
		'history',
		'last_update',
		'last_editor'
	];

	public function last_editor()
	{
		return $this->belongsTo(User::class, 'last_editor');
	}

	public function mainBoxHistory()
	{
		return $this->hasMany(MainBoxHistory::class);
	}
}
