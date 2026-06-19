<?php

class ActivityLog
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(int $userId, string $action): bool {

        $sql = "INSERT INTO activity_logs(user_id, action)
                VALUES(:user_id, :action)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'action' => $action
        ]);
    }

    public function getAll(): array {

        $sql = "
            SELECT
                al.*,
                u.id,
                u.name
            FROM activity_logs al
            JOIN users u ON u.id = al.user_id
            ORDER BY al.created_at DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }
}