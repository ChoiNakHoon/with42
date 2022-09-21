<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
<<<<<<< Updated upstream
    public function me () {
=======
    public function me (Request $request) {
>>>>>>> Stashed changes
        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }
}
