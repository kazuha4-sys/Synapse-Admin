@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Painel Admin — Kazuha</h1>
    <p>Total de usuários: {{ $total }}</p>

    <div class="mt-6">
        <a href="{{ route('kazuha.admin.users.index') }}" class="px-4 py-2 rounded bg-gray-800 text-white">Gerenciar usuários</a>
    </div>
</div>
@endsection
