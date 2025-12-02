@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold">Editar usuário: {{ $user->name }}</h2>

    <form action="{{ route('kazuha.admin.users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mt-2">
            <label>Nome</label>
            <input name="name" value="{{ old('name', $user->name) }}" />
        </div>

        <div class="mt-2">
            <label>Email</label>
            <input name="email" value="{{ old('email', $user->email) }}" />
        </div>

        <div class="mt-2">
            <label>Role</label>
            <select name="role">
                <option value="user" {{ $user->role==='user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role==='admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mt-2">
            <label>Status</label>
            <select name="status">
                <option value="active" {{ $user->status==='active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ $user->status==='suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>

        <div class="mt-2">
            <label>Nova senha (opcional)</label>
            <input name="password" type="password" placeholder="Deixe vazio pra manter" />
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white">Salvar</button>
            <a href="{{ route('kazuha.admin.users.index') }}" class="ml-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection
