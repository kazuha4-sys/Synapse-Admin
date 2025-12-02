<?php

namespace Kazuha\AdminPainel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If session has impersonate id, log the guard in as that user
        if (Session::has('impersonate')) {
            $userId = Session::get('impersonate');
            // tenta logar sem senha
            $userModel = config('auth.providers.users.model', \App\Models\User::class);
            $user = $userModel::find($userId);
            if ($user) {
                Auth::onceUsingId($user->id);
            } else {
                // limpa se inválido
                Session::forget('impersonate');
            }
        }
        return $next($request);
    }
}
