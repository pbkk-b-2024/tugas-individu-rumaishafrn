<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\APIController as Controller;
use Illuminate\Http\Request;
use App\Models\LaporanStok;

class LaporanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = LaporanStok::with('stokObat')
            ->orderBy('created_at', 'DESC')
            ->get();
        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
