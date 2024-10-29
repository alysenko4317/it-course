<?php

namespace Model;

class Reader {
    public $id;
    public $ticket;
    public $firstName;
    public $lastName;
    public $otherName;
    public $birthday;
    public $registrationDate;
    public $releaseDate;
    public $phone;
    public $education;
    public $degree;
    public $roomId;
    public $telegramId;
    public $password;  // To store hashed password
    public $passwordResetToken;  // For password reset functionality
}
