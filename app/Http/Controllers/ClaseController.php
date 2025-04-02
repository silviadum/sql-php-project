<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaseController extends Controller
{
    public function index()
    {
        $clase = DB::select("
            SELECT c.*, 
                   a.nume as antrenor_nume, 
                   a.prenume as antrenor_prenume,
                   s.denumire_sala,
                   s.capacitate,
                   (SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) as numar_inscrisi
            FROM clase c
            JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            JOIN sali s ON c.id_sala = s.id_sala
            ORDER BY c.denumire_clasa
        ");

        return view('clase.index', compact('clase'));
    }

    public function inscriere(Request $request, $id_clasa)
    {
        // Verifică dacă membrul este deja înscris
        $existaInscriere = DB::select("
            SELECT * FROM membri_clase 
            WHERE id_membru = ? AND id_clasa = ?
        ", [auth()->id(), $id_clasa]);

        if (empty($existaInscriere)) {
            // Verifică capacitatea sălii
            $capacitate = DB::select("
                SELECT s.capacitate, 
                       (SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) as numar_inscrisi
                FROM clase c
                JOIN sali s ON c.id_sala = s.id_sala
                WHERE c.id_clasa = ?
            ", [$id_clasa]);

            if ($capacitate[0]->numar_inscrisi < $capacitate[0]->capacitate) {
                DB::insert("
                    INSERT INTO membri_clase (id_membru, id_clasa) 
                    VALUES (?, ?)
                ", [auth()->id(), $id_clasa]);

                return redirect()->back()->with('success', 'V-ați înscris cu succes la clasă!');
            }
            
            return redirect()->back()->with('error', 'Ne pare rău, clasa este plină!');
        }

        return redirect()->back()->with('error', 'Sunteți deja înscris la această clasă!');
    }

    public function anulareInscriere($id_clasa)
    {
        DB::delete("
            DELETE FROM membri_clase 
            WHERE id_membru = ? AND id_clasa = ?
        ", [auth()->id(), $id_clasa]);

        return redirect()->back()->with('success', 'Înscrierea a fost anulată cu succes!');
    }

    // Pentru antrenori
    public function claseleAntrenorului()
    {
        $clase = DB::select("
            SELECT c.*, 
                   s.denumire_sala,
                   (SELECT COUNT(*) FROM membri_clase mc WHERE mc.id_clasa = c.id_clasa) as numar_inscrisi
            FROM clase c
            JOIN sali s ON c.id_sala = s.id_sala
            WHERE c.id_antrenor = ?
        ", [auth()->id()]);

        return view('clase.antrenor', compact('clase'));
    }

    public function create()
    {
        $sali = DB::select("SELECT * FROM sali WHERE id_sala NOT IN (SELECT id_sala FROM clase)");
        return view('clase.create', compact('sali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'denumire_clasa' => 'required',
            'durata' => 'required',
            'id_sala' => 'required'
        ]);

        DB::insert("
            INSERT INTO clase (denumire_clasa, durata, id_antrenor, id_sala) 
            VALUES (?, ?, ?, ?)
        ", [
            $request->denumire_clasa,
            $request->durata,
            auth()->id(),
            $request->id_sala
        ]);

        return redirect()->route('clase.antrenor')->with('success', 'Clasa a fost creată cu succes!');
    }

    public function destroy($id)
    {
        DB::delete("DELETE FROM clase WHERE id_clasa = ? AND id_antrenor = ?", [$id, auth()->id()]);
        return redirect()->back()->with('success', 'Clasa a fost ștearsă cu succes!');
    }

    // Interogare complexă pentru statistici
    public function statisticiClase()
    {
        $statistici = DB::select("
            SELECT c.denumire_clasa,
                   a.nume as antrenor_nume,
                   a.prenume as antrenor_prenume,
                   s.denumire_sala,
                   s.capacitate,
                   COUNT(mc.id_membru) as membri_inscrisi,
                   ROUND((COUNT(mc.id_membru) * 100.0 / s.capacitate), 2) as grad_ocupare
            FROM clase c
            JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            JOIN sali s ON c.id_sala = s.id_sala
            LEFT JOIN membri_clase mc ON c.id_clasa = mc.id_clasa
            GROUP BY c.id_clasa, c.denumire_clasa, a.nume, a.prenume, s.denumire_sala, s.capacitate
            ORDER BY grad_ocupare DESC
        ");

        return view('clase.statistici', compact('statistici'));
    }
    public function deleteClasa(Request $request)
    {
        $request->validate([
            'id_clasa' => 'required|integer',
        ]);

        DB::table('clase')->where('id_clasa', $request->id_clasa)->delete();

        return response()->json(['success' => 'Clasa a fost ștearsă cu succes.']);
    }
}