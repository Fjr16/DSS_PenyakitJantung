<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliefValue extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'disease_id',
        'symtom_id',
    ];


    public function disease() {
        return $this->belongsTo(Disease::class);
    }
    public function symtom() {
        return $this->belongsTo(Symtom::class);
    }
}
