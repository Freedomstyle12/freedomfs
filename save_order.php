<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['order_number'], $data['customer_name'], $data['customer_email'], $data['customer_phone'],
          $data['customer_address'], $data['order_date'], $data['total_amount'], $data['items'])
) {
    // Your correct DB credentials:
    $host = "localhost"; // usually stays localhost
    $user = "if0_39132036"; // ✅ your username
    $password = "sfahad120208";     // ✅ your password
    $dbname = "if0_39132036_fns"; // ✅ your full DB name with prefix

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "DB connection failed: " . $conn->connect_error]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, customer_address, order_date, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssd",
        $data['order_number'],
        $data['customer_name'],
        $data['customer_email'],
        $data['customer_phone'],
        $data['customer_address'],
        $data['order_date'],
        $data['total_amount']
    );

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, item_price, item_quantity) VALUES (?, ?, ?, ?)");
        foreach ($data['items'] as $item) {
            $item_stmt->bind_param(
                "isdi",
                $order_id,
                $item['name'],
                $item['price'],
                $item['quantity']
            );
            $item_stmt->execute();
        }

        echo json_encode(["success" => true, "message" => "Order saved"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to save order"]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
