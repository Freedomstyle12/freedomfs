<?php
// Database connection
$host = 'localhost';
$user = 'root';         // Change if using live hosting
$pass = '';             // Change to your DB password
$dbname = 'freedomstyle';

// Get form data
$customerName = $_POST['customerName'] ?? '';
$address = $_POST['address'] ?? '';
$itemName = $_POST['itemName'] ?? '';

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save to database
$sql = "INSERT INTO orders (customer_name, address, item_name) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $customerName, $address, $itemName);
$stmt->execute();
$stmt->close();

// Send email
$to = "freedomstylefs12@gmail.com";
$subject = "New Order from $customerName";
$body = "New order received:\n\nName: $customerName\nAddress: $address\nItem: $itemName";
$headers = "From: no-reply@yourdomain.com";

mail($to, $subject, $body, $headers);

echo "Order received successfully!";
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "freedomstylefs12@gmail.com";
    $subject = "New Order Received";

    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $item = htmlspecialchars($_POST['item']);

    $message = "You received a new order:\n\n";
    $message .= "Customer Name: $name\n";
    $message .= "Address: $address\n";
    $message .= "Item: $item\n";

    $headers = "From: noreply@yourdomain.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Order sent successfully.";
    } else {
        echo "Failed to send order.";
    }
}
?>
