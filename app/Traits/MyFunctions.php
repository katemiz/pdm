<?php


namespace App\Traits;

use App\Models\User;

trait MyFunctions
{
    public function getActiveUsers($idCompany)
    {
        return User::where('status', 'Active')->get();
    }

    public function getActiveUserEmails($idCompany)
    {
        $emails = [];

        foreach($this->getActiveUsers($idCompany) as $user) {

            array_push($emails,$user->email);

        }
        return $emails;
    }



}
