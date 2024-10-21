<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Pagination\Paginator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = Buku::all()->sortByDesc('id');
        $rowCount = Buku::count();
        $totalPrice = Buku::sum('harga');
        return view('index', compact('data_buku', 'rowCount', 'totalPrice'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
 * Searching
 */
public function search(Request $request)
{
    Paginator::useBootstrapFive();
    $cari = $request->kata;

    $data_buku = Buku::where('judul', 'like', "%" . $cari . "%")
        ->orWhere('penulis', 'like', '%' . $cari . '%')
        ->paginate(5);

    $rowCount = Buku::count(); // total data
    $totalPrice = Buku::sum('harga'); // total harga

    return view('index', compact('data_buku', 'cari', 'rowCount', 'totalPrice'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
        ], [
            'harga.numeric' => 'Harga harus berupa angka.',
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();
        return redirect ('/buku')->with('created', 'Data buku baru berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , $id)
    {
        $buku = Buku::find($id);
        return view('edit', compact('buku'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);
        // dd($buku);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();
        return redirect()->route('index')->with('updated', 'Data buku berhasil diperbarui');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect()->route('index')->with('deleted', 'Data buku berhasil dihapus');;
    }
}
