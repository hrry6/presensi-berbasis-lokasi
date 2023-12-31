<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\PresensiSiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class GuruBkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('guru-bk.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function detailProfil(Request $request, Guru $guru)
    {
        $id_guru = $guru->where('id_akun', $request->id)->first()->id_guru;
        $data = [
            "guru" => $guru
            ->join('akun', 'guru.id_akun', '=','akun.id_akun')
            ->where('id_guru', $id_guru)->first()
        ];
        return view('guru-bk.detail-profil', $data);
    }

    public function showPresensi(Request $request, Kelas $kelas, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi);
        $data = [
            'presensi' => $filter,
            'kelas' => $kelas->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->orderBy('tingkatan')->orderBy('nama_kelas')->get()
        ];
        return view('guru-bk.presensi', $data);
    }
    private function filterPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $presensi
                ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->where(function ($query) use ($request) {
                    $query->where('nama_siswa', 'LIKE', "%$request->keyword%")
                    ->orwhere('tanggal', 'LIKE', "%$request->keyword%")
                    ->orwhere('status_kehadiran', 'LIKE', "%$request->keyword%")
                    ->orwhere('tingkatan', 'LIKE', "%$request->keyword%")
                    ->orwhere('nama_jurusan', 'LIKE', "%$request->keyword%")
                    ->orwhere('nama_kelas', 'LIKE', "%$request->keyword%");
                });
            if($request->filter_bulan != null)
            {
                $filter = $filter->whereMonth('tanggal',"$request->filter_bulan");
            }
            if($request->filter_tanggal != null)
            {
                $filter = $filter->where('tanggal','LIKE',"%$request->filter_tanggal%" );
            }
            if($request->filter_kehadiran != null)
            {
                $filter = $filter->where('status_kehadiran',$request->filter_kehadiran );
            }
            if($request->filter_kelas != null)
            {
                $filter = $filter->where('kelas.id_kelas',$request->filter_kelas );
            }
        return $filter->get();
    }

    public function detailPresensi(Request $request, PresensiSiswa $presensi)
    {
        $data = [
            'presensi' => $presensi
            ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->where('id_presensi', $request->id)->first()
        ];
        // dd($data);
        return view('guru-bk.detail-presensi', $data);
    }

    public function exportPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi); 
        $pdf = PDF::loadView('presensi-pdf', ['presensi' => $filter]);
        return $pdf->download('presensi.pdf');
    }
}