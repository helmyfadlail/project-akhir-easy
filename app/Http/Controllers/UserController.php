<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Firebase\JWT\JWT;

use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)  {
      $this->request = $request;
    }
  
    protected function jwt(User $user) {
      $payload = [
        'iss' => 'lumen-jwt',
        'sub' => $user->nim, 
        'iat' => time(), 
        'exp' => time() + 60 * 60 
      ];
      return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function register(Request $request) {
      $nim = $request->nim;
      $nama = $request->nama;
      $angkatan = $request->angkatan;
      $password = Hash::make($request->password);
      $user = User::create([
          'nim' => $nim,
          'nama' => $nama,
          'angkatan'=>$angkatan,
          'password' => $password
      ]);
      return response()->json([
          'status' => 'sukses',
          'message' => 'berhasil menambahkan user baru',
          'user' => $user,
      ],200);
    }

    public function login (Request $request) {
      $nim = $request->nim;
      $password = $request->password;
      $user = User::where('nim', $nim)->first();
      if(!$user){
          return response()->json([
              'status' => "Error",
              'message' => "nim kamu tidak terdaftar"
          ], 404);
      }
      if(!Hash::check($password, $user->password)){
          return response()->json([
              'status' => "Error",
              'message' => "maaf, password kamu salah"
          ], 400);
      }
      $user->token = $this->jwt($user);
      $user->save();
      return response()->json([
          'status' => 'sukses',
          'message' => 'selamat login telah berhasil',
          'token' => $user->token
      ], 200);
    }
}
