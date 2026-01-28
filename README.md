```markdown
# Xano AI Integration Bridge 🚀

Este projeto é uma implementação de referência para integração com a API de I.A da Software I.A (via Xano), desenvolvida com **PHP 8.2+** e **Laravel 11**.

## 🛠️ Tecnologias e Padrões
- **Service Pattern**: Lógica de API encapsulada em `App\Services\XanoAiService`.
- **Laravel Artisan**: Comandos customizados para testes rápidos via CLI.
- **HTTP Client (Guzzle)**: Integração fluida com tratamento de headers Bearer.

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

```



## 🖥️ Como Testar

Para validar a integração e a normalização de números, execute o comando customizado:

```bash
php artisan ai:test

```

## 📁 Estrutura de Arquivos Chave

* `app/Services/XanoAiService.php`: Coração da integração com a API.
* `app/Console/Commands/TestAiIntegration.php`: Interface de linha de comando para testes.
* `config/services.php`: Mapeamento das variáveis de ambiente para a aplicação.

```

Desenvolvido por **Vagner Giraldino** 

```
