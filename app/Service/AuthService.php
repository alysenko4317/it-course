<?php

namespace Service;

use Model\Reader;
use Model\BindingToken;
use Repository\ReaderRepository;
use Repository\BindingTokenRepository;

class AuthService {
    private $repository;
    private $bindingTokenRepository;

    public function __construct($connect)
    {
        $this->repository = new ReaderRepository($connect);
        $this->bindingTokenRepository = new BindingTokenRepository($connect);
    }

    public function register(array $data): bool {
        $reader = new Reader();
        $reader->ticket = $data['ticket'];
        $reader->firstName = $data['first_name'];
        $reader->lastName = $data['last_name'];
        $reader->birthday = $data['birthday'];
        $reader->phone = $data['phone'];
        $reader->roomId = $data['room_id'];
        $reader->telegramId = $data['telegram_id'];
        $reader->password = $this->repository->hashPassword($data['password']);

        return $this->repository->save($reader);
    }

    public function login(string $ticket, string $password): ?Reader {
        $reader = $this->repository->findByTicket($ticket);
        if ($reader && $this->repository->verifyPassword($password, $reader->password)) {
            return $reader;
        }
        return null;
    }

    public function forgotPassword(string $ticket): void {
        $reader = $this->repository->findByTicket($ticket);
        if ($reader) {
            $token = bin2hex(random_bytes(16));
            $reader->passwordResetToken = $token;
            $reader->passwordResetExpiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->repository->save($reader);
            
            // Отправка письма
            mail($reader->ticket, "Password Reset", "Use this link to reset your password: /reset-password?token=$token");
        }
    }

    public function resetPassword(string $token, string $newPassword): bool {
        $reader = $this->repository->findByPasswordResetToken($token);
        if ($reader && strtotime($reader->passwordResetExpiresAt) > time()) {
            $reader->password = $this->repository->hashPassword($newPassword);
            $reader->passwordResetToken = null;
            $reader->passwordResetExpiresAt = null;
            return $this->repository->save($reader);
        }
        return false;
    }

    public function linkTelegramAccount(string $token, string $telegramId): bool {
        $reader = $this->repository->findByPasswordResetToken($token);
        if ($reader) {
            $reader->telegramId = $telegramId;
            return $this->repository->save($reader);
        }
        return false;
    }

    public function saveOrUpdateBindingTokenWithUserData(array $data): bool
    {
        // Extract data from the input array
        $telegramId = $data['telegram_id'] ?? null;
        $bindingToken = $data['binding_token'] ?? null;
        $firstName = $data['first_name'] ?? null;
        $lastName = $data['last_name'] ?? null;
        $username = $data['username'] ?? null;
        $phone = $data['phone'] ?? null;

        // Check if a record for this Telegram ID already exists
        $binding = $this->bindingTokenRepository->findBindingByTelegramId($telegramId);

        if (!$binding) {
            // If the record doesn't exist, create a new binding record
            $binding = [
                'telegram_id' => $telegramId,
                'binding_token' => $bindingToken,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'phone' => $phone,
                'created_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day')) // Token expires in 1 day
            ];

            return $this->bindingTokenRepository->saveBindingToken($binding);
        } else {
            // If the record exists, update the existing record with new binding token and user data
            $binding['binding_token'] = $bindingToken;
            $binding['first_name'] = $firstName;
            $binding['last_name'] = $lastName;
            $binding['username'] = $username;
            $binding['phone'] = $phone;
            $binding['expires_at'] = date('Y-m-d H:i:s', strtotime('+1 day')); // Update expiry time

            return $this->bindingTokenRepository->updateBindingToken($binding);
        }
    }
	
	public function getReaderById(int $readerId): ?Reader {
        return $this->repository->getById($readerId);
    }

    public function getTelegramBindingData(string $token): ?BindingToken {
        return $this->bindingTokenRepository->findByBindingToken($token);
    }
}
