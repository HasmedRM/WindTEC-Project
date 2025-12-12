<?php
// public/api/chat.php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input) || empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['answer' => 'Erro: Mensagem vazia ou inválida.']);
    exit;
}

$userMessage = trim($input['message']);

$contextFile = __DIR__ . '/contexto_tecnico.txt';
$contextText = '';

if (file_exists($contextFile)) {
    $contextText = file_get_contents($contextFile);
} else {
    $contextText = "AVISO DE SISTEMA: O arquivo de contexto técnico não foi encontrado no servidor.";
}

$prompt = "Você é um assistente técnico especialista em guindastes e rigging. Use estritamente o contexto técnico abaixo para responder. Se a resposta não estiver no contexto, diga que não sabe. Responda em Português do Brasil.\n\n";
$prompt .= "--- INÍCIO DO CONTEXTO TÉCNICO ---\n";
$prompt .= $contextText . "\n";
$prompt .= "--- FIM DO CONTEXTO TÉCNICO ---\n\n";
$prompt .= "PERGUNTA DO USUÁRIO:\n" . $userMessage;

$apiKey = getenv('GEMINI_API_KEY');

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['answer' => 'Erro de Configuração: Variável GEMINI_API_KEY não encontrada no servidor.']);
    exit;
}

$url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

$body = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.2,       
        'maxOutputTokens' => 8000   
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

$response = curl_exec($ch);
$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(['answer' => 'Erro interno de conexão com o Google: ' . $curlErr]);
    exit;
}

$decoded = json_decode($response, true);
$answer = "Desculpe, não consegui processar a resposta.";

if ($httpStatus !== 200) {
    $msgErro = $decoded['error']['message'] ?? 'Erro desconhecido';
    $answer = "Erro da API do Google ($httpStatus): " . $msgErro;
} elseif (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
    $answer = $decoded['candidates'][0]['content']['parts'][0]['text'];
}

header('Content-Type: application/json');
echo json_encode([
    'answer' => $answer,
    'raw' => $decoded,
    'status' => $httpStatus
]);
exit;
?>
