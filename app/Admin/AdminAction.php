<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use App\User\ApplicationForm;

class AdminAction extends Model
{
    public function application_forms() {
        return $this->belongsTo(ApplicationForm::class);
    }
}
