<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class WaliKelasController extends Controller
{
    public function index()
    {
        $totalSiswa = DB::select("SELECT CountTotalStudents() as totalSiswa")[0]->totalSiswa;
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('wali-kelas.index', compact('totalSiswa', 'totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function showSiswa()
    {
        $data = DB::table('view_siswa')->get();
        return view('wali-kelas.siswa', ['siswa' => $data]);
    }

    public function showPengurus(PengurusKelas $pengurus)
    {
        $data = [
            'pengurus' => $pengurus
                ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')->get()
        ];
        return view('wali-kelas.pengurus-kelas', $data);
    }

    public function showPresensi(PresensiSiswa $presensi)
    {
        $data = [
            'presensi' => $presensi
                ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get()
        ];

        // dd($data);
        return view('wali-kelas.presensi', $data);
    }

    public function createSiswa(Kelas $kelas, Siswa $siswa)
    {
        $jenisKelamin = ['laki-laki', 'perempuan'];

        $kelas = $kelas
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->get();
            
        $siswa->all();
        return view('wali-kelas.tambah-siswa', ["kelas" => $kelas, 'jenisKelamin' => $jenisKelamin, 'siswa' => $siswa]);
    }

    public function createPengurus(Siswa $siswa)
    {
        $siswa = $siswa->all();
        return view('wali-kelas.tambah-pengurus', ["siswa" => $siswa]);
    }

    public function storeSiswa(Request $request, Role $role)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'foto_siswa' => 'required',
        ]);

        $user = Auth::user();
        $data['id_akun'] = $user->id_akun;
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;;

        if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('siswa'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        }

        DB::statement("CALL CreateSiswa(?, ?, ?, ?, ?, ?, ?, ?)", [$user->id_akun, $data['nis'], $data['nama_siswa'], $data['id_kelas'], $data['jenis_kelamin'], $data['nomer_hp'], $foto_nama, $role_akun->nama_role]);

        notify()->success('Data siswa telah ditambah', 'Success');
        return redirect('wali-kelas/akun-siswa');
    }


    public function storePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
        $data = $request->validate([
            'id_siswa' => 'required',
            'jabatan' => 'required'
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;


        if ($pengurus->create($data)) {
            notify()->success('Data pengurus kelas telah ditambah', 'Success');
            return redirect('wali-kelas/akun-pengurus-kelas')->with('success', 'Data pengurus kelas berhasil ditambah');
        }

        return back()->with('error', 'Data pengurus kelas gagal ditambahkan');
    }

    public function editSiswa(Request $request, Kelas $kelas, Siswa $siswa)
    {
        $jenisKelamin = ['laki-laki', 'perempuan'];

        $data = [
            "siswa" => $siswa->where('id_siswa', $request->id)
                ->join("kelas", "siswa.id_kelas", "=", "kelas.id_kelas")
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            'jenisKelamin' => $jenisKelamin,
            
        ];
        return view('wali-kelas.edit-siswa',  $data);
    }


    public function editPengurus(Request $request, Kelas $kelas, PengurusKelas $pengurus)
    {
        $pengurus = [
            "pengurus" => $pengurus->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')
                ->where('id_pengurus', '=', $request->id)
                ->first()
        ];
        // dd($pengurus);
        return view('wali-kelas.edit-pengurus',  $pengurus);
    }

    public function editPresensi(Request $request, Kelas $kelas, PresensiSiswa $presensi)
    {
        $statusKehadiran = ['Hadir', 'Izin', 'Alpha'];

        $data = [
            "presensi" => $presensi->where('id_presensi', $request->id)->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            "statusKehadiran" => $statusKehadiran,
        ];

        return view('wali-kelas.edit-presensi', $data);
    }

    public function updateSiswa(Request $request, Siswa $siswa, Role $role)
    {
        $id_siswa = $request->input('id_siswa');

        $data = $request->validate([
            'nis' => 'sometimes',
            'nama_siswa' => 'sometimes',
            'id_kelas' => 'sometimes',
            'jenis_kelamin' => 'sometimes',
            'nomer_hp' => 'sometimes',
            'foto_siswa' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($id_siswa !== null) {
            if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
                $foto_file = $request->file('foto_siswa');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('siswa'), $foto_nama);

                $update_data = $siswa->where('id_siswa', $id_siswa)->first();
                $old_file_path = public_path('siswa') . '/' . $update_data->foto_siswa;

                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }

                $data['foto_siswa'] = $foto_nama;
            }

            $dataUpdate = $siswa->where('id_siswa', $id_siswa)->update($data);

            if ($dataUpdate) {
                notify()->success('Data siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/akun-siswa')->with('success', 'Data berhasil diupdate');
            }
        }

        return back()->with('error', 'Data gagal diupdate');
    }


    public function updatePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
        $id_pengurus = $request->input('id_pengurus');
        $data = $request->validate([
            'id_pengurus' => 'required',
            'jabatan' => 'required',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($pengurus->where('id_pengurus', $id_pengurus)->update($data)) {
            notify()->success('Data pengurus kelas telah diperbarui', 'Success');
            return redirect('/wali-kelas/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

    public function updatePresensi(Request $request, PresensiSiswa $presensi, Role $role)
    {
        $id_presensi = $request->input('id_presensi');
        $id_siswa = $request->input('id_siswa');

        $data = $request->validate([
            'id_siswa' => 'required',
            'status_kehadiran' => 'required',
            'keterangan' => 'sometimes',
            'foto_bukti' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_siswa'] = $id_siswa;

        if ($id_presensi !== null) {
            if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
                $foto_file = $request->file('foto_bukti');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('presensi_bukti'), $foto_nama);

                $update_data = $presensi->where('id_presensi', $id_presensi)->first();
                $old_file_path = public_path('presensi_bukti') . '/' . $update_data->foto_bukti;

                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }

                $data['foto_bukti'] = $foto_nama;
            }

            $dataUpdate = $presensi->where('id_presensi', $id_presensi)->update($data);

            if ($dataUpdate) {
                notify()->success('Data presensi siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/presensi-siswa');
            }
        }
        return back()->with('error', 'Data gagal diperbarui');
    }


    public function destroySiswa(Request $request, Role $role)
    {
        $id_siswa = $request->input('id_siswa');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        $siswa = Siswa::where('id_siswa', $id_siswa)->first();

        if ($siswa) {
            $foto_siswa = $siswa->foto_siswa;

            $aksi = $siswa->delete();

            $filePath = public_path('siswa') . '/' . $foto_siswa;

            if (file_exists($filePath) && unlink($filePath)) {
                return response()->json(['success' => true]);
            }

            if ($aksi) {
                $pesan = [
                    'success' => true,
                    'pesan' => 'Data berhasil dihapus'
                ];
            } else {
                $pesan = [
                    'success' => false,
                    'pesan' => 'Data gagal dihapus'
                ];
            }
        } else {
            $pesan = [
                'success' => false,
                'pesan' => 'Siswa not found'
            ];
        }

        return response()->json($pesan);
    }

    public function destroyPengurus(Request $request)
    {
        $id_pengurus = $request->input('id_pengurus');
        $aksi = PengurusKelas::where('id_pengurus', $id_pengurus)->delete();
        if ($aksi) {
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil di hapus'
            ];
        } else {
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal di hapus'
            ];
        }
        return response()->json($pesan);
    }

    public function logs(Logs $logs)
    {
        $data = [
            'logs' => $logs::orderBy('id_log', 'desc')->get(),

        ];
        return view('wali-kelas.logs', $data);
    }
}
