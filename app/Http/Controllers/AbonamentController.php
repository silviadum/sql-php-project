<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbonamentController extends Controller
{
    public function index()
    {
        $abonamente = DB::select("
            SELECT DISTINCT tip_abonament, pret 
            FROM abonamente 
            GROUP BY tip_abonament, pret
        ");

        return view('abonamente.index', compact('abonamente'));
    }

    public function cumpara(Request $request)
    {
        $request->validate([
            'tip_abonament' => 'required|string'
        ]);

        // Verifică dacă există un abonament activ
        $abonamentActiv = DB::select("
            SELECT * FROM abonamente 
            WHERE id_membru = ? 
            AND data_sfarsit >= CURDATE()
        ", [auth()->id()]);

        if (!empty($abonamentActiv)) {
            return redirect()->back()->with('error', 'Ai deja un abonament activ!');
        }

        $preturi = [
            'Basic' => 100.00,
            'Standard' => 150.00,
            'Premium' => 200.00
        ];

        $pret = $preturi[$request->tip_abonament] ?? 100.00;
        $dataStart = Carbon::now();
        $dataSfarsit = $dataStart->copy()->addMonth();

        DB::insert("
            INSERT INTO abonamente (tip_abonament, pret, data_incepere, data_sfarsit, id_membru)
            VALUES (?, ?, ?, ?, ?)
        ", [
            $request->tip_abonament,
            $pret,
            $dataStart->format('Y-m-d'),
            $dataSfarsit->format('Y-m-d'),
            auth()->id()
        ]);

        return redirect()->route('dashboard')->with('success', 'Abonament cumpărat cu succes!');
    }

    public function anulare($id)
    {
        // Verificăm dacă abonamentul aparține membrului curent și obținem detaliile abonamentului
        $abonament = DB::select("
            SELECT * FROM abonamente 
            WHERE id_abonament = ? AND id_membru = ?
            AND data_sfarsit > CURDATE()
        ", [$id, auth()->id()]);

        if (empty($abonament)) {
            return redirect()->route('dashboard')
                ->with('error', 'Nu aveți permisiunea să anulați acest abonament sau abonamentul nu este activ.');
        }

        // Ștergem abonamentul din baza de date
        DB::delete("
            DELETE FROM abonamente
            WHERE id_abonament = ? AND id_membru = ?
        ", [$id, auth()->id()]);

        return redirect()->route('dashboard')
            ->with('success', 'Abonamentul a fost anulat cu succes.');
    }
}