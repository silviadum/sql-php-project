<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membri;
use App\Models\Antrenori;

class AdminController extends Controller
{
    // Dashboard-ul admin
    public function index()
    {
        $membri = Membri::all();
        $antrenori = Antrenori::all();
        return view('admin.dashboard', compact('membri', 'antrenori'));
    }

    // Șterge membru
    public function deleteMembru($id)
    {
        Membri::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Membrul a fost șters.');
    }

    // Șterge antrenor
    public function deleteAntrenor($id)
    {
        Antrenori::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Antrenorul a fost șters.');
    }
}
