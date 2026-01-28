<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\XanoAiService;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;
use function Laravel\Prompts\spin;

class TestAiIntegration extends Command
{
    protected $signature = 'ai:test';
    protected $description = 'Testa a normalização e integração com a API Xano';

    public function handle(XanoAiService $service)
    {
        $phone = text(
            label: 'Qual número de telefone deseja normalizar?',
            placeholder: 'Ex: 42999998888',
            required: true
        );

        $result = spin(
            fn() => $service->normalizePhone($phone),
            'Consultando API Xano...'
        );
        if (isset($result['internationalNumber']) && $result['internationalNumber'] !== "") {
            info("Número normalizado com sucesso: " . $result['internationalNumber']);
        } else {
            error("Falha ao normalizar ou número inválido.");
            $this->line(json_encode($result));
        }
    }
}
