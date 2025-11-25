<?php
require_once "config.php";

$pickup_address = trim($_POST['pickup_address'] ?? '');
$destination_address = trim($_POST['destination_address'] ?? '');
$passenger_name = trim($_POST['passenger_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];

if (empty($pickup_address)) $errors[] = "Введите адрес подачи.";
if (empty($destination_address)) $errors[] = "Введите адрес назначения.";
if (empty($passenger_name) || mb_strlen($passenger_name) < 2) $errors[] = "Имя пассажира слишком короткое.";
if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) $errors[] = "Неверный формат телефона.";

if (!empty($errors)) {
    echo "<h3>Исправьте ошибки:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul>";
    exit;
}

$stmt = $mysqli->prepare("INSERT INTO taxi_orders (pickup_address, destination_address, passenger_name, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $pickup_address, $destination_address, $passenger_name, $phone);

if ($stmt->execute()) {
    echo "<h3>✅ Заказ успешно создан!</h3>";
    echo "<p>Адрес подачи: " . htmlspecialchars($pickup_address) . "</p>";
    echo "<p>Адрес назначения: " . htmlspecialchars($destination_address) . "</p>";
    echo "<p>Имя: " . htmlspecialchars($passenger_name) . "</p>";
    echo "<p>Телефон: " . htmlspecialchars($phone) . "</p>";
} else {
    echo "❌ Ошибка при сохранении: " . $stmt->error;
}

$stmt->close();
$mysqli->close();