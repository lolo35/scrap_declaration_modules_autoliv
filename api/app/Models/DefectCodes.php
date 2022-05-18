<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectCodes extends Model
{
    use HasFactory;
    protected $table = "defect_codes";
    protected $fillable = ['code', 'description'];
    protected $hidden = [];
}
