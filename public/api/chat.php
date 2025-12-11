<?php
// public/api/chat.php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Recebe mensagem do usuário
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input) || empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['answer' => 'Erro: Pedido inválido ou sem mensagem.']);
    exit;
}
$userMessage = trim($input['message']);

// Carrega contexto técnico
$contextFile = __DIR__ . '/contexto_tecnico.txt';
$contextText = file_exists($contextFile)
    ? file_get_contents($contextFile)
    : "AVISO DO SISTEMA: O arquivo de contexto técnico não foi encontrado no servidor.";

// Monta prompt
$prompt = "Você é um assistente técnico especialista em guindastes e rigging. Use estritamente o contexto abaixo para responder. Se a resposta não estiver no contexto, diga que não sabe.\n\nCONTEXTO TÉCNICO:\n";
$prompt .= $contextText . "\n\nPERGUNTA DO USUÁRIO:\n" . $userMessage;

// Pega a chave da API do ambiente
$apiKey = getenv('GOOGLE_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['answer' => 'API key não configurada no servidor.']);
    exit;
}

// Função para requisição HTTP
function http_request($url, $postBody = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($postBody !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postBody));
    }
    $resp = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$resp, $status];
}

// Endpoint confiável
$url = 'https://generativelanguage.googleapis.com/v1/models/text-bison-001:generateText?key=' . urlencode($apiKey);
$body = [
    'input' => $prompt,
    'temperature' => 0.2,
    'maxOutputTokens' => 8000
];

list($resp, $status) = http_request($url, $body);

if (!$resp || $status >= 400) {
    http_response_code(500);
    echo json_encode([
        'answer' => 'Erro: não foi possível gerar resposta do modelo.',
        'raw' => $resp,
        'status' => $status
    ]);
    exit;
}

// Extrai resposta
$decoded = json_decode($resp, true);
$answer = $decoded['candidates'][0]['content'][0]['text'] ?? null;

if (!$answer) {
    http_response_code(500);
    echo json_encode([
        'answer' => 'Desculpe — não foi possível extrair texto da resposta do modelo.',
        'raw' => $resp,
        'status' => $status
    ]);
    exit;
}

// Retorna resposta
header('Content-Type: application/json');
echo json_encode(['answer' => $answer, 'raw' => $resp, 'status' => $status]);
exit;
