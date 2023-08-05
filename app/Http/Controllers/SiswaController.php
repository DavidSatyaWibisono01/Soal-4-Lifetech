<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Siswa as ModelMhs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 10;

        if (strlen($katakunci)) {
            $data = ModelMhs::where('nis', 'like', "%$katakunci%")
            ->orWhere('nama', 'like', "%$katakunci%")
            ->orWhere('jenis_kelamin', 'like', "%$katakunci%")
            ->orWhere('jurusan', 'like', "%$katakunci%")
            ->paginate($jumlahbaris);

        } else {
            $data = ModelMhs::orderBy('nis', 'desc')->paginate($jumlahbaris);
        }

        return view('siswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('nis', $request->nis);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
        Session::flash('jk', $request->jk);

        $request->validate([
            'nis' => 'required|numeric|unique:siswa,nis',
            'nama' => 'required',
            'jurusan' => 'required',
            'jk' => 'required',
            'fotosiswa' => 'required|mimes:jpeg,jpg,png,gif'
        ], [
            'nis.required' => 'NIS harus diisi',
            'nis.numeric' => 'NIS harus berisikan Angka',
            'nis.unique' => 'NIS sudah terdaftar di database!',

            'nama.required' => 'Nama harus diisi',
            'jurusan.required' => 'Jurusan harus diisi',
            'jk.required' => 'Anda harus memilih Jenis Kelamin',
            'fotosiswa' => 'Anda harus memilih foto siswa',
            'fotosiswa.mimes' => 'Foto hanya di perbolehkan yang berekstensi jpeg, jpg, png atau gif!' 
        ]);

        $foto_file = $request->file('fotosiswa');
        $foto_ext = $foto_file->extension();
        $rename_foto = date('ymdhis').".".$foto_ext;
        $foto_file->move(public_path('pictures'), $rename_foto);

        $data = [
            'nis' => $request->nis,
            'foto_siswa' => $rename_foto,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jk,
            'jurusan' => $request->jurusan,
        ];
        ModelMhs::create($data);
        return redirect()->to('siswa')->with('success', 'Berhasil menambahkan data Siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'Hi '.$id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ModelMhs::where('nis', $id)->first();
        return view('siswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jk' => 'required',
            'jurusan' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi',
            'jurusan.required' => 'Jurusan harus diisi',
            'jk.required' => 'Jenis kelamin harus diisi'
        ]);
        $data = [
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jk,
            'jurusan' => $request->jurusan,
        ];

        if ($request->hasFile('fotosiswa')) {
            $request->validate([
                'fotosiswa' => 'mimes:jpeg,jpg,png,gif'
            ], [
                'fotosiswa' => 'Anda harus memilih foto siswa',
                'fotosiswa.mimes' => 'Foto hanya di perbolehkan yang berekstensi jpeg, jpg, png atau gif!' 
            ]);

            $foto_file = $request->file('fotosiswa');
            $foto_ext = $foto_file->extension();
            $rename_foto = 'update-'.date('ymdhis').".".$foto_ext;
            $foto_file->move(public_path('pictures'), $rename_foto); // Sudah terupload ke direktori

            $data_foto = ModelMhs::where('nis', $id)->first();
            File::delete(public_path('pictures').'/'.$data_foto->foto_siswa);

            $data['foto_siswa'] = $rename_foto;
        }
        

        ModelMhs::where('nis', $id)->update($data);
        return redirect()->to('siswa')->with('success', 'Berhasil melakukan perubahan data siswa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataReadyDel = ModelMhs::where('nis', $id)->first();
        File::delete(public_path('pictures').'/'.$dataReadyDel->foto_siswa);

        ModelMhs::where('nis', $id)->delete();
        return redirect()->to('siswa')->with('success', 'Berhasil menghapus data siswa');
    }
}
