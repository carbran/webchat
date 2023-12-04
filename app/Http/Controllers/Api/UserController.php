<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index() {

        $userLogged = Auth::user();

        $users = User::where('id','!=', $userLogged->id)->get();

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }
}
