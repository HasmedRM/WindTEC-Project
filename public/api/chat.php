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
    echo json_encode(['answer' => 'Erro: Pedido inválido ou sem mensagem.']);
    exit;
}

$userMessage = trim($input['message']);


$contextFile = __DIR__ . '/contexto_tecnico.txt';
$contextText = '';
if (file_exists($contextFile)) {
    $contextText = file_get_contents($contextFile);
} else {
    
    $contextText = "AVISO DO SISTEMA: O arquivo de contexto técnico não foi encontrado no servidor.";
}


$prompt = "Você é um assistente técnico especialista em guindastes e rigging. Use estritamente o contexto abaixo para responder. Se a resposta não estiver no contexto, diga que não sabe.\n\nCONTEXTO TÉCNICO:\n";
$prompt .= $contextText . "\n\nPERGUNTA DO USUÁRIO:\n" . $userMessage;


$apiKey = 'AIzaSyDu7f4CInovX5jS5_8ej_TT0EUPN51yWzg';


$backupFile = __DIR__ . '/chat.php.bak';
if (!file_exists($backupFile)) {
    copy(__FILE__, $backupFile);
}


function http_request($url, $postBody = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($postBody !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postBody));
    }
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$resp, $err, $status];
}


$listEndpoints = [
    'https://generativelanguage.googleapis.com/v1/models',
    'https://generativelanguage.googleapis.com/v1beta/models',
    'https://generativeai.googleapis.com/v1/models'
];

$models = null;
foreach ($listEndpoints as $endpoint) {
    $url = $endpoint . '?key=' . urlencode($apiKey);
    list($resp, $err, $status) = http_request($url);
    if ($resp && $status >= 200 && $status < 300) {
        $decoded = json_decode($resp, true);
        if (isset($decoded['models']) && is_array($decoded['models'])) {
            $models = $decoded['models'];
            break;
        }
        
        if (is_array($decoded) && !empty($decoded)) {
            
            foreach ($decoded as $k => $v) {
                if ($k === 'models' && is_array($v)) {
                    $models = $v; break 2;
                }
            }
        }
    }
}


$candidateModelIds = [];
if (is_array($models)) {
    foreach ($models as $m) {
        
        if (isset($m['name'])) {
            $name = $m['name'];
            $candidateModelIds[] = preg_replace('#^models/#', '', $name);
        }
    }
}


$candidateModelIds = array_merge($candidateModelIds, ['text-bison-001', 'text-bison', 'gemini-1.5', 'gemini-1.5-flash', 'gemini-1.5-flash-001']);


$candidateModelIds = array_values(array_unique($candidateModelIds));


$methodsToTry = [
    'generateContent', 
    'generate',        
    'generateText',    
];

$finalAnswer = null;
$finalRaw = null;
$finalStatus = null;

foreach ($candidateModelIds as $modelId) {
    foreach ($methodsToTry as $method) {
        
        $url = 'https://generativelanguage.googleapis.com/v1/models/' . urlencode($modelId) . ':' . $method . '?key=' . urlencode($apiKey);

        
        if ($method === 'generateContent') {
            $body = [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ],
                'generationConfig' => ['temperature' => 0.2, 'maxOutputTokens' => 8000]
            ];
        } elseif ($method === 'generate') {
            $body = [
                'prompt' => ['text' => $prompt],
                'temperature' => 0.2,
                'maxOutputTokens' => 8000
            ];
        } else { 
            $body = [
                'input' => $prompt,
                'temperature' => 0.2,
                'maxOutputTokens' => 8000
            ];
        }

        list($resp, $err, $status) = http_request($url, $body);
        $finalRaw = $resp;
        $finalStatus = $status;

        if ($resp === false || $resp === null) {
            
            continue;
        }

        $decoded = json_decode($resp, true);

        
        if (is_array($decoded) && isset($decoded['error'])) {
            
            continue;
        }

        
        $answer = null;
        if (is_array($decoded)) {
            if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
                $answer = $decoded['candidates'][0]['content']['parts'][0]['text'];
            } elseif (isset($decoded['candidates'][0]['output'])) {
                $answer = $decoded['candidates'][0]['output'];
            } elseif (isset($decoded['output'])) {
                
                if (is_string($decoded['output'])) {
                    $answer = $decoded['output'];
                } elseif (isset($decoded['output'][0]['content'][0]['text'])) {
                    $answer = $decoded['output'][0]['content'][0]['text'];
                }
            } elseif (isset($decoded['text'])) {
                $answer = $decoded['text'];
            } elseif (isset($decoded['results'][0]['output_text'])) {
                $answer = $decoded['results'][0]['output_text'];
            }
        }

        if ($answer !== null) {
            $finalAnswer = $answer;
            break 2; 
        } else {
            
            continue;
        }
    }
}

if ($finalAnswer === null) {
    $errMsg = 'Desculpe — não foi possível extrair texto da resposta do modelo. Verifique o campo `raw` para detalhes.';
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['answer' => $errMsg, 'raw' => $finalRaw, 'status' => $finalStatus]);
    exit;
}

header('Content-Type: application/json');
echo json_encode(['answer' => $finalAnswer, 'raw' => $finalRaw, 'status' => $finalStatus]);
exit;

?>