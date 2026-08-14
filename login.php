<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $employee_id = trim($_POST["employee_id"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($employee_id === "" || $password === "") {
        $error = "Please enter Employee ID and password.";
    } else {

        // Check doctors
        $stmt = $conn->prepare(
            "SELECT employee_id, doctor_name, password
             FROM doctors
             WHERE employee_id = ?"
        );

        $stmt->bind_param("s", $employee_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if ($password === $user["password"]) {

                $_SESSION["employee_id"] = $user["employee_id"];
                $_SESSION["name"] = $user["doctor_name"];
                $_SESSION["role"] = "Doctor";

                header("Location: doctor_dashboard.php");
                exit;
            }
        }

        // Check nurses
        $stmt = $conn->prepare(
            "SELECT employee_id, nurse_name, password
             FROM nurses
             WHERE employee_id = ?"
        );

        $stmt->bind_param("s", $employee_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if ($password === $user["password"]) {

                $_SESSION["employee_id"] = $user["employee_id"];
                $_SESSION["name"] = $user["nurse_name"];
                $_SESSION["role"] = "Nurse";

                header("Location: nurse_dashboard.php");
                exit;
            }
        }

        $error = "Invalid Employee ID or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <h1>Hospital Attendance System</h1>
        <p>Staff Login</p>

        <?php if ($error !== ""): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <label>Employee ID</label>

            <input
                type="text"
                name="employee_id"
                placeholder="Enter Employee ID"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter Password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>