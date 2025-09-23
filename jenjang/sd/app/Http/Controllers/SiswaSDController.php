<?php

namespace App\Jenjang\SD\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jenjang\SD\Models\SiswaSD;
use App\Jenjang\SD\Models\UserSD;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaSDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = SiswaSD::with('user');

        // Filter by kelas
        if ($request->has('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by nama or NIS
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswa = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $siswa->items(),
            'meta' => [
                'current_page' => $siswa->currentPage(),
                'last_page' => $siswa->lastPage(),
                'per_page' => $siswa->perPage(),
                'total' => $siswa->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users_sd,email',
            'password' => 'required|string|min:8',
            'nis' => 'required|string|unique:siswa_sd,nis',
            'nisn' => 'required|string|unique:siswa_sd,nisn',
            'kelas' => 'required|in:1,2,3,4,5,6',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'telepon_orang_tua' => 'nullable|string|max:20',
        ]);

        DB::connection('sd')->beginTransaction();

        try {
            // Create user
            $user = UserSD::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jenis_user' => 'siswa',
                'status' => 'active',
            ]);

            // Create siswa
            $siswa = SiswaSD::create([
                'id_user' => $user->id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'nama_orang_tua' => $request->nama_orang_tua,
                'telepon_orang_tua' => $request->telepon_orang_tua,
                'status' => 'active',
            ]);

            DB::connection('sd')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Siswa SD berhasil ditambahkan',
                'data' => $siswa->load('user')
            ], 201);

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa SD',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SiswaSD $siswa): JsonResponse
    {
        $siswa->load('user');
        
        return response()->json([
            'success' => true,
            'data' => $siswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiswaSD $siswa): JsonResponse
    {
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users_sd,email,' . $siswa->id_user,
            'password' => 'sometimes|nullable|string|min:8',
            'nis' => 'sometimes|required|string|unique:siswa_sd,nis,' . $siswa->id,
            'nisn' => 'sometimes|required|string|unique:siswa_sd,nisn,' . $siswa->id,
            'kelas' => 'sometimes|required|in:1,2,3,4,5,6',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'telepon_orang_tua' => 'nullable|string|max:20',
            'status' => 'sometimes|in:active,inactive,lulus,pindah',
        ]);

        DB::connection('sd')->beginTransaction();

        try {
            // Update user
            $userData = [];
            if ($request->has('nama')) $userData['nama'] = $request->nama;
            if ($request->has('email')) $userData['email'] = $request->email;
            if ($request->has('password') && $request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            if (!empty($userData)) {
                $siswa->user->update($userData);
            }

            // Update siswa
            $siswaData = $request->only([
                'nama', 'nis', 'nisn', 'kelas', 'tanggal_lahir',
                'jenis_kelamin', 'alamat', 'telepon', 'nama_orang_tua',
                'telepon_orang_tua', 'status'
            ]);

            $siswa->update($siswaData);

            DB::connection('sd')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Siswa SD berhasil diperbarui',
                'data' => $siswa->load('user')
            ]);

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui siswa SD',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiswaSD $siswa): JsonResponse
    {
        DB::connection('sd')->beginTransaction();

        try {
            // Delete related data first
            $siswa->presensi()->delete();
            $siswa->kreditPoin()->delete();
            $siswa->penilaianKarakter()->delete();

            // Delete siswa
            $siswa->delete();

            // Delete user
            $siswa->user->delete();

            DB::connection('sd')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Siswa SD berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::connection('sd')->rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa SD',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for SD students
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_siswa' => SiswaSD::count(),
            'siswa_aktif' => SiswaSD::where('status', 'active')->count(),
            'siswa_per_kelas' => SiswaSD::selectRaw('kelas, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('kelas')
                ->get(),
            'siswa_per_jenis_kelamin' => SiswaSD::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
                ->where('status', 'active')
                ->groupBy('jenis_kelamin')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
