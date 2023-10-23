@extends('layout.layout')
@section('judul', 'Logs')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                    class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Pengurus Kelas</span>
                </a>
                <a href="{{ url('wali-kelas/akun-siswa') }}" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Siswa</span>
                </a>
                <a href="{{ url('wali-kelas/presensi-siswa') }}" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="{{ url('wali-kelas/logs') }}"class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')

    <h1 class="fs-1 fw-bold text-center" style="margin-bottom: 2px">Logs</h1>
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <input type="text" placeholder="Search Logs">
                <button class="position-relative">Search</button>
            </form>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Tabel</th>
                    <th scope="col">Aktor</th>
                    <th scope="col">Tanggal </th>
                    <th scope="col">Jam</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Record</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp

                @for ($i = 0; $i < count($logs); $i++)
                    @if ($logs[$i]->tabel !== 'guru' && $logs[$i]->aktor !== 'Tata Usaha')
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $logs[$i]->tabel }}</td>
                            <td>{{ $logs[$i]->aktor }}</td>
                            <td>{{ $logs[$i]->tanggal }}</td>
                            <td>{{ $logs[$i]->jam }}</td>
                            <th>{{ $logs[$i]->aksi }}</th>
                            <th>{{ $logs[$i]->record }}</th>
                        </tr>
                    @endif
                @endfor

            </tbody>
        </table>

    </div>

@endsection
