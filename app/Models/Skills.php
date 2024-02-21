<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Skills extends Model {
    use Userstamps;
    use HasFactory;
    protected $table = 'jobs';
    protected $guarded = [];
    public $timestamps = true;
}
