<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class AiWritingAssistantService
{
    /**
     * @return array{ok: bool, message: string, improved_text?: string}
     */
    public function improve(string $context, string $text): array
    {
        $cleanText = trim($text);

        if ($cleanText === '') {
            return [
                'ok' => false,
                'message' => 'Teks belum diisi. Tulis dulu isi task atau daily scrum sebelum memakai bantuan AI.',
            ];
        }

        $apiKey = (string) config('services.deepseek.api_key');

        if ($apiKey === '') {
            return [
                'ok' => false,
                'message' => 'Isi DEEPSEEK_API_KEY terlebih dahulu untuk memakai bantuan AI penulisan.',
            ];
        }

        try {
            $response = Http::baseUrl((string) config('services.deepseek.base_url'))
                ->acceptJson()
                ->asJson()
                ->withToken($apiKey)
                ->connectTimeout((int) config('services.deepseek.connect_timeout', 2))
                ->timeout((int) config('services.deepseek.timeout', 6))
                ->retry(1, 200, fn (Throwable $exception): bool => $exception instanceof ConnectionException, throw: false)
                ->post('/chat/completions', [
                    'model' => config('services.deepseek.model', 'deepseek-chat'),
                    'temperature' => 0.3,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah editor bahasa Indonesia untuk aplikasi kinerja pegawai. Perbaiki kalimat agar lebih jelas, formal, singkat, dan mudah dipahami. Pertahankan fakta, maksud, dan konteks asli. Jangan menambah data baru. Kembalikan JSON dengan format {"improved_text":"..."} saja.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $this->buildPrompt($context, $cleanText),
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                return [
                    'ok' => false,
                    'message' => 'Bantuan AI penulisan sedang tidak tersedia. Coba lagi beberapa saat.',
                ];
            }

            return [
                'ok' => true,
                'message' => 'Kalimat berhasil diperbaiki.',
                'improved_text' => $this->extractImprovedText($response->json()),
            ];
        } catch (Throwable) {
            return [
                'ok' => false,
                'message' => 'Bantuan AI penulisan sedang tidak tersedia. Coba lagi beberapa saat.',
            ];
        }
    }

    private function buildPrompt(string $context, string $text): string
    {
        $instruction = match ($context) {
            'task_description' => 'Perbaiki deskripsi task agar jelas, formal, dan fokus pada tujuan pekerjaan.',
            'task_monitoring_note' => 'Perbaiki catatan monitoring agar ringkas, objektif, dan mudah dibaca atasan.',
            'daily_plan' => 'Perbaiki rencana kerja harian agar jelas, operasional, dan menunjukkan target kerja hari ini.',
            'daily_indicator' => 'Perbaiki indikator capaian agar terukur, singkat, dan mudah diverifikasi.',
            'daily_risk' => 'Perbaiki penjelasan potensi risiko agar ringkas, spesifik, dan tetap mudah dipahami.',
            'daily_realization' => 'Perbaiki realisasi kerja agar jelas, formal, dan menggambarkan hasil yang dicapai.',
            'daily_follow_up' => 'Perbaiki rencana tindak lanjut agar konkret, singkat, dan mudah ditindaklanjuti.',
            default => 'Perbaiki kalimat berikut agar lebih jelas dan formal.',
        };

        return "{$instruction}\n\nTeks asli:\n{$text}";
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function extractImprovedText(array $payload): string
    {
        $content = trim((string) data_get($payload, 'choices.0.message.content', ''));

        if ($content === '') {
            throw new RuntimeException('DeepSeek response content is empty.');
        }

        $normalizedContent = preg_replace('/^```json\s*|\s*```$/', '', $content) ?? $content;
        $decoded = json_decode($normalizedContent, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('DeepSeek response is not valid JSON.');
        }

        $improvedText = trim((string) ($decoded['improved_text'] ?? ''));

        if ($improvedText === '') {
            throw new RuntimeException('DeepSeek response does not contain improved_text.');
        }

        return $improvedText;
    }
}
