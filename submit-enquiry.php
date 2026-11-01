<?php
// Basic Hostinger PHP/MySQL enquiry handler. Configure config.php before enabling database storage.
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: contact.php"); exit; }
if (!empty($_POST["website"] ?? "")) { header("Location: contact.php?sent=1"); exit; }
$name = trim($_POST["name"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$email = trim($_POST["email"] ?? "");
$service = trim($_POST["service"] ?? "");
$location = trim($_POST["location"] ?? "");
$message = trim($_POST["message"] ?? "");
if ($name === "" || $phone === "" || $service === "" || empty($_POST["consent"])) { header("Location: contact.php?error=1"); exit; }
if (strlen($name)>100 || strlen($phone)>25 || strlen($email)>150 || strlen($service)>100 || strlen($location)>150 || strlen($message)>2500 || ($email!=="" && !filter_var($email,FILTER_VALIDATE_EMAIL))) { header("Location: contact.php?error=1"); exit; }
if (!file_exists(__DIR__ . "/config.php")) { header("Location: contact.php?error=1"); exit; }
$config = require __DIR__ . "/config.php";
try {
  $pdo = new PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8mb4", $config["username"], $config["password"], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES=>false]);
  $stmt = $pdo->prepare("INSERT INTO enquiries (name, phone, email, service, location, message, created_at) VALUES (:name,:phone,:email,:service,:location,:message,NOW())");
  $stmt->execute([":name"=>$name,":phone"=>$phone,":email"=>$email,":service"=>$service,":location"=>$location,":message"=>$message]);
  header("Location: contact.php?sent=1"); exit;
} catch (Throwable $e) {
  error_log("Blue Shield enquiry submission failed: ".$e->getMessage());
  header("Location: contact.php?error=1"); exit;
}
