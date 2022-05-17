<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    use HasFactory;
    protected $table = "stations";
    protected $fillable = ['part_id', 'line_id', 'l2l_station', 'station_number'];
    protected $hidden = [];
}
