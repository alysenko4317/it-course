<?php

namespace Model;

class BindingToken {
    public $id;
    public $telegramId;
    public $bindingToken;
    public $firstName;
    public $lastName;
    public $username;
    public $phone;
    public $createdAt;
    public $expiresAt;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->telegramId = $data['telegram_id'] ?? null;
        $this->bindingToken = $data['binding_token'] ?? null;
        $this->firstName = $data['first_name'] ?? null;
        $this->lastName = $data['last_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->createdAt = $data['created_at'] ?? null;
        $this->expiresAt = $data['expires_at'] ?? null;
    }
}
