<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BOM extends Model
{
    use HasFactory;
    protected $table = "b_o_m_s";
    protected $fillable = ['finit_id', 'part_number', 'description', 'islabel', 'line_id', 'label_formula'];
    protected $hidden = [];
}
