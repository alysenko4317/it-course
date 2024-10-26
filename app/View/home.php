<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Library</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .library-header {
            padding: 60px 0;
            text-align: center;
            background-color: #343a40;
            color: white;
        }
        .book-card {
            transition: transform 0.2s ease-in-out;
        }
        .book-card:hover {
            transform: translateY(-5px);
        }
        .search-section {
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="library-header">
        <h1><?= $message; ?></h1>
        <p>Welcome to our library! We currently have <strong><?= $book_count; ?></strong> books available.</p>
    </header>

    <!-- Search Section -->
    <div class="container search-section">
        <form class="d-flex justify-content-center" action="/search" method="get">
            <div class="form-group me-2">
                <label for="search" class="visually-hidden">Search for a book</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search for a book">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Top 10 Books Section -->
    <div class="container">
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class='col-md-4 mb-4'>
                    <div class='card book-card'>
                        <div class='card-body'>
                            <h5 class='card-title'><?= htmlspecialchars($book->name); ?></h5>
                            <p class='card-text'><strong>Code:</strong> <?= htmlspecialchars($book->code); ?></p>
                            <p class='card-text'><strong>Release Date:</strong> <?= htmlspecialchars($book->releaseDate); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS (for components like modals, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
