<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employe';
    protected $primaryKey = 'id_employe';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
    ];
}
