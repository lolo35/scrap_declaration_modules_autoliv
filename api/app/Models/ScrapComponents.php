<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapComponents extends Model
{
    use HasFactory;
    protected $table = "scrap_components";
    protected $fillable = ['declared_defect_id'];
    protected $hidden = [];
}
