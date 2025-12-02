<?php

namespace Kazuha\AdminPainel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'kazuha-admin:install';
    protected $description = 'Instala o painel admin: roda migrations e cria admin';

    public function handle()
    {
        $this->info('Rodando migrations do pacote...');
        // Publica e roda migrations
        $this->call('vendor:publish', ['--tag' => 'kazuha-admin-migrations', '--force' => true]);
        $this->call('migrate');

        // Cria admin seed rápido
        $email = 'admin@kazuha.local';
        $password = Str::random(12) . '-DS'; // senha aleatória
        $this->info('Criando usuário admin...');

        $existing = DB::table('users')->where('email', $email)->first();
        if ($existing) {
            $this->warn('Usuário admin já existe. Pulando criação.');
        } else {
            // tenta usar App\Models\User
            if (class_exists(\App\Models\User::class)) {
                /** @var \App\Models\User $user */
                $user = \App\Models\User::create([
                    'name' => 'Admin Kazuha',
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'status' => 'active'
                ]);
                $this->info('Usuário admin criado com sucesso.');
            } else {
                // fallback raw insert
                DB::table('users')->insert([
                    'name' => 'Admin Kazuha',
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'admin',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $this->info('Usuário admin criado (fallback raw).');
            }
        }

        $this->line('');
        $this->line('== Credenciais iniciais ==');
        $this->info("email: {$email}");
        $this->info("senha: {$password}");
        $this->line('');
        $this->info('Use isto para logar em /admin (ou personalize as rotas).');
        $this->info('Instalação finalizada. Boa sorte, merda pronta.');
    }
}
