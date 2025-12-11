<?php
// public/api/chat.php

// 1️⃣ Configuração de CORS (para o React falar com o PHP)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Responde às requisições OPTIONS (pré-flight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// 2️⃣ Recebe a mensagem do usuário
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input) || empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['answer' => 'Erro: Mensagem vazia ou inválida.']);
    exit;
}

$userMessage = trim($input['message']);

// 3️⃣ Carrega o contexto técnico
$contextFile = __DIR__ . '/contexto_tecnico.txt';
$contextText = '';

if (file_exists($contextFile)) {
    $contextText = file_get_contents($contextFile);
} else {
    $contextText = "AVISO DE SISTEMA: O arquivo de contexto técnico não foi encontrado no servidor.";
}

// 4️⃣ Monta o Prompt para o modelo
$prompt = "Você é um assistente técnico especialista em guindastes e rigging. Use estritamente o contexto técnico abaixo para responder. Se a resposta não estiver no contexto, diga que não sabe. Responda em Português do Brasil.\n\n";
$prompt .= "--- INÍCIO DO CONTEXTO TÉCNICO ---\n";
$prompt .= $contextText . "\n";
$prompt .= "--- FIM DO CONTEXTO TÉCNICO ---\n\n";
$prompt .= "PERGUNTA DO USUÁRIO:\n" . $userMessage;

// 5️⃣ Pega a chave da API do ambiente (segurança)
$apiKey = getenv('GEMINI_API_KEY');

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['answer' => 'Erro de Configuração: Variável GEMINI_API_KEY não encontrada no servidor.']);
    exit;
}

// 6️⃣ URL do modelo Gemini 2.5 Flash
$url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

// 7️⃣ Corpo da requisição
$body = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.2,       // Menos criativo, mais preciso
        'maxOutputTokens' => 8000   // Ajuste conforme necessário
    ]
];

// 8️⃣ Envia para a API do Google via cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

$response = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

// 9️⃣ Tratamento de erro
if ($response === false) {
    http_response_code(500);
    echo json_encode(['answer' => 'Erro interno de conexão com o Google: ' . $curlErr]);
    exit;
}

// 10️⃣ Processa a resposta da API
$decoded = json_decode($response, true);
$answer = "Desculpe, não consegui processar a resposta.";

if ($httpStatus !== 200) {
    $msgErro = $decoded['error']['message'] ?? 'Erro desconhecido';
    $answer = "Erro da API do Google ($httpStatus): " . $msgErro;
} elseif (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
    $answer = $decoded['candidates'][0]['content']['parts'][0]['text'];
}

// 11️⃣ Retorna para o React
header('Content-Type: application/json');
echo json_encode([
    'answer' => $answer,
    'raw' => $decoded,
    'status' => $httpStatus
]);
exit;
?>
