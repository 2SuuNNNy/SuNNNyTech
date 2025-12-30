<?php
require('fpdf/fpdf.php');
require_once 'db_connect.php';

if (!isset($_GET['order_id'])) {
    die("Missing order ID.");
}

$order_id = intval($_GET['order_id']);

// Fetch order info
$order_query = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$order_result = $order_query->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

$items_query = $conn->prepare("SELECT oi.quantity, oi.price, p.name 
                               FROM order_items oi 
                               JOIN products p ON oi.product_id = p.id 
                               WHERE oi.order_id = ?");
$items_query->bind_param("i", $order_id);
$items_query->execute();
$items_result = $items_query->get_result();

// PDF generation
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'SuNNNyTech Order Receipt', 0, 1, 'C');
$pdf->Ln(10);

// Shipping Info
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Shipping To: ' . $order['shipping_name'], 0, 1);
$pdf->Cell(0, 10, 'Address: ' . $order['shipping_address'], 0, 1);
$pdf->Cell(0, 10, 'City: ' . $order['shipping_city'], 0, 1);
$pdf->Cell(0, 10, 'Zip Code: ' . $order['shipping_zip'], 0, 1);
$pdf->Cell(0, 10, 'Phone: ' . $order['shipping_phone'], 0, 1);
$pdf->Ln(10);

// Items
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Product', 1);
$pdf->Cell(30, 10, 'Qty', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$total = 0;
while ($item = $items_result->fetch_assoc()) {
    $subtotal = $item['quantity'] * $item['price'];
    $total += $subtotal;

    $pdf->Cell(80, 10, $item['name'], 1);
    $pdf->Cell(30, 10, $item['quantity'], 1);
    $pdf->Cell(40, 10, '$' . number_format($item['price'], 2), 1);
    $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1);
    $pdf->Ln();
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total', 1);
$pdf->Cell(40, 10, '$' . number_format($total, 2), 1);

$pdf->Output('D', 'receipt_order_' . $order_id . '.pdf');
?>
