<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\AppMail;

class MailController extends Controller
{
    public function userCreated()
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('katemiz@masttech.com')->send(new AppMail($mailData));

        dd("Email is sent successfully.");
    }

}
