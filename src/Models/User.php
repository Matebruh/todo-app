<?php

class User
{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(string $name, string $email, string $password): bool {
        $sql = "INSERT INTO users(name,email,password) VALUES(:name,:email,:password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function find(int $id): array|false {
        $sql = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function findByEmail(string $email): array|false {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }

    public function updateSortPreference(int $userId, string $sort): bool {
        $sql = "UPDATE users SET task_sort = :sort WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'sort' => $sort,
            'id' => $userId
        ]);
    }

    public function getAll(): array {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function updateRole(int $id, string $role): bool {
        $sql = "UPDATE users SET role = :role WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'role' => $role,
            'id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function getActivityStats(): array {

        $sql = "
            SELECT
                u.id,
                u.name,
                u.email,
                u.role,
                u.created_at,

                COUNT(DISTINCT t.id) as tasks_count,
                COUNT(DISTINCT p.id) as projects_count

            FROM users u

            LEFT JOIN tasks t
                ON t.user_id = u.id

            LEFT JOIN projects p
                ON p.user_id = u.id

            GROUP BY u.id

            ORDER BY u.created_at DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }
}