<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Membri;
use App\Models\Antrenori;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Verificare pentru admin
        if ($request->email === 'admin') {
            $user = DB::select("SELECT * FROM membri WHERE email = 'admin'");
            if (!empty($user) && Hash::check($request->password, $user[0]->parola)) {
                Auth::loginUsingId($user[0]->id_membru);
                return redirect()->route('admin.dashboard');
            }
        }

        if ($request->tip_utilizator === 'antrenor') {
            $antrenor = DB::select("
                SELECT * FROM antrenori 
                WHERE email = ?
            ", [$request->email]);

            if (!empty($antrenor) && Hash::check($request->password, $antrenor[0]->parola)) {
                session(['antrenor_id' => $antrenor[0]->id_antrenor]);
                return redirect()->route('antrenor.dashboard');
            }
        } else {
            $membru = DB::select("
                SELECT * FROM membri 
                WHERE email = ? 
                AND email != 'admin'
            ", [$request->email]);

            if (!empty($membru) && Hash::check($request->password, $membru[0]->parola)) {
                Auth::loginUsingId($membru[0]->id_membru);
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Credențialele introduse nu sunt corecte.'
        ])->withInput($request->except('password'));
    }

    public function showRegisterForm()
    {
        // Obține lista de antrenori pentru select
        $antrenori = DB::select("SELECT * FROM antrenori");
        return view('auth.register', compact('antrenori'));
    }

    public function showTrainerRegisterForm()
    {
        return view('auth.register-trainer');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nume' => 'required|string|max:100',
            'prenume' => 'required|string|max:100',
            'data_nasterii' => 'required|date',
            'email' => 'required|string|email|max:100|unique:membri',
            'telefon' => 'required|string|min:10|max:15|unique:membri',
            'password' => 'required|string|min:8|confirmed',
            'id_antrenor' => 'nullable|exists:antrenori,id_antrenor'
        ]);

        try {
            DB::beginTransaction();

            DB::insert("
                INSERT INTO membri (nume, prenume, data_nasterii, email, telefon, parola, id_antrenor)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ", [
                $request->nume,
                $request->prenume,
                $request->data_nasterii,
                $request->email,
                $request->telefon,
                Hash::make($request->password),
                $request->id_antrenor
            ]);

            DB::commit();
            return redirect()->route('login')
                ->with('success', 'Cont creat cu succes! Vă rugăm să vă autentificați.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'A apărut o eroare la crearea contului.'])->withInput();
        }
    }

    public function registerTrainer(Request $request)
    {
        $request->validate([
            'nume' => 'required|string|max:100',
            'prenume' => 'required|string|max:100',
            'specializare' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:antrenori',
            'telefon' => 'required|string|min:10|max:15|unique:antrenori',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            DB::insert("
                INSERT INTO antrenori (nume, prenume, specializare, email, telefon, parola)
                VALUES (?, ?, ?, ?, ?, ?)
            ", [
                $request->nume,
                $request->prenume,
                $request->specializare,
                $request->email,
                $request->telefon,
                Hash::make($request->password)
            ]);

            return redirect()->route('login')
                ->with('success', 'Cont de antrenor creat cu succes! Vă rugăm să vă autentificați.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'A apărut o eroare la crearea contului.'])->withInput();
        }
    }

    public function dashboard()
    {
        if (session()->has('antrenor_id')) {
            return redirect()->route('antrenor.dashboard');
        }

        if (auth()->user()->email === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Obținem doar abonamentul activ (data_sfarsit mai mare decât data curentă)
        $abonamentActiv = DB::select("
            SELECT * FROM abonamente 
            WHERE id_membru = ? 
            AND data_sfarsit > CURDATE()
            ORDER BY data_sfarsit DESC 
            LIMIT 1
        ", [auth()->id()]);

        $claseleInscris = DB::select("
            SELECT c.*, a.nume as antrenor_nume, a.prenume as antrenor_prenume
            FROM clase c
            JOIN membri_clase mc ON c.id_clasa = mc.id_clasa
            JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            WHERE mc.id_membru = ?
        ", [auth()->id()]);

        return view('membri.dashboard', compact('abonamentActiv', 'claseleInscris'));
    }

    public function logout(Request $request)
    {
        session()->forget('antrenor_id');
        Auth::logout();
        return redirect()->route('login');
    }
}