<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkComponents extends Model
{
    use HasFactory;
    protected $table = "ok_components";
    protected $fillable = ['declared_defect_id'];
    protected $hidden = [];
}
