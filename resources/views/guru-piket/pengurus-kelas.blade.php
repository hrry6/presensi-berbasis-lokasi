@extends('layout.layout')
@section('judul', 'Kelola Pengurus Kelas')
@section('sidenav')
    <nav id="sidebarMenu" class="d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/guru-piket/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/guru-piket/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Profile_White.svg')}}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/guru-piket/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Location.svg')}}" alt=""><span>Presensi</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <form action="" method="get" class="flex gap-3 flex-col w-auto mb-3" id="form">
            <div class=" flex w-full justify-content-between">
                <div class="flex gap-3">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword" value="{{ old('keyword', request('keyword')) }}" placeholder="Search Pengurus Kelas....">
                    <div class="input-group-append">
                        <button class="input-group-text bg-primary" > 
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
            </div> 
            <div class="flex gap-3">
                <select class="form-select filter" name="filter_jabatan" value="">
                    <option value="" {{ old('filter_jabatan', request('filter_jabatan'))==""?"selected" : "" }}>Pilih Jabatan</option>
                    <option value="ketua_kelas" {{ old('filter_jabatan', request('filter_jabatan'))=="ketua_kelas"?"selected" : "" }}>Ketua Kelas</option>
                    <option value="wakil_kelas" {{ old('filter_jabatan', request('filter_jabatan'))=="wakil_kelas"?"selected" : "" }}>Wakil Kelas</option>
                    <option value="sekertaris" {{ old('filter_jabatan', request('filter_jabatan'))=="sekertaris"?"selected" : "" }}>Sekertaris</option>
                </select>
                <select class="form-select filter" name="filter_kelas" value="">
                    <option value="" {{ old('filter_jurusan', request('filter_kelas')) == '' ? 'selected' : '' }}>
                        Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ old('filter_kelas', request('filter_kelas')) == "$k->id_kelas" ? 'selected' : '' }}>
                            {{ $k->tingkatan." ".$k->nama_jurusan." ".$k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengurus as $i)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            @if ($i->foto_siswa)
                                <img src="{{ url('foto') . '/' . $i->foto_siswa }} "
                                    style="max-width: 100px; height: auto;" alt="Siswa"/>
                            @endif
                        </td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <th>{{ $i->jabatan." ".$i->status_jabatan }}</th>
                        <td>{{ $i->tingkatan." ".$i->nama_jurusan." ".$i->nama_kelas}}</td>
                        <td class="flex justify-content-center">
                            <a href="/guru-piket/detail-pengurus-kelas/{{ $i->id_pengurus }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('footer')
    <script type="module">
        $('.DataTable tbody').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idHapus = $(this).closest('.btnHapus').attr('idHapus');
            swal.fire({
                title: "Apakah anda ingin menghapus data ini?",
                showCancelButton: true,
                confirmButtonText: 'Setuju',
                cancelButtonText: `Batal`,  
                confirmButtonColor: 'red'

            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(idHapus)
                    $.ajax({
                        type: 'DELETE',
                        url: '/tata-usaha/hapus-pengurus-kelas',
                        data: {
                            id_pengurus: idHapus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });
        $(".filter").on('change', function() {
            $("#form").submit();
        })
    </script>
@endsection
