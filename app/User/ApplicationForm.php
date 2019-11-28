<?php

namespace App\User;

use App\User\ApplicationFile;
use App\Admin\FormProcessAction;
use App\Admin\AdminAction;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    protected $table = 'application_forms';

    /* 
    * link to files
    */
    public function application_files() {
        return $this->hasMany(ApplicationFile::class);
    }

    public function form_actions() {
        return $this->hasMany(FormProcessAction::class);
    }

    public function admin_actions() {
        return $this->hasMany(AdminAction::class);
    }
    
}
