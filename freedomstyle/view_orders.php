<?php
$host = "localhost";
$dbname = "freedomstyle";
$username = "your_db_username";
$password = "your_db_password";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

echo "<h2>Customer Orders</h2>";
echo "<table border='1' cellpadding='8'><tr><th>Order #</th><th>Name</th><th>Email</th><th>Phone</th><th>Total</th><th>Date</th><th>Items</th></tr>";

while ($row = $result->fetch_assoc()) {
  $orderId = $row["id"];
  $itemsRes = $conn->query("SELECT * FROM order_items WHERE order_id = $orderId");
  $itemsText = "";
  while ($item = $itemsRes->fetch_assoc()) {
    $itemsText .= "{$item['product_name']} (Qty: {$item['quantity']}) - $ {$item['price']}<br>";
  }

  echo "<tr>
    <td>{$row['order_number']}</td>
    <td>{$row['customer_name']}</td>
    <td>{$row['customer_email']}</td>
    <td>{$row['customer_phone']}</td>
    <td>$ {$row['total_amount']}</td>
    <td>{$row['order_date']}</td>
    <td>{$itemsText}</td>
  </tr>";
}
echo "</table>";
$conn->close();
?>
