<?php

namespace Repository;

use Model\Reader;

class ReaderRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'reader');  // Таблиця 'reader'
    }

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
        return $reader;
    }
}
