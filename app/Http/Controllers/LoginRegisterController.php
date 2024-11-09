<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendMailJob;

class LoginRegisterController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'photo' => 'image|nullable|max:250',
            'faculty' => 'required|string|max:250',
            'role' => 'required|in:admin,user',
            'password' => 'required|min:8|confirmed'
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'faculty' => $request->faculty,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            // 'photo' => $path ?? null, // Uncomment jika menggunakan photo
        ]);

        // Kirim email menggunakan job
        $data = [
            'subject' => 'Welcome to Our Application',
            'name' => $user->name,
            'email' => $user->email,
            'faculty' => $user->faculty,
        ];
        dispatch(new SendMailJob($data));

        // Login pengguna yang baru terdaftar
        Auth::login($user);

        // Redirect berdasarkan peran
        if ($user->role == 'admin') {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/beranda');
    }

    public function beranda()
    {
        $data_buku = Buku::all()->sortByDesc('id');
        $rowCount = Buku::count();
        $totalPrice = Buku::sum('harga');
        return view('beranda', compact('data_buku', 'rowCount', 'totalPrice'));
    }

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

            // Redirect berdasarkan peran
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/beranda');
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

        // Harus login sebelum lihat dashboard
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
