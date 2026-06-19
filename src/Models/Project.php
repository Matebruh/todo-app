<?php

class Project
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllByUser(int $userId): array {
        $sql = "SELECT * FROM projects WHERE user_id = :user_id ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO projects(user_id,name,description)
                VALUES(:user_id,:name,:description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function getProjectsForTask(int $taskId): array {
        $sql = "SELECT p.*
                FROM projects p
                JOIN task_project tp ON p.id = tp.project_id
                WHERE tp.task_id = :task_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'task_id' => $taskId
        ]);

        return $stmt->fetchAll();
    }

    public function assignToTask(int $taskId, array $projectIds): void {

        $sql = "DELETE FROM task_project WHERE task_id = :task_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'task_id' => $taskId
        ]);

        foreach ($projectIds as $projectId) {

            $sql = "INSERT INTO task_project(task_id, project_id)
                    VALUES(:task_id, :project_id)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'task_id' => $taskId,
                'project_id' => $projectId
            ]);
        }
    }

    public function getProjectIdsForTask(int $taskId): array {
        $sql = "SELECT project_id FROM task_project WHERE task_id = :task_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'task_id' => $taskId
        ]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findByUser(int $projectId, int $userId): array|false {
        $sql = "SELECT * FROM projects
                WHERE id = :id
                AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $projectId,
            'user_id' => $userId
        ]);

        return $stmt->fetch();
    }

    public function getProgress(int $projectId): int {

        $sql = "
            SELECT
                COUNT(*) as total,
                SUM(is_completed) as completed
            FROM tasks t
            JOIN task_project tp
                ON t.id = tp.task_id
            WHERE tp.project_id = :project_id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'project_id' => $projectId
        ]);

        $result = $stmt->fetch();

        if (!$result['total']) {
            return 0;
        }

        return round(
            ($result['completed'] / $result['total']) * 100
        );
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM projects WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function update(int $id, array $data): bool {

        $sql = "UPDATE projects
                SET name = :name,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }
}