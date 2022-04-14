<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Models\Kelas;

class MahasiswaController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index()
 {
    //yang semula Mahasiswa:all, diubah menjadi with() yang menyatakan relasi
    $mahasiswa = Mahasiswa::with('kelas')->get();
    //fungsi eloquent menampilkan data menggunakan pagination
   //  $mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3); // Mengambil semua isi tabel
    $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
    return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
 }

 public function search(Request $request){
      $cari = $request->search;

      $mahasiswa = DB::table('mahasiswa')
            ->where('nama', 'like', '%' .$cari. '%')
            ->paginate(1);

      return view('mahasiswa.index', ['mahasiswa' => $mahasiswa]);
 }

 public function create()
 {
    $kelas = Kelas::all();//mendapatkan data dari tabel kelas
    return view('mahasiswa.create', ['kelas' => $kelas]);
 }
 
 public function store(Request $request)
 {
 //melakukan validasi data
    $request->validate([
    'Nim' => 'required',
    'Nama' => 'required',
    'Kelas' => 'required',
    'Jurusan' => 'required',
    ]);
    //fungsi eloquent untuk menambah data

    $mahasiswa = new Mahasiswa;
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');

    //fungsi eloquent untuk menambah data dengan relasi belongsTo
    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();

    //jika data berhasil ditambahkan, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
 }

 public function show($Nim)
 {
    //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
    //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);
    $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();

    return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
 }

 public function edit($Nim)
 {
    //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit

    $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
    $kelas = Kelas::all();//mendapatkan data dari tabel kelas
    return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));

 }
 public function update(Request $request, $Nim)
 {
    //melakukan validasi data
    $request->validate([
    'Nim' => 'required',
    'Nama' => 'required',
    'Email' => 'required',
    'Kelas' => 'required',
    'Jurusan' => 'required',
    'Alamat' => 'required',
    'tanggal_lahir' => 'required',
    ]);
    
    $mahasiswa = Mahasiswa::with('kelas')->where('nim', $NIm)->first();
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('kelas');

    //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();

    //jika data berhasil diupdate, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
 }

 public function destroy( $Nim)
 {
    //fungsi eloquent untuk menghapus data
    Mahasiswa::find($Nim)->delete();
    return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
 }
};