<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaredDefects extends Model
{
    use HasFactory;
    protected $table = "declared_defects";
    protected $fillable = ['defect_id', 'finit', 'part_number', 'line', 'defect_code', 'identified_station', 'produced_station', 'quantity'];
    protected $hidden = [];

    public static function last() {
        return self::latest()->first();
    }
}
