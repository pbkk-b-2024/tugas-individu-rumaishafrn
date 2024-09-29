<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanObat;
use App\Http\Requests\StorePenerimaanObatRequest;
use App\Http\Requests\UpdatePenerimaanObatRequest;
use Illuminate\Support\Facades\Auth;

class PenerimaanObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = PenerimaanObat::with('user', 'obat')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('penerimaan_obat.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenerimaanObatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaanObat $penerimaanObat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaanObat $penerimaanObat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenerimaanObatRequest $request, PenerimaanObat $penerimaanObat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaanObat $penerimaanObat)
    {
        //
    }
}
