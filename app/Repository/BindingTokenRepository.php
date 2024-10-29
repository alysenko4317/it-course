<?php

namespace Repository;

use Model\BindingToken;

class BindingTokenRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'BindingTokens');
    }

    // Map one result to the specific model
    protected function mapResult($row) {
        return $row ? new BindingToken($row) : null;
    }

    // Find a binding token record by Telegram ID
    public function findBindingByTelegramId($telegramId) {
        try {
            // Log the Telegram ID being searched
            error_log("Searching binding token by Telegram ID: " . $telegramId);

            $result = $this->connect->execOne("SELECT * FROM bindingtokens WHERE telegram_id = $1", [$telegramId]);
            if ($result) {
                return $this->mapResult($result);
            } else {
                error_log("No binding token found for Telegram ID: " . $telegramId);
                return null;
            }

        } catch (\Exception $e) {
            error_log("Error finding binding token by Telegram ID ($telegramId): " . $e->getMessage());
            return null;
        }
    }

    public function findByBindingToken($bindingToken) {
        try {
            error_log("Searching binding by token: " . $bindingToken);

            $result = $this->connect->execOne("SELECT * FROM bindingtokens WHERE binding_token = $1", [$bindingToken]);

            if ($result) {
                return $this->mapResult($result);
            } else {
                error_log("No binding found for token: " . $bindingToken);
                return null;
            }

        } catch (\Exception $e) {
            error_log("Error finding binding by token ($bindingToken): " . $e->getMessage());
            return null; 
        }
    }

    public function saveBindingToken(array $data) {
        try {
            error_log("Saving binding token data: " . json_encode($data));
            return $this->create($data);
        } catch (\Exception $e) {
            error_log("Error saving binding token: " . $e->getMessage());
            return false;
        }
    }

    // Update an existing binding token by Telegram ID
    public function updateBindingToken(array $data) {
        $telegramId = $data['telegram_id'];
        unset($data['telegram_id']); // Remove telegram_id from the data as it is used as a key
        return $this->update($telegramId, $data);
    }
}
