<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin can improve task description wording with ai', function () {
    config([
        'services.deepseek.api_key' => 'deepseek-test-key',
        'services.deepseek.base_url' => 'https://api.deepseek.com',
        'services.deepseek.model' => 'deepseek-chat',
    ]);

    Http::fake([
        'https://api.deepseek.com/chat/completions' => Http::response([
            'choices' => [
                [
                    'message' => [
                        'content' => json_encode([
                            'improved_text' => 'Menyusun rancangan dashboard pelaporan agar alur informasi lebih jelas dan mudah digunakan.',
                        ]),
                    ],
                ],
            ],
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('admin');

    $this->actingAs($user)
        ->postJson(route('ai-writing-assist.improve'), [
            'context' => 'task_description',
            'text' => 'bikin dashboard laporan biar enak dipakai',
        ])
        ->assertOk()
        ->assertJson([
            'ok' => true,
            'improved_text' => 'Menyusun rancangan dashboard pelaporan agar alur informasi lebih jelas dan mudah digunakan.',
        ]);
});

test('pegawai can improve daily scrum wording with ai', function () {
    config([
        'services.deepseek.api_key' => 'deepseek-test-key',
        'services.deepseek.base_url' => 'https://api.deepseek.com',
        'services.deepseek.model' => 'deepseek-chat',
    ]);

    Http::fake([
        'https://api.deepseek.com/chat/completions' => Http::response([
            'choices' => [
                [
                    'message' => [
                        'content' => json_encode([
                            'improved_text' => 'Melanjutkan integrasi API login dan memastikan validasi berjalan sesuai kebutuhan.',
                        ]),
                    ],
                ],
            ],
        ]),
    ]);

    $user = User::factory()->create();
    $user->assignRole('pegawai');

    $this->actingAs($user)
        ->postJson(route('ai-writing-assist.improve'), [
            'context' => 'daily_plan',
            'text' => 'lanjut api login dan beresin validasi',
        ])
        ->assertOk()
        ->assertJson([
            'ok' => true,
            'improved_text' => 'Melanjutkan integrasi API login dan memastikan validasi berjalan sesuai kebutuhan.',
        ]);
});

test('pimpinan cannot use ai writing endpoint for daily scrum wording', function () {
    $user = User::factory()->create();
    $user->assignRole('pimpinan');

    $this->actingAs($user)
        ->postJson(route('ai-writing-assist.improve'), [
            'context' => 'daily_plan',
            'text' => 'rapikan kalimat ini',
        ])
        ->assertForbidden();
});
