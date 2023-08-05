{{-- Pesan jika terdapat sebuah proses berhasil / sukses melakukan eksekusi dan memunculkan alert --}}

@if (Session::has('success'))
<div class="pt-3">
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
</div>
@else

@endif    

{{-- Kendali Error untuk Inputan Form Tambah Data Siswa --}}

@if ($errors->any())
<div class="pt-3">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
</div>
@else

@endif