@extends('mahasiswa.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="row justify-content-center">
                <h1>KARTU HASIL STUDY (KHS)</h1>
            </div>
        </div>
    </div>

    <div class="row justify-content-left">
        <h3><b>Nama : </b>{{ $Mahasiswa->nama }}<h3>
        <h3><b>NIM : </b>{{ $Mahasiswa->nim }}</h3>
        <h3><b>Kelas : </b>{{ $Mahasiswa->kelas->nama_kelas }}</h3>
    </div>

    <table class="table table-bordered">
        <tr>
            <th style="text-align: center">Mata Kuliah</th>
            <th style="text-align: center">SKS</th>
            <th style="text-align: center">Semester</th>
            <th style="text-align: center">Nilai</th>
        </tr>
        @foreach($matakuliah as $matkul)
        <tr>
        
            <td>{{ $matkul->nama_matkul }}</td>
            <td>{{ $matkul->sks }}</td>
            <td>{{ $matkul->semester }}</td>
            <td>{{ $matkul->nilai }}</td>
        </tr>
        @endforeach
    </table>