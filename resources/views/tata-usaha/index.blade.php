@extends('layout.layout')
@section('judul', 'Dashboard Tata Usaha')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }
</style>
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Home_White.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/jurusan" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Jurusan.svg')}}" alt=""><span>Jurusan</span>
                </a>
                <a href="/tata-usaha/kelas?filter_status=aktif" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Kelas.svg')}}" alt=""><span>Kelas</span>
                </a>
                <a href="/tata-usaha/akun-guru" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa?filter_status=aktif" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Siswa</span>
                </a>
                <a href="/tata-usaha/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg')}}" alt=""><span>Presensi</span>
                </a>
                <a href="/tata-usaha/logs" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Book.svg')}}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-4 mb-5">
                <div class="block bg-white">
                    <a href="/tata-usaha/akun-guru">
                        <div class="fs-1 color-text fw-bold">{{ $totalWaliKelas }}</div>
                        <span class="fs-3 text-nowrap">Wali Kelas</span>
                    </a>
                </div>
            </div>
            <div class="col-sm-4 mb-5">
                <a href="/tata-usaha/akun-guru?filter_status=1">
                    <div class="block bg-white">
                        <div class="fs-1 color-text fw-bold">{{ $totalGuruBk }}</div>
                        <span class="fs-3 text-nowrap">Guru BK</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 mb-5">
                <a href="/tata-usaha/akun-guru?filter_status=2">
                    <div class="block bg-white">
                        <div class="fs-1 color-text fw-bold">{{ $totalGuruPiket }}</div>
                        <span class="fs-3 text-nowrap">Guru Piket</span>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-5">
                <a href="/tata-usaha/kelas?filter_status=aktif">
                    <div class="block bg-white">
                        <div class="fs-1 color-text fw-bold">{{ $totalKelas }}</div>
                        <span class="fs-3 text-nowrap">Jumlah Kelas</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 mb-5">
                <a href="/tata-usaha/akun-pengurus-kelas">
                    <div class="block bg-white">
                        <div class="fs-1 color-text fw-bold">{{ $totalPengurusKelas }}</div>
                        <span class="fs-5 text-nowrap">Jumlah Pengurus Kelas</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-4 mb-5">
                <a href="/tata-usaha/akun-siswa?filter_status=aktif">
                    <div class="block bg-white">
                        <div class="fs-1 color-text fw-bold">{{ $totalSiswa }}</div>
                        <span class="fs-3 text-nowrap">Jumlah Siswa</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
