<?php

class PatientRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $this->pdo = (new Database($config))
            ->getConnection();
    }

    /**
     * Đếm tổng số bệnh nhân
     */
    public function countAll(string $q = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM patients
            WHERE
                name LIKE :q
                OR email LIKE :q
                OR phone LIKE :q
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'q' => "%{$q}%"
        ]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * Danh sách phân trang
     */
    public function getPaginated(
        string $q,
        int $limit,
        int $offset,
        string $sort,
        string $direction
    ): array {

        $allowedSorts = [
            'name',
            'email',
            'created_at'
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $allowedDirections = [
            'asc',
            'desc'
        ];

        if (!in_array(strtolower($direction), $allowedDirections, true)) {
            $direction = 'desc';
        }

        $sql = "
            SELECT
                id,
                name,
                email,
                phone,
                gender,
                created_at
            FROM patients
            WHERE
                name LIKE :q
                OR email LIKE :q
                OR phone LIKE :q
            ORDER BY {$sort} {$direction}
            LIMIT :limit
            OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(
            ':q',
            "%{$q}%"
        );

        $stmt->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Tạo bệnh nhân mới
     */
    public function create(array $data): void
    {
        try {

            $sql = "
                INSERT INTO patients
                (
                    name,
                    email,
                    phone,
                    gender
                )
                VALUES
                (
                    :name,
                    :email,
                    :phone,
                    :gender
                )
            ";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender']
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new DuplicateRecordException();
            }

            throw $e;
        }
    }

    /**
     * Tìm bệnh nhân theo ID
     */
    public function findById(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                name,
                email,
                phone,
                gender
            FROM patients
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $patient = $stmt->fetch();

        return $patient ?: null;
    }

    /**
     * Cập nhật bệnh nhân
     */
    public function update(
        int $id,
        array $data
    ): void {

        try {

            $sql = "
                UPDATE patients
                SET
                    name = :name,
                    email = :email,
                    phone = :phone,
                    gender = :gender
                WHERE id = :id
            ";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender']
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new DuplicateRecordException();
            }

            throw $e;
        }
    }

    /**
     * Xóa bệnh nhân
     */
    public function delete(int $id): void
    {
        $sql = "
            DELETE FROM patients
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);
    }
}