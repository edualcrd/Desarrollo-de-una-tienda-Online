<?php
require_once 'utils.php';

// Solo procesamos peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Método no permitido."]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// Cargar usuarios
if (!file_exists($USERS_DATA_PATH)) {
    http_response_code(500);
    echo json_encode(["error" => "Error interno del servidor: Archivo de usuarios no encontrado."]);
    exit;
}
$users = json_decode(file_get_contents($USERS_DATA_PATH), true);

$authenticated = false;
foreach ($users as $user) {
    // Simulación de verificación de credenciales
    if ($user['username'] === $username && $user['password'] === $password) {
        $authenticated = true;
        break;
    }
}

if ($authenticated) {
    $storeData = loadStoreData();
    
    // Devolver el token y la información de la tienda
    echo json_encode([
        "success" => true,
        // Se excluye la clave del token de la data de la tienda que va al cliente, por seguridad
        "store_data" => [ 
            "categorias" => $storeData['categorias'],
            "productos" => $storeData['productos']
        ]
    ]);
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Credenciales incorrectas."]);
}
?>