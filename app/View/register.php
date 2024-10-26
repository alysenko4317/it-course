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
        /* Optional: you can customize the max width of the form here */
        .form-container {
            max-width: 400px; /* Sets a fixed max width for the form */
            margin: 0 auto; /* Centers the form horizontally */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Sign Up</h2>
			<form action="/register" method="POST">
				<div class="mb-3">
					<label for="ticket" class="form-label">Ticket ID</label>
					<input type="text" class="form-control" id="ticket" name="ticket" placeholder="Choose your ticket ID" required>
				</div>
				<div class="mb-3">
    <label for="room_id" class="form-label">Select Room</label>
    <select class="form-control" id="room_id" name="room_id" required>
        <option value="1" selected>Велика</option>  <!-- FIXME: we should get this dynamically with AJAX request -->
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
					<label for="phone" class="form-label">Phone</label> <!-- Add phone field -->
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
            $("#birthday").datepicker({
                dateFormat: "yy-mm-dd",  // Set date format to match SQL format
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"  // Limit the year range to 100 years in the past
            });
        });
    </script>
</body>
</html>
