<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EchipamenteController extends Controller
{
    public function index()
    {
        // Interogare complexă pentru a afișa echipamentele și în ce săli se află
        $echipamente = DB::select("
            SELECT e.*,
                   (SELECT GROUP_CONCAT(s.denumire_sala, ' (', se.bucati, ' bucăți)')
                    FROM sali_echipamente se
                    JOIN sali s ON se.id_sala = s.id_sala
                    WHERE se.id_echipament = e.id_echipament) as locatii,
                   (SELECT SUM(bucati) 
                    FROM sali_echipamente se 
                    WHERE se.id_echipament = e.id_echipament) as total_bucati
            FROM echipamente e
            ORDER BY e.denumire_echipament
        ");

        return view('echipamente.index', compact('echipamente'));
    }

    public function create()
    {
        $sali = DB::select("SELECT * FROM sali");
        return view('echipamente.create', compact('sali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'denumire_echipament' => 'required|string|max:100',
            'necesita_achizitie' => 'required|boolean',
            'sali' => 'array',
            'bucati' => 'array'
        ]);

        // Inserare echipament nou
        DB::insert("
            INSERT INTO echipamente (denumire_echipament, necesita_achizitie)
            VALUES (?, ?)
        ", [$request->denumire_echipament, $request->necesita_achizitie]);

        $id_echipament = DB::getPdo()->lastInsertId();

        // Inserare în sali_echipamente pentru fiecare sală selectată
        if ($request->sali) {
            foreach ($request->sali as $index => $id_sala) {
                if (isset($request->bucati[$index]) && $request->bucati[$index] > 0) {
                    DB::insert("
                        INSERT INTO sali_echipamente (id_sala, id_echipament, bucati)
                        VALUES (?, ?, ?)
                    ", [$id_sala, $id_echipament, $request->bucati[$index]]);
                }
            }
        }

        return redirect()->route('admin.echipamente.index')
                        ->with('success', 'Echipamentul a fost adăugat cu succes!');
    }

    public function edit($id)
    {
        // Interogare JOIN pentru a obține echipamentul și distribuția sa în săli
        $echipament = DB::select("
            SELECT e.*,
                   se.id_sala,
                   se.bucati,
                   s.denumire_sala
            FROM echipamente e
            LEFT JOIN sali_echipamente se ON e.id_echipament = se.id_echipament
            LEFT JOIN sali s ON se.id_sala = s.id_sala
            WHERE e.id_echipament = ?
        ", [$id]);

        $sali = DB::select("SELECT * FROM sali");

        return view('echipamente.edit', compact('echipament', 'sali'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'denumire_echipament' => 'required|string|max:100',
            'necesita_achizitie' => 'required|boolean',
            'sali' => 'array',
            'bucati' => 'array'
        ]);

        // Update echipament
        DB::update("
            UPDATE echipamente 
            SET denumire_echipament = ?, 
                necesita_achizitie = ?
            WHERE id_echipament = ?
        ", [$request->denumire_echipament, $request->necesita_achizitie, $id]);

        // Ștergere distribuții existente
        DB::delete("DELETE FROM sali_echipamente WHERE id_echipament = ?", [$id]);

        // Inserare noi distribuții
        if ($request->sali) {
            foreach ($request->sali as $index => $id_sala) {
                if (isset($request->bucati[$index]) && $request->bucati[$index] > 0) {
                    DB::insert("
                        INSERT INTO sali_echipamente (id_sala, id_echipament, bucati)
                        VALUES (?, ?, ?)
                    ", [$id_sala, $id, $request->bucati[$index]]);
                }
            }
        }

        return redirect()->route('admin.echipamente.index')
                        ->with('success', 'Echipamentul a fost actualizat cu succes!');
    }

    public function destroy($id)
    {
        // Ștergere echipament și toate distribuțiile sale (CASCADE va șterge automat din sali_echipamente)
        DB::delete("DELETE FROM echipamente WHERE id_echipament = ?", [$id]);

        return redirect()->route('admin.echipamente.index')
                        ->with('success', 'Echipamentul a fost șters cu succes!');
    }

    // Metodă pentru raport echipamente care necesită achiziție
    public function raportEchipamenteNecesare()
    {
        $echipamente = DB::select("
            SELECT e.denumire_echipament,
                   e.necesita_achizitie,
                   (SELECT SUM(bucati) 
                    FROM sali_echipamente se 
                    WHERE se.id_echipament = e.id_echipament) as total_bucati,
                   (SELECT COUNT(DISTINCT id_sala) 
                    FROM sali_echipamente se 
                    WHERE se.id_echipament = e.id_echipament) as numar_sali
            FROM echipamente e
            WHERE e.necesita_achizitie = 1
            ORDER BY total_bucati ASC
        ");

        return view('echipamente.raport', compact('echipamente'));
    }
}