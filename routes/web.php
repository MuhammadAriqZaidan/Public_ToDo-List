<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\TodoWebController;
use App\Http\Controllers\AuthController;
use App\Models\User;



Route::get('/', function () {
    return redirect('/todos'); // atau sesuaikan dengan halaman utama kamu
});

// --- ✅ AUTH WEB (blade) ---
Route::view('/login', 'auth.login')->name('login'); // tampilan login
Route::view('/register', 'auth.register')->name('register'); // opsional: tampilan register jika ada blade-nya

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/todos');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->middleware('auth');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($user);
    return redirect('/todos');
});


// --- ✅ TODOS (hanya untuk user login) ---
Route::middleware('auth')->group(function () {
    Route::get('/todos', [TodoWebController::class, 'index']);
    Route::post('/todos', [TodoWebController::class, 'store']);
    Route::put('/todos/{id}', [TodoWebController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{id}', [TodoWebController::class, 'destroy']);

    Route::get('/todos/create', [TodoWebController::class, 'create']);
    Route::get('/todos/{id}/edit', [TodoWebController::class, 'edit']);
});

Route::patch('/todos/{id}/toggle', [TodoWebController::class, 'toggleStatus'])->middleware('auth');
