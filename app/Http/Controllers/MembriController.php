<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MembriController extends Controller
{
    public function statistici()
    {
        // Obține statistici despre participarea la clase
        $statisticiClase = DB::select("
            SELECT c.denumire_clasa,
                   COUNT(mc.id_membru) as participari,
                   AVG(CASE WHEN mc.feedback IS NOT NULL THEN 1 ELSE 0 END) * 100 as rata_feedback
            FROM clase c
            JOIN membri_clase mc ON c.id_clasa = mc.id_clasa
            WHERE mc.id_membru = ?
            GROUP BY c.id_clasa, c.denumire_clasa
        ", [auth()->id()]);

        // Obține istoricul abonamentelor
        $istoricAbonamente = DB::select("
            SELECT tip_abonament,
                   data_incepere,
                   data_sfarsit,
                   pret,
                   DATEDIFF(data_sfarsit, data_incepere) as durata_zile
            FROM abonamente
            WHERE id_membru = ?
            ORDER BY data_incepere DESC
        ", [auth()->id()]);

        // Calculează statistici generale
        $statisticiGenerale = DB::select("
            SELECT 
                COUNT(DISTINCT mc.id_clasa) as total_clase_participate,
                (SELECT COUNT(*) 
                 FROM abonamente 
                 WHERE id_membru = ?) as total_abonamente,
                (SELECT SUM(pret) 
                 FROM abonamente 
                 WHERE id_membru = ?) as total_investit
            FROM membri_clase mc
            WHERE mc.id_membru = ?
        ", [auth()->id(), auth()->id(), auth()->id()]);

        return view('membri.statistici', compact('statisticiClase', 'istoricAbonamente', 'statisticiGenerale'));
    }

    public function edit()
    {
        $membru = DB::select("
            SELECT m.*, 
                   a.tip_abonament, 
                   a.data_sfarsit as data_expirare_abonament,
                   ant.nume as antrenor_nume,
                   ant.prenume as antrenor_prenume
            FROM membri m
            LEFT JOIN (
                SELECT * FROM abonamente 
                WHERE data_sfarsit >= CURDATE()
                ORDER BY data_sfarsit DESC 
                LIMIT 1
            ) a ON m.id_membru = a.id_membru
            LEFT JOIN antrenori ant ON m.id_antrenor = ant.id_antrenor
            WHERE m.id_membru = ?
        ", [auth()->id()]);

        return view('membri.edit', ['membru' => $membru[0]]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nume' => 'required|string|max:100',
            'prenume' => 'required|string|max:100',
            'telefon' => 'required|string|min:10|max:15|unique:membri,telefon,'.auth()->id().',id_membru',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $updateFields = [
            'nume' => $request->nume,
            'prenume' => $request->prenume,
            'telefon' => $request->telefon
        ];

        if ($request->filled('password')) {
            $updateFields['parola'] = Hash::make($request->password);
        }

        $setClause = implode(', ', array_map(fn($field) => "$field = ?", array_keys($updateFields)));
        $values = array_values($updateFields);
        $values[] = auth()->id();

        DB::update("
            UPDATE membri 
            SET $setClause
            WHERE id_membru = ?
        ", $values);

        return redirect()->route('membri.dashboard')
            ->with('success', 'Profil actualizat cu succes!');
    }

    public function adaugaFeedback(Request $request, $id_clasa)
    {
        $request->validate([
            'feedback' => 'required|string|max:255'
        ]);

        DB::update("
            UPDATE membri_clase 
            SET feedback = ?
            WHERE id_membru = ? AND id_clasa = ?
        ", [$request->feedback, auth()->id(), $id_clasa]);

        return redirect()->back()->with('success', 'Feedback adăugat cu succes!');
    }
}