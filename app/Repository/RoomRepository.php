<?php

namespace Repository;

use Model\Room;

class RoomRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'room');  // Таблиця 'room'
    }

    protected function mapResult($row) {
        $room = new Room();
        $room->id = $row['id'];
        $room->name = $row['name'];
        $room->amount = $row['amount'];
        return $room;
    }
}
