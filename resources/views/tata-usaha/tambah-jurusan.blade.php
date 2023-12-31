@extends('group.layout')
@section('judul', 'Tambah Jurusan')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Jurusan</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/jurusan.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="simpan-jurusan" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_jurusan">Jurusan</label>
                            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror"  value="{{ old('nama_jurusan')}}" name="nama_jurusan">
                            @error('nama_jurusan') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
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