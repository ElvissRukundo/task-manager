<?php
session_start();
require 'assets/include/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    $category = $_POST['category'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task, category, start_date, finish_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $task, $category, $start_date, $finish_date);

    if ($stmt->execute()) {
        header("Location: task.php");
        exit();
    } else {
        echo "Failed to add task: " . $stmt->error;
    }

    $stmt->close();
} elseif (isset($_GET['action']) && isset($_GET['id'])) {
    $task_id = $_GET['id'];

    if ($_GET['action'] == 'edit') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $task = $_POST['task'];
            $category = $_POST['category'];
            $start_date = $_POST['start_date'];
            $finish_date = $_POST['finish_date'];

            $stmt = $conn->prepare("UPDATE tasks SET task = ?, category = ?, start_date = ?, finish_date = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ssssii", $task, $category, $start_date, $finish_date, $task_id, $user_id);

            if ($stmt->execute()) {
                header("Location: task.php");
                exit();
            } else {
                echo "Failed to edit task: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Fetch existing task details for the form
            $stmt = $conn->prepare("SELECT task, category, start_date, finish_date FROM tasks WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $task_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $existingTask = $result->fetch_assoc();
            $stmt->close();
        }
    }

    if ($_GET['action'] == 'done') {
        $stmt = $conn->prepare("UPDATE tasks SET status = 'done' WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);

        if ($stmt->execute()) {
            header("Location: task.php");
            exit();
        } else {
            echo "Failed to mark task as done: " . $stmt->error;
        }

        $stmt->close();
    }

    if ($_GET['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);

        if ($stmt->execute()) {
            header("Location: task.php");
            exit();
        } else {
            echo "Failed to delete task: " . $stmt->error;
        }

        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT id, task, category, start_date, finish_date, status FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trackit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TRACKIT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            My Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-black text-white" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-2" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body class="bg-black">
    <div class="container my-5 px-5">
        <h2 class="text-white">Your Trackit</h2>

        <form method="POST" action="task.php" class="mb-4">
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <input type="text" name="task" class="form-control" placeholder="Add a new task" required>
                </div>
                <div class="col-12 col-md-2">
                    <select name="category" class="form-select" required>
                        <option value="Work">Work</option>
                        <option value="Personal">Personal</option>
                        <option value="Shopping">Shopping</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <input type="datetime-local" name="start_date" class="form-control" required>
                </div>
                <div class="col-12 col-md-3">
                    <input type="datetime-local" name="finish_date" class="form-control" required>
                </div>
                <div class="col-12 col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </div>
        </form>
        <?php if (isset($existingTask)): ?>
            <h3>Edit Task</h3>
            <form method="POST" action="task.php?action=edit&id=<?php echo $task_id; ?>" class="mb-4">
                <div class="input-group mb-3">
                    <input type="text" name="task" class="form-control"
                        value="<?php echo htmlspecialchars($existingTask['task']); ?>" required>
                    <select name="category" class="form-select" required>
                        <option value="Work" <?php echo $existingTask['category'] == 'Work' ? 'selected' : ''; ?>>Work
                        </option>
                        <option value="Personal" <?php echo $existingTask['category'] == 'Personal' ? 'selected' : ''; ?>>
                            Personal</option>
                        <option value="Shopping" <?php echo $existingTask['category'] == 'Shopping' ? 'selected' : ''; ?>>
                            Shopping</option>
                    </select>
                    <input type="datetime-local" name="start_date" class="form-control"
                        value="<?php echo htmlspecialchars($existingTask['start_date']); ?>" required>
                    <input type="datetime-local" name="finish_date" class="form-control"
                        value="<?php echo htmlspecialchars($existingTask['finish_date']); ?>" required>
                    <button type="submit" class="btn btn-warning">Update Task</button>
                </div>
            </form>
        <?php endif; ?>

        <h3 class="text-white">Task List</h3>
        <ul class="list-group shadow-lg">
            <?php foreach ($tasks as $task): ?>
                <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-2 mb-md-0">
                        <strong><?php echo htmlspecialchars($task['task']); ?></strong> -
                        <?php echo htmlspecialchars($task['category']); ?>
                        <br>
                        <small>Start: <?php echo htmlspecialchars($task['start_date']); ?></small> |
                        <small>Finish: <?php echo htmlspecialchars($task['finish_date']); ?></small>
                        <br>
                        <small>Status: <?php echo htmlspecialchars($task['status']); ?></small>
                    </div>
                    <div>
                        <a href="task.php?action=edit&id=<?php echo urlencode($task['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <?php if ($task['status'] === 'done'): ?>
                            <span class="btn btn-success btn-sm disabled">Done</span>
                        <?php else: ?>
                            <a href="task.php?action=done&id=<?php echo urlencode($task['id']); ?>" class="btn btn-success btn-sm">Mark Done</a>
                        <?php endif; ?>
                        <a href="task.php?action=delete&id=<?php echo urlencode($task['id']); ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>