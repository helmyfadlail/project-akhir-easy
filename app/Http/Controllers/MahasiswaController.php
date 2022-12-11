<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class MahasiswaController extends Controller
{
    public function __construct() {

    }

    public function show() {
      $mahasiswa = User::all();
        return response()->json([
          'success' => 'sukses',
          'message' => 'semua data berhasil ditampilkan',
          'mahasiswa' => $mahasiswa,
      ], 200);
    }

    public function getByToken(Request $request) {
      $user = $request->user;
      if (!$user) {
        return response()->json([
          'status' => 'error',
          'message' => 'token salah'
        ],400);
      }
      return response()->json([
        'status' => 'sukses',
        'message' => 'haloo '. $user->nama,
        'mahasiswa' => $user->nama
      ],200);
    }

    public function deleteUser($nim) {
      $user = User::find($nim); 
      $user->delete();
    }
}
