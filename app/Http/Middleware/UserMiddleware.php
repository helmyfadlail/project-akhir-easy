<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class UserMiddleware
{
    function handle($request, Closure $next)
    {
      $token = $request->header('token') ?? $request->query('token');
      if (!$token) {
          return response()->json([
              'error' => 'token belum dimasukkan'
          ], 401);
      }
      try {
          $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
      } catch (ExpiredException $e) {
          return response()->json([
              'error' => 'token sudah kadaluwarsa'
          ], 400);
      } catch (Exception $e) {
          return response()->json([
              'error' => 'token belum di decode'
          ], 400);
      }
      $user = User::find($credentials->sub);
      $request->user = $user;
      return $next($request);
    }
}