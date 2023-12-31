@extends('group.layout')
@section('judul', 'Edit Pengurus Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Pengurus Kelas</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/pengurus-form.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="update" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa" value="{{ $pengurus->nama_siswa }}"
                                disabled id="">
                            <input type="hidden" class="form-control" name="id_pengurus"
                                value="{{ $pengurus->id_pengurus }}">
                        </div>
                        <div class="form-group">
                            <label for="status_jabatan">Jabatan</label>
                            <select name="status_jabatan" class="form-control">
                                <option value="" disabled>Pilih Jabatan</option>
                                <option value="ketua_kelas" {{ $pengurus->status_jabatan == 'ketua_kelas'? 'selected' : '' }}>Ketua Kelas</option>
                                <option value="wakil_kelas" {{ $pengurus->status_jabatan == 'wakil_kelas'? 'selected' : '' }}>Wakil Kelas</option>
                                <option value="sekretaris" {{ $pengurus->status_jabatan == 'sekretaris'? 'selected' : '' }}>Sekretaris</option>
                                <option value="bendahara" {{ $pengurus->status_jabatan == 'bendahara'? 'selected' : '' }}>Bendahara</option>
                            </select>
                        </div> <br><br>
                        <button id="kembali"
                            class="btn text-decoration-underline text-light fw-bold rounded-3"
                            style="background-color: #14C345">KEMBALI</button>
                        <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                            style="background-color: #F9812A ">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script type="module">
        $(document).ready(function(){
            $('#kembali').on('click', function(){
                window.history.back();
            });
        });
    </script>
@endsection