<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrenori;

class AntrenoriController extends Controller
{
    public function index()
    {
        $antrenori = Antrenori::all();
        return view('antrenori.index', compact('antrenori'));
    }

    public function create()
    {
        return view('antrenori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nume' => 'required',
            'prenume' => 'required',
            'email' => 'required|email|unique:antrenori',
            'telefon' => 'required',
            'specializare' => 'required',
        ]);

        Antrenori::create($request->all());

        return redirect()->route('antrenori.index')->with('success', 'Antrenor adăugat cu succes!');
    }

    public function edit($id)
    {
        $antrenor = Antrenori::findOrFail($id);
        return view('antrenori.edit', compact('antrenor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nume' => 'required',
            'prenume' => 'required',
            'email' => 'required|email|unique:antrenori,email,' . $id,
            'telefon' => 'required',
        ]);

        $antrenor = Antrenori::findOrFail($id);
        $antrenor->update($request->all());

        return redirect()->route('antrenori.index')->with('success', 'Antrenor actualizat cu succes!');
    }

    public function destroy($id)
    {
        Antrenori::destroy($id);
        return redirect()->route('antrenori.index')->with('success', 'Antrenor șters cu succes!');
    }
}
