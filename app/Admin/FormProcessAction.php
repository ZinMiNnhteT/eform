<?php

namespace App\Admin;

use App\User\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class FormProcessAction extends Model
{
    protected $table = 'form_process_actions';

    /*
        link with form
    */
    public function application_forms() {
        return $this->belongsTo(ApplicationForm::class);
    }
}
