<?php
require_once 'utils.php';

// Validar Token antes de procesar cualquier cosa
validateToken(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $clientCart = $input['cart'] ?? []; 
    $storeData = loadStoreData();
    $serverProducts = $storeData['productos'];
    $manipulationDetected = false;

    // Crear un mapa de precios originales para validación rápida
    $originalPrices = [];
    foreach ($serverProducts as $p) {
        $originalPrices[$p['id']] = (float)$p['precio'];
    }

    // 1. Validar que los precios del carrito coincidan con los originales
    foreach ($clientCart as $item) {
        $productId = $item['id'];
        $clientPrice = (float)($item['precio'] ?? 0);
        
        // Verificar existencia y precio (comparación estricta de floats)
        if (!isset($originalPrices[$productId]) || abs($clientPrice - $originalPrices[$productId]) > 0.001) {
            $manipulationDetected = true;
            break;
        }
    }

    if ($manipulationDetected) {
        http_response_code(400);
        echo json_encode([
            "success" => false, 
            "message" => "Manipulación de precios detectada. La orden ha sido rechazada. (El servidor detectó un precio incorrecto)."
        ]);
    } else {
        // Lógica de procesamiento de pago/pedido
        echo json_encode([
            "success" => true, 
            "message" => "Pedido procesado con éxito. ¡Gracias por tu compra! (El carrito se vaciará localmente)."
        ]);
    }

} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido."]);
}
?>