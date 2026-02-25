<?php
// Разрешаем запросы (CORS)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$dataFile = 'app_state.json'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
    // Сохраняем данные в файл, блокируя его от одновременной записи другими
    if (file_put_contents($dataFile, $data, LOCK_EX) !== false) {
        echo json_encode(["status" => "success"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Не удалось записать файл. Проверьте права на папку."]);
    }
} else {
    // Отдаем данные планшетам судей
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        echo json_encode(["empty" => true]);
    }
}
?>
