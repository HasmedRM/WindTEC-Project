<?php
// public/api/chat.php

// 1. Configuração de CORS (Essencial para o React falar com o PHP)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Se for apenas verificação do navegador, para aqui
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// 2. Recebe a mensagem do usuário
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input) || empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['answer' => 'Erro: Mensagem vazia ou inválida.']);
    exit;
}

$userMessage = trim($input['message']);

// 3. Carrega o Cérebro (Contexto Técnico)
$contextFile = __DIR__ . '/contexto_tecnico.txt';
$contextText = '';

if (file_exists($contextFile)) {
    $contextText = file_get_contents($contextFile);
} else {
    // Fallback para não quebrar se o arquivo não subir
    $contextText = "AVISO DE SISTEMA: O arquivo de contexto técnico não foi encontrado no servidor.";
}

// 4. Monta o Prompt Gigante
$prompt = "Você é um assistente técnico especialista em guindastes e rigging. Use estritamente o contexto técnico abaixo para responder. Se a resposta não estiver no contexto, diga que não sabe. Responda em Português do Brasil.\n\n";
$prompt .= "--- INÍCIO DO CONTEXTO TÉCNICO ---\n";
$prompt .= $contextText . "\n";
$prompt .= "--- FIM DO CONTEXTO TÉCNICO ---\n\n";
$prompt .= "PERGUNTA DO USUÁRIO:\n" . $userMessage;

// 5. Pega a Chave de API do Ambiente (Segurança)
// No Railway/Render, você deve criar uma variável chamada GEMINI_API_KEY
$apiKey = getenv('GEMINI_API_KEY');

if (!$apiKey) {
    // Se esquecer de configurar no Railway, avisa o erro
    http_response_code(500);
    echo json_encode(['answer' => 'Erro de Configuração: Variável GEMINI_API_KEY não encontrada no servidor.']);
    exit;
}

// 6. Configura a URL do Gemini 1.5 Flash (CORREÇÃO AQUI: removido o -001)
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;

// 7. Monta o corpo da requisição (JSON Estruturado)
$body = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.2,      // Criatividade baixa (mais precisão)
        'maxOutputTokens' => 4000  // Limite alto para listas longas
    ]
];

// 8. Envia para o Google (cURL)
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

$response = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

// 9. Tratamento de Erro de Conexão
if ($response === false) {
    http_response_code(500);
    echo json_encode(['answer' => 'Erro interno de conexão com o Google: ' . $curlErr]);
    exit;
}

// 10. Processa a Resposta do Google
$decoded = json_decode($response, true);
$answer = "Desculpe, não consegui processar a resposta.";

if ($httpStatus !== 200) {
    // Se o Google devolveu erro (400, 403, 404, 500)
    $msgErro = $decoded['error']['message'] ?? 'Erro desconhecido';
    $answer = "Erro da API do Google ($httpStatus): " . $msgErro;
} else if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
    // Sucesso! Pega o texto
    $answer = $decoded['candidates'][0]['content']['parts'][0]['text'];
}

// 11. Devolve para o React
header('Content-Type: application/json');
echo json_encode(['answer' => $answer]);
?>