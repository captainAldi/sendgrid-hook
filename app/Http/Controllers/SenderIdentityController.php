<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SenderIdentity;

class SenderIdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_sender_identity = SenderIdentity::all();
        
        return view('sender-identity.index', compact('data_sender_identity'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sender-identity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Aturan Validasi
        $rule_validasi = [
            'kode'         => 'required',
            'deskripsi'     => 'required|min:5',
        ];

        // Custom Message
        $pesan_validasi = [
            'kode.required'        => 'kode Harus di Isi !',

            'deskripsi.required'    => 'Deskripsi Harus di Isi !',
            'deskripsi.min'         => 'Deskripsi Minimal 10 Karakter !'

        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = new SenderIdentity();
        $data_to_save->kode         = $request->kode;
        $data_to_save->deskripsi    = $request->deskripsi;

        // Save to DB
        $data_to_save->save();


        // Kembali dengan Flash Session Data
        return back()->with('pesan', 'Data Telah Disimpan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_sender_identity = SenderIdentity::findOrFail($id);

        return view('sender-identity.edit', compact('data_sender_identity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Aturan Validasi
        $rule_validasi = [
            'kode'         => 'required',
            'deskripsi'     => 'required|min:5',
        ];

        // Custom Message
        $pesan_validasi = [
            'kode.required'        => 'kode Harus di Isi !',

            'deskripsi.required'    => 'Deskripsi Harus di Isi !',
            'deskripsi.min'         => 'Deskripsi Minimal 10 Karakter !'

        ];

        // Lakukan Validasi
        $request->validate($rule_validasi, $pesan_validasi);

        // Mapping All Request 
        $data_to_save               = SenderIdentity::findOrFail($id);
        $data_to_save->kode         = $request->kode;
        $data_to_save->deskripsi    = $request->deskripsi;

        // Save to DB
        $data_to_save->save();


        // Kembali dengan Flash Session Data
        return back()->with('pesan', 'Data Telah Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Cek Data
        $data_to_delete = SenderIdentity::findOrFail($id);

        // Delete from DB
        $data_to_delete->delete();

        return back()->with('pesan', 'Data Berhasil di Hapus !');
    }
}
