```markdown
# Xano AI Integration Bridge 🚀

Este projeto é uma implementação de referência para integração com a API de I.A da Software I.A (via Xano), desenvolvida com **PHP 8.2+** e **Laravel 11**.

## ⚡ Performance Optimizations

Esta versão inclui otimizações significativas de performance:
- **Caching de respostas** - Normalização de telefones em cache (1 hora TTL)
- **Retry automático** - 3 tentativas automáticas em caso de falha
- **Timeout configurável** - Proteção contra requisições travadas (30s)
- **Singleton pattern** - Instância única do serviço
- **Validação de entrada** - Retornos rápidos para entradas inválidas

📖 Veja [PERFORMANCE.md](PERFORMANCE.md) para detalhes completos das otimizações.

## 🛠️ Tecnologias e Padrões
- **Service Pattern**: Lógica de API encapsulada em `App\Services\XanoAiService`.
- **Laravel Artisan**: Comandos customizados para testes rápidos via CLI.
- **HTTP Client (Guzzle)**: Integração fluida com tratamento de headers Bearer.
- **Caching**: Sistema de cache para melhor performance.
- **Auto-retry**: Mecanismo de retry automático para resiliência.

## 🚀 Instalação e Configuração

1. **Clonar o repositório:**
   ```bash
   git clone [https://github.com/VagnerGiraldinoJr/xano-ai-integration-bridge.git](https://github.com/VagnerGiraldinoJr/xano-ai-integration-bridge.git)
   cd xano-ai-integration-bridge

```

2. **Instalar dependências:**
```bash
composer install

```


3. **Configurar o ambiente:**
```bash
cp .env.example .env

```


Edite o `.env` e insira suas credenciais:
```env
XANO_API_BASE_URL=[https://xltw-api6-8lww.b2.xano.io/api:5ONttZdQ](https://xltw-api6-8lww.b2.xano.io/api:5ONttZdQ)
XANO_API_KEY=sua_api_key_aqui

# Configurações de Performance (Opcional)
XANO_API_TIMEOUT=30              # Timeout em segundos (padrão: 30)
XANO_API_RETRY_TIMES=3           # Número de tentativas (padrão: 3)
XANO_API_RETRY_DELAY=100         # Delay entre tentativas em ms (padrão: 100)
XANO_API_CACHE_TTL=3600          # Cache TTL em segundos (padrão: 3600)

```



## 🖥️ Como Testar

Para validar a integração e a normalização de números, execute o comando customizado:

```bash
php artisan ai:test

```

Para executar os testes automatizados:

```bash
php artisan test

```

## 📁 Estrutura de Arquivos Chave

* `app/Services/XanoAiService.php`: Coração da integração com a API.
* `app/Console/Commands/TestAiIntegration.php`: Interface de linha de comando para testes.
* `config/services.php`: Mapeamento das variáveis de ambiente para a aplicação.

```

Desenvolvido por **Vagner Giraldino** 

```
