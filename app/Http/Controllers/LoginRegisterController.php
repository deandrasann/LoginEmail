<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMailJob;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Hash as Hash;

class LoginRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }
    public function register()
    {
        return view('register');
    }
    public function beranda(){
        $data_buku = Buku::all()->sortByDesc('id');
        $rowCount = Buku::count();
        $totalPrice = Buku::sum('harga');
        return view('beranda', compact('data_buku', 'rowCount', 'totalPrice'));
    }
    /**
     * Store a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

//      public function store(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|unique:users,email',
//         'faculty' => 'required|string|max:255',
//         'password' => 'required|string|min:8|confirmed',
//     ]);

//     // Buat user baru
//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'faculty' => $request->faculty,
//         'password' => Hash::make($request->password),
//     ]);

//     // Redirect ke view "dashboard" dengan data user
//     return redirect()->route('send.email')->with('user', $user);
// }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'faculty' => 'required|string|max:250',
            'password' => 'required|min:8|confirmed'
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'faculty' => $request->faculty,
            'password' => Hash::make($request->password)
        ]);
        $data = [

        'subject' => 'Welcome to Our Application',
        'name' => $user->name,
        'email' => $user->email,
        'faculty' => $user->faculty,

    ];



    dispatch(new SendMailJob($data));
    return redirect()->route('isiemail')->with('user', $user);
}


public function isiEmail(){
    return view('isiemail');
}


    //     return redirect()->route('send.email')
    //     ->with('success', 'Email berhasil dikirim');


    //     // Kirim email menggunakan job dengan objek pengguna
    //     // dispatch(new SendMailJob($user));

    //     // Langsung login setelah registrasi
    //     // $credentials = $request->only('email', 'password');
    //     // Auth::attempt($credentials);
    //     // $request->session()->regenerate();
    //     // return redirect()->route('dashboard')
    //     //     ->withSuccess('You have successfully registered & logged in!');
    // }
    public function login()
    {
        return view('login');
    }

    public function autenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function dashboard()
    {
        if (Auth::check()) {
            $data_buku = Buku::all()->sortByDesc('id');
            $rowCount = Buku::count();
            $totalPrice = Buku::sum('harga');
            return view('dashboard', compact('data_buku', 'rowCount', 'totalPrice'));

        }
        //harus login sebelum liat dashboard
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }
    /**
     * Log out the user from the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

    return redirect()->route('login')
        ->withSuccess('You have logged out successfully!');
    }
}
