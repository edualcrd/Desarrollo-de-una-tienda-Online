<?php
// Configuración de cabeceras para API REST
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// --- CORRECCIÓN CRÍTICA DE RUTAS ---
// __DIR__ garantiza que la ruta es absoluta desde la ubicación del script (api/)
$STORE_DATA_PATH = __DIR__ . '/../data/tienda.json';
$USERS_DATA_PATH = __DIR__ . '/../data/usuarios.json';
// ------------------------------------

// Función para cargar los datos de la tienda
function loadStoreData() {
    global $STORE_DATA_PATH;
    if (!file_exists($STORE_DATA_PATH)) {
        http_response_code(500);
        echo json_encode(["error" => "Error interno del servidor: Archivo de tienda no encontrado en: " . $STORE_DATA_PATH]);
        exit;
    }
    return json_decode(file_get_contents($STORE_DATA_PATH), true);
}

// Función para cargar los datos de usuarios
function loadUsersData() {
    global $USERS_DATA_PATH;
    if (!file_exists($USERS_DATA_PATH)) {
        http_response_code(500);
        echo json_encode(["error" => "Error interno del servidor: Archivo de usuarios no encontrado en: " . $USERS_DATA_PATH]);
        exit;
    }
    return json_decode(file_get_contents($USERS_DATA_PATH), true);
}


// Función para validar el token de autenticación
function validateToken() {
    $storeData = loadStoreData();
    $serverToken = $storeData['token_key'];
    
    // Obtener token del header Authorization
    $clientToken = null;
    $headers = getallheaders(); // Función estándar de PHP, puede requerir configuración en IIS/Nginx
    if (isset($headers['Authorization'])) {
        $header = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $clientToken = $matches[1];
        } else {
            $clientToken = $header;
        }
    }

    if ($clientToken === $serverToken) {
        return true;
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Acceso no autorizado. Token inválido o faltante."]);
        exit;
    }
}
?>