<?php
// Ambos archivos están en la carpeta api/, no requiere '../'
require_once 'utils.php'; 

// Solo procesamos peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Método no permitido."]);
    exit;
}

// Obtener y decodificar el cuerpo de la petición JSON
$input = json_decode(file_get_contents("php://input"), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// Cargar usuarios usando la función corregida de utils.php
$users = loadUsersData();

$authenticated = false;
foreach ($users as $user) {
    // Verificación de credenciales
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
        "token" => $storeData['token_key'], //
        "store_data" => [ 
            "categorias" => $storeData['categorias'],
            "productos" => $storeData['productos']
        ] //
    ]);
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Credenciales incorrectas."]);
}
?>