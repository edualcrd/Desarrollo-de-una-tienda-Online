<?php
// Configuración de cabeceras para API REST
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$STORE_DATA_PATH = '/Desarrollo-de-una-tienda-Online/data/tienda.json';
$USERS_DATA_PATH = '/Desarrollo-de-una-tienda-Online/data/usuarios.json';

// Función para cargar los datos de la tienda
function loadStoreData() {
    global $STORE_DATA_PATH;
    if (!file_exists($STORE_DATA_PATH)) {
        http_response_code(500);
        echo json_encode(["error" => "Error interno del servidor: Archivo de tienda no encontrado."]);
        exit;
    }
    return json_decode(file_get_contents($STORE_DATA_PATH), true);
}

// Función para validar el token de autenticación
function validateToken() {
    $storeData = loadStoreData();
    $serverToken = $storeData['token_key'];
    
    // El token puede venir en el header Authorization o como parámetro GET/POST
    $clientToken = null;
    if (isset(apache_request_headers()['Authorization'])) {
        $header = apache_request_headers()['Authorization'];
        // Asume formato "Bearer MiToken..." o simplemente el token
        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $clientToken = $matches[1];
        } else {
            $clientToken = $header;
        }
    } else if (isset($_REQUEST['token'])) {
        $clientToken = $_REQUEST['token'];
    }

    if ($clientToken === $serverToken) {
        return true;
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Acceso no autorizado. Token inválido."]);
        exit;
    }
}
?>