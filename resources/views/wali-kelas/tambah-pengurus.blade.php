@extends('group.layout')
@section('judul', 'Dashboard Wali Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Pengurus Kelas</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/pengurus-form.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px;">
                    <form action="simpan-pengurus-kelas" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Pilih Siswa</label>
                            <select name="id_siswa" class="form-control">
                                <option value="" selected disabled>Pilih Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                            class="btn text-decoration-underline text-light fw-bold rounded-3"
                            style="background-color: #14C345">KEMBALI</a>
                        <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                            style="background-color: #F9812A ">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
