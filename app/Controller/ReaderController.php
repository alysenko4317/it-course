<?php

namespace Controller;

use Model\Reader;
use Database\Connect;
use Repository\ReaderRepository;
use Framework\Session;

class ReaderController extends Controller {

    private $repository;

    public function __construct() {
        $connect = Connect::getInstance();
        $this->repository = new ReaderRepository($connect);
    }

    public function login() {
        $this->display("login");
    }

    public function register() {
        $this->display('register');
    }

    public function forgotPassword() {
        $this->display('forgot-password');
    }

    public function resetPassword() {
        $this->display('reset-password');
    }

    // POST requests

    public function loginPost() {
        Session::start();  // Start the session

        $ticket = $_POST['ticket'];
        $password = $_POST['password'];

        // Find the reader by ticket
        $reader = $this->repository->findByTicket($ticket);

        if ($reader && $this->repository->verifyPassword($password, $reader->password)) {
            // Regenerate session for security and set session value
            Session::regenerate();
            Session::set('reader_id', $reader->id);
            $this->redirect('/cabinet');
        } else {
            // Handle login error
            $this->display('login', ['error' => 'Invalid ticket or password']);
        }
    }

    public function registerPost() {
        $ticket = $_POST['ticket'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $room_id = $_POST['room_id'];  // Capture room_id from form
        $password = $_POST['password'];

        // Create a new reader instance
        $reader = new Reader();
        $reader->ticket = $ticket;
        $reader->firstName = $first_name;
        $reader->lastName = $last_name;
        $reader->birthday = $birthday;
        $reader->phone = $phone;
        $reader->roomId = $room_id;  // Set room_id

        // Hash the password
        $hashedPassword = $this->repository->hashPassword($password);
        $reader->password = $hashedPassword;

        // Save the reader to the database
        $this->repository->save($reader);

        $this->redirect('/login');
    }

    public function forgotPasswordPost() {
        $ticket = $_POST['ticket'];

        // Find the reader by ticket
        $reader = $this->repository->findByTicket($ticket);

        if ($reader) {
            // Generate password reset token
            $token = bin2hex(random_bytes(16));
            $reader->passwordResetToken = $token;
            $reader->passwordResetExpiresAt = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1-hour expiration

            // Save the reader's new token and expiry time
            $this->repository->save($reader);

            // Send email with reset token (simplified)
            mail($reader->ticket, "Password Reset", "Use this link to reset your password: /reset-password?token=$token");
        }

        // Always show success message to avoid disclosing whether the ticket exists
        $this->display('forgot-password', ['message' => 'If the ticket is valid, a reset link has been sent.']);
    }

    public function resetPasswordPost() {
        $token = $_POST['token'];
        $newPassword = $_POST['password'];

        // Find reader by the reset token
        $reader = $this->repository->findByPasswordResetToken($token);

        if ($reader && strtotime($reader->passwordResetExpiresAt) > time()) {
            // Hash the new password
            $hashedPassword = $this->repository->hashPassword($newPassword);

            // Update the password and clear the reset token
            $reader->password = $hashedPassword;
            $reader->passwordResetToken = null;
            $reader->passwordResetExpiresAt = null;

            // Save the updated reader data
            $this->repository->save($reader);

            // Redirect to login page
            $this->redirect('login');
        } else {
            // Handle invalid or expired token
            $this->display('reset-password', ['error' => 'Invalid or expired reset token']);
        }
    }

    public function logout() {
        // Clear the session or token
        Session::destroy();
        $this->redirect('login');
    }

    public function cabinet() {
        Session::start();
        $readerId = Session::get('reader_id');
        if (!$readerId) {
            $this->redirect('login');
        }

        // Find the logged-in reader
        $reader = $this->repository->getById($readerId);
		
		// Pass the reader data to the view
        $this->data("reader", $reader);
		
        $this->display('cabinet', ['reader' => $reader]);
    }
}
