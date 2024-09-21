<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BilanganController extends Controller
{
    //
    public function ganjilgenap(Request $request)
    {
        $bilangan = null;
        $hasil = null;
        // jika input bilangan tidak kosong maka proses
        if ($request->input('bilangan')) {
            $bilangan = $request->input('bilangan');
            if ($bilangan % 2 == 0) {
                $hasil = 'Genap';
            } else {
                $hasil = 'Ganjil';
            }
        }
        return view('pertemuan1.ganjilgenap', compact('bilangan', 'hasil'));
    }

    public function fibonacci(Request $request)
    {
        $bilangan = null;
        $hasil = null;
        // jika input bilangan tidak kosong maka proses
        if ($request->input('bilangan')) {
            $bilangan = $request->input('bilangan');
            $a = 0;
            $b = 1;
            $hasil = '';
            for ($i = 0; $i < $bilangan; $i++) {
                $hasil .= $a . ' ';
                $c = $a + $b;
                $a = $b;
                $b = $c;
            }
        }
        return view('pertemuan1.fibonacci', compact('bilangan', 'hasil'));
    }

    public function prima(Request $request)
    {
        $bilangan = null;
        $hasil = null;
        // jika input bilangan tidak kosong maka proses
        if ($request->input('bilangan')) {
            $bilangan = $request->input('bilangan');
            $count = 0;
            for ($i = 1; $i <= $bilangan; $i++) {
                if ($bilangan % $i == 0) {
                    $count++;
                }
            }
            if ($count == 2) {
                $hasil = 'angka prima';
            } else {
                $hasil = 'bukan angka prima';
            }
        }
        return view('pertemuan1.prima', compact('bilangan', 'hasil'));
    }
}
