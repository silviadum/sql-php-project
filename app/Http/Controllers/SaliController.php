<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaliController extends Controller
{
    public function index()
    {
        // Interogare complexă pentru a afișa sălile cu echipamentele și clasele lor
        $sali = DB::select("
            SELECT s.*,
                   (SELECT COUNT(*) FROM clase c WHERE c.id_sala = s.id_sala) as numar_clase,
                   (SELECT GROUP_CONCAT(e.denumire_echipament, ' (', se.bucati, ')')
                    FROM sali_echipamente se 
                    JOIN echipamente e ON se.id_echipament = e.id_echipament
                    WHERE se.id_sala = s.id_sala) as echipamente,
                   (SELECT COUNT(DISTINCT c.id_antrenor) 
                    FROM clase c 
                    WHERE c.id_sala = s.id_sala) as antrenori_activi
            FROM sali s
        ");

        return view('sali.index', compact('sali'));
    }

    public function create()
    {
        $echipamente = DB::select("SELECT * FROM echipamente");
        return view('sali.create', compact('echipamente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'denumire_sala' => 'required|string|max:100',
            'capacitate' => 'required|integer|min:1',
            'echipamente' => 'array',
            'bucati' => 'array'
        ]);

        // Inserare sală nouă
        DB::insert("
            INSERT INTO sali (denumire_sala, capacitate)
            VALUES (?, ?)
        ", [$request->denumire_sala, $request->capacitate]);

        $id_sala = DB::getPdo()->lastInsertId();

        // Inserare echipamente pentru sală
        if ($request->echipamente) {
            foreach ($request->echipamente as $index => $id_echipament) {
                if (isset($request->bucati[$index]) && $request->bucati[$index] > 0) {
                    DB::insert("
                        INSERT INTO sali_echipamente (id_sala, id_echipament, bucati)
                        VALUES (?, ?, ?)
                    ", [$id_sala, $id_echipament, $request->bucati[$index]]);
                }
            }
        }

        return redirect()->route('sali.index')
            ->with('success', 'Sala a fost adăugată cu succes!');
    }

    public function edit($id)
    {
        // Interogare JOIN pentru a obține sala și echipamentele ei
        $sala = DB::select("
            SELECT s.*, 
                   se.id_echipament,
                   se.bucati,
                   e.denumire_echipament
            FROM sali s
            LEFT JOIN sali_echipamente se ON s.id_sala = se.id_sala
            LEFT JOIN echipamente e ON se.id_echipament = e.id_echipament
            WHERE s.id_sala = ?
        ", [$id]);

        $echipamente = DB::select("SELECT * FROM echipamente");

        // Interogare pentru a obține clasele programate în sală
        $clase = DB::select("
            SELECT c.*, 
                   a.nume as antrenor_nume,
                   a.prenume as antrenor_prenume,
                   (SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) as membri_inscrisi
            FROM clase c
            JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            WHERE c.id_sala = ?
        ", [$id]);

        return view('sali.edit', compact('sala', 'echipamente', 'clase'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'denumire_sala' => 'required|string|max:100',
            'capacitate' => 'required|integer|min:1',
            'echipamente' => 'array',
            'bucati' => 'array'
        ]);

        // Update sală
        DB::update("
            UPDATE sali 
            SET denumire_sala = ?, 
                capacitate = ?
            WHERE id_sala = ?
        ", [$request->denumire_sala, $request->capacitate, $id]);

        // Ștergere echipamente existente
        DB::delete("DELETE FROM sali_echipamente WHERE id_sala = ?", [$id]);

        // Inserare echipamente noi
        if ($request->echipamente) {
            foreach ($request->echipamente as $index => $id_echipament) {
                if (isset($request->bucati[$index]) && $request->bucati[$index] > 0) {
                    DB::insert("
                        INSERT INTO sali_echipamente (id_sala, id_echipament, bucati)
                        VALUES (?, ?, ?)
                    ", [$id, $id_echipament, $request->bucati[$index]]);
                }
            }
        }

        return redirect()->route('sali.index')
            ->with('success', 'Sala a fost actualizată cu succes!');
    }

    public function destroy($id)
    {
        // Verificare dacă sala are clase programate
        $areClase = DB::select("
            SELECT 1 FROM clase WHERE id_sala = ? LIMIT 1
        ", [$id]);

        if (!empty($areClase)) {
            return redirect()->route('sali.index')
                ->with('error', 'Nu se poate șterge sala deoarece are clase programate!');
        }

        // Ștergere sală și echipamentele asociate (CASCADE va șterge din sali_echipamente)
        DB::delete("DELETE FROM sali WHERE id_sala = ?", [$id]);

        return redirect()->route('sali.index')
            ->with('success', 'Sala a fost ștearsă cu succes!');
    }

    public function ocupare()
    {
        // Raport de ocupare a sălilor
        $ocupare = DB::select("
            SELECT s.denumire_sala,
                   s.capacitate,
                   c.denumire_clasa,
                   a.nume || ' ' || a.prenume as antrenor,
                   (SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) as membri_inscrisi,
                   ROUND((SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) * 100.0 / s.capacitate, 2) as grad_ocupare
            FROM sali s
            LEFT JOIN clase c ON s.id_sala = c.id_sala
            LEFT JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            WHERE c.id_clasa IS NOT NULL
            ORDER BY grad_ocupare DESC
        ");

        return view('sali.ocupare', compact('ocupare'));
    }
}