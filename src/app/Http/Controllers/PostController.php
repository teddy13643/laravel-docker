<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends Controller
{
    public function test(Request $request, Post $post)
    {

        throw new HttpException(403, 'You do not have permission to access this resource.');
        //     $user = User::find(1); // 假設用戶 ID 為 1
        //     Auth::login($user);
        // //    dd(Auth::user());

        //     if(Gate::allows('update', $post)){
        //         dd('允許');
        //     }else{
        //           dd('不允許');
        //     }
    }
}
