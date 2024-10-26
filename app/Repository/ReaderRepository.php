<?php

namespace Repository;

use Model\Reader;

class ReaderRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'reader');  // Table 'reader'
    }

    // Map the database row to the Reader model
    protected function mapResult($row) {
        $reader = new Reader();
        $reader->id = $row['id'];
        $reader->ticket = $row['ticket'];
        $reader->firstName = $row['first_name'];
        $reader->lastName = $row['last_name'];
        $reader->otherName = $row['other_name'];
        $reader->birthday = $row['birthday'];
        $reader->registrationDate = $row['registration_date'];
        $reader->releaseDate = $row['release_date'];
        $reader->phone = $row['phone'];
        $reader->education = $row['education'];
        $reader->degree = $row['degree'];
        $reader->roomId = $row['room_id'];
        $reader->password = $row['password'];
        $reader->passwordResetToken = $row['password_reset_token'];  // password reset token field
        return $reader;
    }

    // Find Reader by ticket
    public function findByTicket($ticket) {
        $result = $this->connect->execOne("SELECT * FROM reader WHERE ticket = $1", [$ticket]);
        if ($result) {
            return $this->mapResult($result);
        }
        return null;
    }

    // Find Reader by password reset token
    public function findByPasswordResetToken($token) {
        $result = $this->connect->execOne("SELECT * FROM reader WHERE password_reset_token = $1", [$token]);
        if ($result) {
            return $this->mapResult($result);
        }
        return null;
    }

    public function save(Reader $reader) {
        if ($reader->id) {
            // Update existing Reader
            $this->connect->exec(
                "UPDATE reader SET first_name = $1, last_name = $2, birthday = $3, phone = $4, room_id = $5, password = $6, password_reset_token = $7 WHERE id = $8", 
                [
                    $reader->firstName,
                    $reader->lastName,
                    $reader->birthday,
                    $reader->phone,
                    $reader->roomId,  // Include room_id
                    $reader->password,  // Hashed password
                    $reader->passwordResetToken,
                    $reader->id
                ]
            );
        } else {
            // Insert new Reader
            $this->connect->exec(
                "INSERT INTO reader (ticket, first_name, last_name, birthday, phone, room_id, password, registration_date) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)", 
                [
                    $reader->ticket,
                    $reader->firstName,
                    $reader->lastName,
                    $reader->birthday,
                    $reader->phone,
                    $reader->roomId,  // Include room_id
                    $reader->password,  // Hashed password
                    date('Y-m-d')  // Registration date
                ]
            );
            $reader->id = $this->connect->getLastId("reader_id_seq");
        }
    }
    
    // Hash the password and return the hashed value
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Verify the password against the hashed password in the database
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
