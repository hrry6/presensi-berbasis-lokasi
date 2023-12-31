@extends('group.layout')
@section('judul', 'Edit Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Kelas</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/kelas.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="id_kelas" value="{{ $kelas->id_kelas}}">
                        <div class="form-group">
                            <label>Tingkatan</label>
                            <select name="tingkatan" class="form-control">
                                <option value="" disabled>Pilih Tingkatan</option>
                                <option value="X" {{ $kelas->tingkatan == "X"?"selected" : ""}}>
                                    X
                                </option>
                                <option value="XI"{{ $kelas->tingkatan == "XI"?"selected" : ""}}>
                                    XI
                                </option>
                                <option value="XII"{{ $kelas->tingkatan == "XII"?"selected" : ""}}>
                                    XII
                                </option>
                            </select>
                            @error('tingkatan') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="id_jurusan" class="form-control">
                                <option value="" disabled>Pilih Tingkatan</option>
                                @foreach ($jurusan as $j)
                                <option value="{{ $j->id_jurusan }}" {{ $kelas->id_jurusan == $j->id_jurusan?"selected" : ""}}>
                                    {{ $j->nama_jurusan}}
                                </option>
                                @endforeach
                            </select>
                            @error('id_jurusan') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" value="{{ $kelas->nama_kelas}}">
                        </div>
                        @error('nama_kelas') 
                            <div class="invalid-feedback">
                                {{$message}}    
                            </div> 
                        @enderror
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status_kelas" class="form-control @error('status_kelas') is-invalid @enderror">
                                <option value="" disabled>Pilih Status</option>
                                <option value="aktif" {{ $kelas->status_kelas == "aktif"?"selected" : ""}}>
                                    Aktif
                                </option>
                                <option value="tidak_aktif"{{ $kelas->status_kelas == "tidak_aktif"?"selected" : ""}}>
                                    Tidak Aktif
                                </option>
                            </select>
                            @error('status_kelas') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button id="kembali"
                                class="btn text-decoration-underline text-light fw-bold rounded-3"
                                style="background-color: #14C345">KEMBALI</button>
                            <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                                style="background-color: #F9812A ">SUBMIT</button>
                        </div>
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