<?php

namespace App\User;

use App\User\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    protected $table = 'application_files';

    /* 
    * link with form
    */
    public function application_forms() {
        return $this->belongsTo(ApplicationForm::class);
    }
}
