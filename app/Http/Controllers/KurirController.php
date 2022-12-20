<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurir;
use App\Http\Resources\KurirResource;
use Illuminate\Support\Facades\Validator;

class KurirController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get Kurir
        $kurir = Kurir::latest()->get();
        //render view with posts
        return new KurirResource(true, 'List Data Kurir', $kurir);
    }

    /**
    * create
    *
    * @return void
    */

    public function create()
    {
        return view('kurir.create');
    }

    public function show($id){
        $kurir = Kurir::find($id);
        return new KurirResource(true, 'Data Barang Berhasil Diambil', $kurir);
    }

    /**
    * store
    *
    * @param Request $request
    * @return void
    */
    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_kurir' => 'required|max:60',
            'umur_kurir' => 'required',
            'telp_kurir' => 'required|numeric',
            'gender_kurir' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
            
        //Fungsi Post ke Database
        $kurir = Kurir::create([
            'nama_kurir' => $request->nama_kurir,
            'umur_kurir' => $request->umur_kurir,
            'telp_kurir' => $request->telp_kurir,
            'gender_kurir' => $request->gender_kurir
        ]);

        return new KurirResource(true, 'Data Kurir Berhasil Ditambahkan!', $kurir);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_kurir' => 'required|max:60',
            'umur_kurir' => 'required',
            'telp_kurir' => 'required|numeric',
            'gender_kurir' => 'required'
        ]);


        if($validator->fails()){
            return (response()->json($validator->errors(), 422+ $id));
        }

        
        $kurir = Kurir::findorfail($id);
        $kurir->update([
            'nama_kurir' => $request->nama_kurir,
            'umur_kurir' => $request->umur_kurir,
            'telp_kurir' => $request->telp_kurir,
            'gender_kurir' => $request->gender_kurir
        ]);

        return new KurirResource(true, 'Data Barang Berhasil Diedit', $kurir);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $kurir = Kurir::findorfail($id);
        $this->validate($request, [
            'nama_kurir' => 'required|max:60',
            'umur_kurir' => 'required',
            'telp_kurir' => 'required|numeric',
            'gender_kurir' => 'required'
        ]);

        $kurir->update([
            'nama_kurir' => $request->nama_kurir,
            'umur_kurir' => $request->umur_kurir,
            'telp_kurir' => $request->telp_kurir,
            'gender_kurir' => $request->gender_kurir
        ]);

        try{
            // Mengisi variabel yang akan ditampilkan pada view mail
            $content = [
                'body' => $request->nama_kurir,
            ];

            //Redirect jika berhasil mengirim email
            return new KurirResource(true, 'Data Barang Berhasil Diedit', $kurir);
        }catch(Exception $e){

            //Redirect jika gagal mengirim email
            return new KurirResource(true, 'Data Barang Berhasil Diedit', $kurir);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $kurir = Kurir::find($id);
        $kurir->delete();
        return new KurirResource(true, 'Data Barang Berhasil Dihapus', $kurir);
    }
}