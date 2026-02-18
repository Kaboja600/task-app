<?php
include "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (isset($_POST["add"])) {
    $task = $_POST["task"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $uid  = $_SESSION["user_id"];

    $stmt = $conn->prepare(
        "INSERT INTO tasks (user_id,task,task_date,task_time) VALUES (?,?,?,?)"
    );
    $stmt->bind_param("isss", $uid, $task, $date, $time);
    $stmt->execute();
}

if (isset($_GET["archive"])) {
    $id = (int)$_GET["archive"];
    $conn->query("UPDATE tasks SET is_archived=1 WHERE id=$id");
}

$result = $conn->query(
    "SELECT * FROM tasks WHERE user_id=".$_SESSION["user_id"]." AND is_archived=0"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <div class="dashboard-card">

        <div class="top-bar">
            <h2>Hello, <?= htmlspecialchars($_SESSION["username"]) ?> </h2>
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>

        <form method="POST" class="task-form">
            <input name="task" placeholder="Enter task..." required>
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <button name="add">Add Task</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["task"]) ?></td>
                    <td><?= $row["task_date"] ?></td>
                    <td><?= $row["task_time"] ?></td>
                    <td>
                        <a class="archive-btn" href="?archive=<?= $row["id"] ?>">Archive</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

</body>

</html>