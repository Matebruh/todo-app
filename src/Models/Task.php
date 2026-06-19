<?php

class Task
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllByUser(int $userId): array {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function find(int $id): array|false {
        $sql = "SELECT * FROM tasks WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function findByUser(int $id, int $userId): array|false {
        $sql = "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);

        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO tasks(user_id,title,description,priority,due_date,is_completed)
                VALUES(:user_id,:title,:description,:priority,:due_date,:is_completed)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {

        $data['id'] = $id;

        $sql = "UPDATE tasks
                SET title = :title,
                    description = :description,
                    priority = :priority,
                    due_date = :due_date,
                    is_completed = :is_completed
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM tasks WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function getLastInsertId(): int {
        return (int) $this->db->lastInsertId();
    }

    public function getAllByUserSorted(int $userId, string $sort): array {

        $orderBy = match ($sort) {
            'oldest' => 'created_at ASC',
            'priority' => 'priority DESC',
            default => 'created_at DESC'
        };

        $sql = "SELECT * FROM tasks
                WHERE user_id = :user_id
                ORDER BY $orderBy";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function getTasksByProject(int $projectId): array {

        $sql = "SELECT t.*
                FROM tasks t
                JOIN task_project tp
                    ON t.id = tp.task_id
                WHERE tp.project_id = :project_id
                ORDER BY t.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'project_id' => $projectId
        ]);

        return $stmt->fetchAll();
    }
    
    public function exportByUser(int $userId): array {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function searchByUser(int $userId, string $search): array {

        $sql = "SELECT *
                FROM tasks
                WHERE user_id = :user_id
                AND (
                    title LIKE :search
                    OR description LIKE :search
                )
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'search' => "%{$search}%"
        ]);

        return $stmt->fetchAll();
    }
}