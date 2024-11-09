<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symtom extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'bobot',
    ];

    public function diseases() {
        return $this->belongsToMany(Disease::class, 'belief_values');
    }
}
