<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticiController extends Controller
{
    // 1. Clase Populate
    public function getClasePopulate()
    {
        $clase = DB::select("
            SELECT c.id_clasa, c.denumire_clasa, 
                   CONCAT(a.nume, ' ', a.prenume) as antrenor,
                   s.denumire_sala,
                   s.capacitate,
                   COUNT(mc.id_membru) as numar_membri
            FROM clase c
            JOIN antrenori a ON c.id_antrenor = a.id_antrenor
            JOIN sali s ON c.id_sala = s.id_sala
            LEFT JOIN membri_clase mc ON c.id_clasa = mc.id_clasa
            GROUP BY c.id_clasa, c.denumire_clasa, a.nume, a.prenume, s.denumire_sala, s.capacitate
            ORDER BY c.denumire_clasa
        ");
    
        return view('admin.rapoarte.clase-populate', compact('clase'));
    }

    public function updateClasePopulate(Request $request)
    {
        $data = $request->validate([
            'id_clasa' => 'required|integer',
            'denumire_clasa' => 'sometimes|string',
            'capacitate' => 'sometimes|integer',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('clase')->where('id_clasa', $data['id_clasa'])->update($updateData);

        return response()->json(['success' => 'Clasa a fost actualizată cu succes.']);
    }

    // 2. Echipamente pe Săli
    public function getEchipamentePeSali()
    {
        $echipamente = DB::select("
            SELECT se.id_sala, se.id_echipament, s.denumire_sala, 
                   e.denumire_echipament, se.bucati
            FROM sali s
            JOIN sali_echipamente se ON s.id_sala = se.id_sala
            JOIN echipamente e ON se.id_echipament = e.id_echipament
            ORDER BY s.denumire_sala, e.denumire_echipament
        ");

        // Grupăm rezultatele pe săli
        $saliEchipamente = [];
        foreach ($echipamente as $echipament) {
            $saliEchipamente[$echipament->denumire_sala][] = $echipament;
        }

        return view('admin.rapoarte.echipamente-sali', compact('saliEchipamente'));
    }

    public function updateEchipamentePeSali(Request $request)
    {
        $data = $request->validate([
            'id_echipament' => 'required|integer',
            'denumire_echipament' => 'sometimes|string',
            'bucati' => 'sometimes|integer',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('sali_echipamente')->where('id_echipament', $data['id_echipament'])->update($updateData);

        return response()->json(['success' => 'Echipamentul a fost actualizat cu succes.']);
    }

    // 3. Membri și Antrenori
    public function getMembriCuAntrenori()
    {
        $membri = DB::select("
            SELECT m.id_membru, m.nume, m.prenume, m.email,
                   CONCAT(a.nume, ' ', a.prenume) as antrenor,
                   a.specializare
            FROM membri m
            LEFT JOIN antrenori a ON m.id_antrenor = a.id_antrenor
            WHERE m.email != 'admin'
            ORDER BY m.nume, m.prenume
        ");

        return view('admin.rapoarte.membri-antrenori', compact('membri'));
    }

    public function updateMembriCuAntrenori(Request $request)
    {
        $data = $request->validate([
            'id_membru' => 'required|integer',
            'id_antrenor' => 'sometimes|integer',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('membri')->where('id_membru', $data['id_membru'])->update($updateData);

        return response()->json(['success' => 'Membrul a fost actualizat cu succes.']);
    }

    // 4. Abonamente Active
    public function getAbonamenteActive()
    {
        $abonamente = DB::select("
            SELECT a.id_abonament, m.nume, m.prenume,
                   a.tip_abonament,
                   a.data_sfarsit,
                   DATEDIFF(a.data_sfarsit, CURDATE()) as zile_ramase
            FROM membri m
            JOIN abonamente a ON m.id_membru = a.id_membru
            WHERE a.data_sfarsit >= CURDATE()
            ORDER BY a.data_sfarsit ASC
        ");

        return view('admin.rapoarte.abonamente-active', compact('abonamente'));
    }

    public function updateAbonamenteActive(Request $request)
    {
        $data = $request->validate([
            'id_abonament' => 'required|integer',
            'tip_abonament' => 'sometimes|string',
            'data_sfarsit' => 'sometimes|date',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('abonamente')->where('id_abonament', $data['id_abonament'])->update($updateData);

        return response()->json(['success' => 'Abonamentul a fost actualizat cu succes.']);
    }

    // 5. Statistici Antrenori
    public function getStatisticiAntrenori()
    {
        $antrenori = DB::select("
            SELECT a.id_antrenor, a.nume, a.prenume, a.specializare,
                   COUNT(DISTINCT m.id_membru) as membri_personali,
                   COUNT(DISTINCT c.id_clasa) as clase_predate,
                   (SELECT COUNT(DISTINCT mc.id_membru)
                    FROM membri_clase mc
                    JOIN clase c2 ON mc.id_clasa = c2.id_clasa
                    WHERE c2.id_antrenor = a.id_antrenor) as total_membri_clase
            FROM antrenori a
            LEFT JOIN membri m ON a.id_antrenor = m.id_antrenor
            LEFT JOIN clase c ON a.id_antrenor = c.id_antrenor
            GROUP BY a.id_antrenor, a.nume, a.prenume, a.specializare
            ORDER BY total_membri_clase DESC
        ");

        return view('admin.rapoarte.statistici-antrenori', compact('antrenori'));
    }

    public function updateStatisticiAntrenori(Request $request)
    {
        $data = $request->validate([
            'id_antrenor' => 'required|integer',
            'specializare' => 'sometimes|string',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('antrenori')->where('id_antrenor', $data['id_antrenor'])->update($updateData);

        return response()->json(['success' => 'Antrenorul a fost actualizat cu succes.']);
    }

    // 6. Top Membri
    public function getTopMembri()
    {
        $membri = DB::select("
            SELECT m.id_membru, m.nume, m.prenume,
                   COUNT(DISTINCT mc.id_clasa) as participari_clase,
                   COUNT(DISTINCT a.id_abonament) as numar_abonamente,
                   SUM(a.pret) as total_platit
            FROM membri m
            LEFT JOIN membri_clase mc ON m.id_membru = mc.id_membru
            LEFT JOIN abonamente a ON m.id_membru = a.id_membru
            WHERE m.email != 'admin'
            GROUP BY m.id_membru, m.nume, m.prenume
            ORDER BY participari_clase DESC, total_platit DESC
            LIMIT 10
        ");

        return view('admin.rapoarte.top-membri', compact('membri'));
    }

    public function updateTopMembri(Request $request)
    {
        $data = $request->validate([
            'id_membru' => 'required|integer',
            'nume' => 'sometimes|string',
            'prenume' => 'sometimes|string',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('membri')->where('id_membru', $data['id_membru'])->update($updateData);

        return response()->json(['success' => 'Membrul a fost actualizat cu succes.']);
    }

    // 7. Utilizare Săli
    public function getSaliUtilizare()
    {
        $sali = DB::select("
            SELECT s.id_sala, s.denumire_sala, s.capacitate,
                   COUNT(DISTINCT c.id_clasa) as numar_clase,
                   COUNT(DISTINCT se.id_echipament) as numar_echipamente,
                   SUM(se.bucati) as total_echipamente
            FROM sali s
            LEFT JOIN clase c ON s.id_sala = c.id_sala
            LEFT JOIN sali_echipamente se ON s.id_sala = se.id_sala
            GROUP BY s.id_sala, s.denumire_sala, s.capacitate
            ORDER BY numar_clase DESC
        ");

        return view('admin.rapoarte.utilizare-sali', compact('sali'));
    }

    public function updateSaliUtilizare(Request $request)
    {
        $data = $request->validate([
            'id_sala' => 'required|integer',
            'denumire_sala' => 'sometimes|string',
            'capacitate' => 'sometimes|integer',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('sali')->where('id_sala', $data['id_sala'])->update($updateData);

        return response()->json(['success' => 'Sala a fost actualizată cu succes.']);
    }

    // 8. Statistici Abonamente
    public function getStatisticiAbonamente()
    {
        $statistici = DB::select("
            SELECT id_abonament as id, tip_abonament,
                   COUNT(*) as total_vandute,
                   SUM(CASE WHEN data_sfarsit >= CURDATE() THEN 1 ELSE 0 END) as active_curent,
                   SUM(pret) as venit_total,
                   AVG(DATEDIFF(data_sfarsit, data_incepere)) as durata_medie
            FROM abonamente
            GROUP BY tip_abonament
            ORDER BY total_vandute DESC
        ");

        return view('admin.rapoarte.statistici-abonamente', compact('statistici'));
    }

    public function updateStatisticiAbonamente(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
            'total_vandute' => 'sometimes|integer',
            'active_curent' => 'sometimes|integer',
            'venit_total' => 'sometimes|numeric',
            'durata_medie' => 'sometimes|numeric',
        ]);

        $updateData = array_filter($data, function($value) {
            return !is_null($value);
        });

        DB::table('abonamente')->where('id_abonament', $data['id'])->update($updateData);

        return response()->json(['success' => 'Statistica abonamentului a fost actualizată cu succes.']);
    }

    // 9. Venituri pe Antrenor 
    public function getVenituriPeAntrenor()
    {
        $venituri = DB::select("
            SELECT a.id_antrenor, CONCAT(a.nume, ' ', a.prenume) as antrenor,
                SUM(a2.pret) as venit_total
            FROM antrenori a
            JOIN membri m ON a.id_antrenor = m.id_antrenor
            JOIN abonamente a2 ON m.id_membru = a2.id_membru
            GROUP BY a.id_antrenor, a.nume, a.prenume
            ORDER BY venit_total DESC
        ");

        return view('admin.rapoarte.venituri-antrenori', compact('venituri'));
    }

    // 10. Participare Membri la Clase 
    public function getParticipareMembriClase()
    {
        $participare = DB::select("
            SELECT m.id_membru, CONCAT(m.nume, ' ', m.prenume) as membru,
                   COUNT(mc.id_clasa) as numar_clase
            FROM membri m
            JOIN membri_clase mc ON m.id_membru = mc.id_membru
            GROUP BY m.id_membru, m.nume, m.prenume
            ORDER BY numar_clase DESC
        ");

        return view('admin.rapoarte.participare-membri-clase', compact('participare'));
    }
}