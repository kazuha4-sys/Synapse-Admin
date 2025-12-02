<?php

namespace Kazuha\AdminPainel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Kazuha\AdminPainel\Models\AdminLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Middleware\Authenticate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(Authenticate::class),
            new Middleware(function ($request, $next) {
                if (!auth()->check() || auth()->user()->role !== 'admin') {
                    abort(403, 'Sem permissão, campeão.');
                }
                return $next($request);
            }),
        ];
    }

    public function dashboard()
    {
        $total = User::count();
        $users = User::latest()->limit(6)->get();
        return view('kazuha-admin::dashboard', compact('total','users'));
    }

    public function index()
    {
        $users = User::paginate(15);
        return view('kazuha-admin::users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('kazuha-admin::users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->only(['name','email','role','status']);
        $user->fill($data);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            AdminLog::create([
                'admin_id' => auth()->id(),
                'action' => 'changed_password',
                'meta' => "Changed password for user {$user->id}"
            ]);
        }

        $user->save();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'updated_user',
            'meta' => json_encode(['user_id' => $user->id, 'fields' => $data])
        ]);

        return redirect()->route('kazuha.admin.users.index')->with('success', 'Usuário atualizado.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'deleted_user',
            'meta' => json_encode(['user_id' => $user->id])
        ]);

        return back()->with('success', 'Usuário excluído.');
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        $imp = DB::table('impersonations')->insertGetId([
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'started_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Session::put('impersonate', $user->id);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'impersonated',
            'meta' => json_encode(['user_id' => $user->id, 'impersonation_id' => $imp])
        ]);

        return redirect('/')->with('info', 'Você está logado como ' . $user->name . '. Use /admin/stop-impersonate para voltar.');
    }

    public function stopImpersonate()
    {
        $old = Session::get('impersonate');
        if ($old) {
            DB::table('impersonations')
                ->where('user_id', $old)
                ->whereNull('ended_at')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update(['ended_at' => now()]);
        }
        Session::forget('impersonate');

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'stopped_impersonation',
            'meta' => json_encode(['previous_impersonated' => $old])
        ]);

        return redirect()->route('kazuha.admin.dashboard')->with('success', 'Voltou pro admin.');
    }
}
