<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillSets extends Model
{
    use HasFactory;
    protected $table = 'skill_sets';
    protected $guarded = [];
    public $timestamps = false;
}
