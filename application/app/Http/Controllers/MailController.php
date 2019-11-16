<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //TODO create Mailable for Order, config e-mail and write a test
    public function send($data, $mailable){
        try {
            return Mail::to($data['email'])->send($mailable);
        } catch (\Exception $e) {
            return false;
        }
    }
}
