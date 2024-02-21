<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Candidates extends Model {
    use Userstamps; // add this line to your model class to add userstamp fields (created_by, updated_by, deleted_by) to your model.
    use HasFactory;
    protected $table = 'candidates';
    protected $guarded = [];
    public $timestamps = true;
}
