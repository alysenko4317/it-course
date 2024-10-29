<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reader Cabinet - Book Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .cabinet-header {
            padding: 60px 0;
            text-align: center;
            background-color: #343a40;
            color: white;
        }
        .info-section {
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .list-group-item strong {
            width: 150px;
            text-align: left;
        }
        .list-group-item span {
            flex-grow: 1;
            text-align: left;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<header class="cabinet-header">
    <h1>Welcome to Your Cabinet, <?= htmlspecialchars($reader->firstName); ?>!</h1>
    <p>Here you can view your personal details and manage your profile.</p>
</header>

<!-- Reader Information Section -->
<div class="container info-section">
    <h3>Your Information</h3>
    <ul class="list-group">
        <li class="list-group-item">
            <strong>Ticket ID:</strong> <span><?= htmlspecialchars($reader->ticket); ?></span>
        </li>
        <li class="list-group-item">
            <strong>First Name:</strong> <span><?= htmlspecialchars($reader->firstName); ?></span>
        </li>
        <li class="list-group-item">
            <strong>Last Name:</strong> <span><?= htmlspecialchars($reader->lastName); ?></span>
        </li>
        <li class="list-group-item">
            <strong>Birthday:</strong> <span><?= htmlspecialchars($reader->birthday); ?></span>
        </li>
        <li class="list-group-item">
            <strong>Phone:</strong> <span><?= htmlspecialchars($reader->phone); ?></span>
        </li>
        <li class="list-group-item">
            <strong>Room:</strong> <span><?= htmlspecialchars($reader->roomId); ?></span>
        </li>
        <?php if (!empty($reader->telegramId)) : ?>
            <li class="list-group-item">
                <strong>Telegram ID:</strong> <span><?= htmlspecialchars($reader->telegramId); ?></span>
            </li>
        <?php endif; ?>
    </ul>

    <!-- Add Logout and Home buttons -->
    <div class="action-buttons mt-4">
        <a href="/" class="btn btn-secondary">Home</a>
        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
