@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold">Usuários</h2>

    @if(session('success')) <div class="bg-green-200 p-2">{{ session('success') }}</div> @endif
    @if(session('info')) <div class="bg-yellow-200 p-2">{{ session('info') }}</div> @endif

    <table class="w-full mt-4 table-auto">
        <thead>
            <tr><th>ID</th><th>Nome</th><th>Email</th><th>Role</th><th>Status</th><th>Ações</th></tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>{{ $u->status }}</td>
                <td>
                    <a class="px-2" href="{{ route('kazuha.admin.users.edit', $u->id) }}">Editar</a>

                    <form style="display:inline" method="POST" action="{{ route('kazuha.admin.users.destroy', $u->id) }}">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Excluir usuário?')" class="px-2">Excluir</button>
                    </form>

                    <form style="display:inline" method="POST" action="{{ route('kazuha.admin.users.impersonate', $u->id) }}">
                        @csrf
                        <button class="px-2">Entrar como</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
