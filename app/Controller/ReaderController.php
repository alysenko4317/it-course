<?php

namespace Controller;

use Service\AuthService;
use Repository\ReaderRepository;
use Framework\Session;

class ReaderController extends Controller {

    private $authService;

    public function __construct() {
        $connect = \Database\Connect::getInstance();
        $this->authService = new AuthService($connect);
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
        Session::start();

        $ticket = $_POST['ticket'];
        $password = $_POST['password'];

        $reader = $this->authService->login($ticket, $password);

        if ($reader) {
            Session::regenerate();
            Session::set('reader_id', $reader->id);
            $this->redirect('/cabinet');
        } else {
            $this->display('login', ['error' => 'Invalid ticket or password']);
        }
    }

    public function registerPost() {
        $data = [
            'ticket' => $_POST['ticket'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'birthday' => $_POST['birthday'],
            'phone' => $_POST['phone'],
            'room_id' => $_POST['room_id'],
            'password' => $_POST['password'],
            'telegram_id' => $_POST['telegram_id'] ?? null
        ];

        if ($this->authService->register($data)) {
            $this->redirect('/login');
        } else {
            $this->display('register', ['error' => 'Registration failed']);
        }
    }

    public function forgotPasswordPost() {
        $ticket = $_POST['ticket'];
        $this->authService->forgotPassword($ticket);
        $this->display('forgot-password', ['message' => 'If the ticket is valid, a reset link has been sent.']);
    }

    public function resetPasswordPost() {
        $token = $_POST['token'];
        $newPassword = $_POST['password'];

        if ($this->authService->resetPassword($token, $newPassword)) {
            $this->redirect('login');
        } else {
            $this->display('reset-password', ['error' => 'Invalid or expired reset token']);
        }
    }

    public function logout() {
        Session::destroy();
        $this->redirect('login');
    }

    public function cabinet() {
        Session::start();
        $readerId = Session::get('reader_id');
        if (!$readerId) {
            $this->redirect('login');
        }

        $reader = $this->authService->getReaderById($readerId);
        $this->display('cabinet', ['reader' => $reader]);
    }

    public function linkTelegramAccount() {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            http_response_code(400);
            echo 'Error: Missing token';
            return;
        }

        $telegramData = $this->authService->getTelegramBindingData($token);

        if ($telegramData) {
            $this->redirect('/register', [
                'telegram_id' => $telegramData->telegramId,
                'first_name' => $telegramData->firstName,
                'last_name' => $telegramData->lastName
            ]);
        } else {
            http_response_code(404);
            echo 'Error: No binding data found for this token';
        }
    }
}
