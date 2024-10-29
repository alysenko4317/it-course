<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Book Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery and jQuery UI CSS for Datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="form-container">
        <h2 class="text-center mb-4">Sign Up</h2>
        <form action="/register" method="POST">
            <input type="hidden" id="telegram_id" name="telegram_id" value="">

            <div class="mb-3">
                <label for="ticket" class="form-label">Ticket ID</label>
                <input type="text" class="form-control" id="ticket" name="ticket" placeholder="Choose your ticket ID" required>
            </div>
            <div class="mb-3">
                <label for="room_id" class="form-label">Select Room</label>
                <select class="form-control" id="room_id" name="room_id" required>
                    <option value="1" selected>Велика</option>
                    <option value="2">Середня</option>
                    <option value="3">Мала</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
            </div>
            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="text" class="form-control" id="birthday" name="birthday" placeholder="Select your birthday" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="/login">Sign In</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery and jQuery UI JS for Datepicker -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<!-- Initialize jQuery UI Datepicker for Birthday Input -->
<script>
    $(document).ready(function() {
        // Initialize datepicker for the birthday field
        $("#birthday").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });

        // Pre-fill form fields if data is passed in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const telegramId = urlParams.get('telegram_id');
        const firstName = urlParams.get('first_name');
        const lastName = urlParams.get('last_name');

        if (telegramId) {
            $('#telegram_id').val(telegramId);
        }
        if (firstName) {
            $('#first_name').val(firstName);
        }
        if (lastName) {
            $('#last_name').val(lastName);
        }
    });
</script>
</body>
</html>
