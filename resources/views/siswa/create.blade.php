@extends('layouts.template')

@section('content')

    <form action="{{ url('siswa') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="my-0 p-5 bg-body rounded shadow-sm">
        <div class="pb-1">
            <h2>Data Dummy | <label style="color:rgb(113, 113, 113);">Tambah Data</label></h2>
            <p>PT. Lifetech Tanpa Batas</p>
        </div>
    
        <div class="mb-3 row">
            <label for="nis" class="col-sm-2 col-form-label">NIS</label>
            <div class="col-sm-10">
                <input class="form-control" value="{{ Session::get('nis') }}" name='nis' id="nis" placeholder="11907084">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ Session::get('nama') }}" name='nama' id="nama" placeholder="David Satya Wibisono">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ Session::get('jurusan') }}" name='jurusan' id="jurusan" placeholder="Rekayasa Perangkat Lunak">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ Session::get('jk') }}" name='jk' id="jk" placeholder="Laki-laki/Perempuan">
            </div>
        </div>
        <div class="row">
            <label for="fotosiswa" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input type="file" class="form-control @error('fotosiswa') is-invalid @enderror" value="{{ Session::get('fotosiswa') }}" id="fotosiswa" name="fotosiswa"
                accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                @error('fotosiswa')
                    <span class="invalid-feedback" role="alert">
                        <strong>Error load image</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <div class="mt-3"><img style="border-radius: 100%;" src="{{ asset('img/default-profile.png') }}" id="output" width="100"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jurusan" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <a href="{{ url('siswa') }}" class="btn btn-outline-success"><i class="bi bi-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-primary" name="submit">Simpan Data</button>
            </div>
        </div>
    </div>
    </form>
@endsection