<?php

class Attachment
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO attachments(task_id,file_name,file_path)
                VALUES(:task_id,:file_name,:file_path)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function getByTask(int $taskId): array {
        $sql = "SELECT * FROM attachments WHERE task_id = :task_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'task_id' => $taskId
        ]);

        return $stmt->fetchAll();
    }

    public function find(int $id): array|false {
        $sql = "SELECT * FROM attachments WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM attachments WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}