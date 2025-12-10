# Deploy no Render (Docker)

Este documento descreve como fazer o deploy da aplicação Laravel + Vite no Render usando o `Dockerfile` adicionado ao repositório.

### Pré-requisitos
- Conta no Render (https://render.com)
- Repositório Git (GitHub/GitLab) com acesso pelo Render
- Variáveis de ambiente necessárias (veja seção abaixo)

---

## 1) Arquivos já adicionados
- `Dockerfile` (multi-stage)
- `docker/nginx.conf`
- `docker/supervisord.conf`
- `.dockerignore`
- `render.yaml` (exemplo de manifest)

Esses arquivos permitem que o Render faça o build da imagem a partir do `Dockerfile` e execute a aplicação usando PHP-FPM + Nginx.

---

## 2) Variáveis de ambiente (adicionar no painel do Render - Service > Environment)
Adicione as variáveis abaixo (exemplos):

- `APP_ENV=production`
- `APP_KEY` (gere localmente com `php artisan key:generate --show` e cole aqui)
- `APP_URL` (ex.: `https://seu-app.onrender.com`)
- `DB_CONNECTION=pgsql` ou `mysql` (conforme DB que for usar)
- `DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD`
- `MAIL_MAILER`, `MAIL_HOST`, etc (se usar email)
- `GEMINI_API_KEY` (ou outra chave de API que sua app use)

Nunca commit suas chaves no repositório. Use a seção "Environment" do Render para inserir secrets.

---

## 3) Deploy via Render Dashboard (GUI)
1. No Render, **New** → **Web Service** → conecte seu repositório.
2. Escolha **Docker** como ambiente de build (Render detecta `Dockerfile` automaticamente).
3. Nomeie o serviço (ex.: `windtec-project`), escolha região e plano.
4. Em **Environment**, adicione as variáveis que listamos.
5. Clique em **Create Web Service**. Render iniciará o build usando o `Dockerfile`.

Observação: o `Dockerfile` usa PHP 8.4 (compatível com dependências do `composer.lock`).

---

## 4) Comandos úteis locais (teste com Docker)
- Build da imagem local:

```bash
docker build -t windtec-project:latest .
```

- Rodar o container localmente (expondo porta 8080):

```bash
docker run --rm -p 8080:80 \
  -e APP_ENV=production \
  -e APP_KEY="base64:..." \
  -e DB_CONNECTION=sqlite \
  -e DB_DATABASE=/var/www/html/database/database.sqlite \
  -v $(pwd)/.env:/var/www/html/.env:ro \
  windtec-project:latest
```

- Teste no navegador: `http://localhost:8080`

---

## 5) Rodando migrations no Render (uma vez)
Você pode criar um **One-off Job** no Render que execute comandos artisan:

- Command: `php artisan migrate --force`

Ou acesse o container com `docker exec` (se estiver usando localmente) para executar artisan.

---

## 6) Observações e troubleshooting
- Se o build falhar por versão PHP, o `Dockerfile` já está configurado para PHP 8.4.
- Se o build do Node (Vite) falhar, verifique `npm run build` localmente e dependências.
- Certifique-se de que `public/build` seja gerado no stage de node e copiado para a imagem final (o Dockerfile faz isso).

---

Se quiser, eu posso:
- Ajustar o `Dockerfile` para suportar Redis/Queues (supervisor já está configurado para php-fpm + nginx, mas podemos adicionar `php artisan queue:work` sob supervisord se necessário).
- Gerar um `docker-compose.yml` para desenvolvimento local com MySQL/Postgres + Redis.
- Commitar `render.yaml` e `README-DEPLOY-RENDER.md` automaticamente no repositório (se você autorizar).

Diga qual próximo passo deseja que eu faça.