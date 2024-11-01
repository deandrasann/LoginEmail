<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Mail;
use App\Mail\SendEmail;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Mail as Mail;

class sendEmailController extends Controller
{
    // public function index()
    //     {
    //     $content = [
    //     'name' => 'Ini Nama Pengirim',
    //     'subject' => 'Ini subject email',
    //     'body' => 'Ini adalah isi email yang
    //     dikirim dari laravel 10'
    //     ];
    //     Mail::to(' email@kamu.com')->send(new
    //     SendEmail($content));
    //     return "Email berhasil dikirim.";
    //     }


    public function store(Request $request){
        $data = $request->all();
        dispatch(new SendMailJob($data));
        return redirect()->route('send.email')
        ->with('success', 'Email berhasil dikirim');
    }
}
