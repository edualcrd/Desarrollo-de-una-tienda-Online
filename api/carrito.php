<?php
require_once 'utils.php';

validateToken();    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $clientCart = $input['cart'] ?? []; // Carrito enviado por el cliente
    $storeData = loadStoreData();
    $serverProducts = $storeData['productos'];
    $manipulationDetected = false;

    // Crear un mapa de precios originales para validación rápida
    $originalPrices = [];
    foreach ($serverProducts as $p) {
        $originalPrices[$p['id']] = $p['precio'];
    }

    foreach ($clientCart as $item) {
        $productId = $item['id'];
        $clientPrice = (float)($item['precio'] ?? 0);
        
        // Verificar existencia y precio
        if (!isset($originalPrices[$productId]) || $clientPrice !== (float)$originalPrices[$productId]) {
            $manipulationDetected = true;
            break;
        }
    }

    if ($manipulationDetected) {
        http_response_code(400);
        echo json_encode([
            "success" => false, 
            "message" => "Manipulación de precios detectada. La orden ha sido rechazada."
        ]);
    } else {
        // Lógica de procesamiento de pago/pedido iría aquí
        echo json_encode([
            "success" => true, 
            "message" => "Pedido procesado con éxito. ¡Gracias por tu compra!"
        ]);
        // Nota: El vaciado del carrito se hace en el cliente
    }

} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido."]);
}
?>