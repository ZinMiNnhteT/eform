<?php

namespace App\Observer;
use App\User;
use App\User\ApplicationForm;
use App\Notifications\notifyAlert;

class ItemObserver {
    public function created(Id $id) {
        $form = ApplicationForm::find($id) ;
        $user = User::where('id', $form->user_id)->first();
        $user->notify (new notifyAlert($user, $id));
    }
}