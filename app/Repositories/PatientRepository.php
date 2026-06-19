<?php

class PatientRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Đếm tổng số bệnh nhân
     */
    public function countAll(string $q = ''): int
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM patients
        ";

        $params = [];

        if ($q !== '') {
            $sql .= "
                WHERE
                    name LIKE :q1
                    OR email LIKE :q2
                    OR phone LIKE :q3
            ";

            $params['q1'] = '%' . $q . '%';
            $params['q2'] = '%' . $q . '%';
            $params['q3'] = '%' . $q . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) ($stmt->fetch()['total'] ?? 0);
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

        // Thêm status vào danh sách được phép sort
        $allowedSorts = [
            'id',
            'name',
            'email',
            'phone',
            'gender',
            'status', 
            'created_at'
        ];

        $allowedDirections = [
            'asc',
            'desc'
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array(
            strtolower($direction),
            $allowedDirections,
            true
        )) {
            $direction = 'desc';
        }

        // Bổ sung gọi field status trong câu SELECT
        $sql = "
            SELECT
                id,
                name,
                email,
                phone,
                gender,
                status,
                created_at
            FROM patients
        ";

        $params = [];

        if ($q !== '') {
            $sql .= "
                WHERE
                    name LIKE :q1
                    OR email LIKE :q2
                    OR phone LIKE :q3
            ";
            $params['q1'] = '%' . $q . '%';
            $params['q2'] = '%' . $q . '%';
            $params['q3'] = '%' . $q . '%';
        }

        $sql .= "
            ORDER BY {$sort} {$direction}
            LIMIT :limit
            OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(
                ':' . $key,
                $value,
                PDO::PARAM_STR
            );
        }

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
     * Tìm bệnh nhân theo ID
     */
    public function findById(int $id): ?array
    {
        // Thêm status vào lúc lấy dữ liệu ra sửa
        $stmt = $this->db->prepare("
            SELECT
                id,
                name,
                email,
                phone,
                gender,
                status
            FROM patients
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Tạo bệnh nhân mới
     */
    public function create(array $data): bool
    {
        // Bổ sung cột status vào INSERT
        $sql = "
            INSERT INTO patients
            (
                name,
                email,
                phone,
                gender,
                status
            )
            VALUES
            (
                :name,
                :email,
                :phone,
                :gender,
                :status
            )
        ";

        try {
            $stmt = $this->db->prepare($sql);

            // Truyền dữ liệu status vào
            return $stmt->execute([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?: null,
                'gender' => $data['gender'],
                'status' => $data['status']
            ]);

        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException(
                    'Patient email already exists.'
                );
            }
            throw $e;
        }
    }

    /**
     * Cập nhật bệnh nhân
     */
    public function update(
        int $id,
        array $data
    ): bool {

        // Bổ sung cập nhật cột status
        $sql = "
            UPDATE patients
            SET
                name = :name,
                email = :email,
                phone = :phone,
                gender = :gender,
                status = :status,
                updated_at = NOW()
            WHERE id = :id
        ";

        try {
            $stmt = $this->db->prepare($sql);

            // Truyền dữ liệu status vào
            return $stmt->execute([
                'id' => $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?: null,
                'gender' => $data['gender'],
                'status' => $data['status']
            ]);

        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException(
                    'Patient email already exists.'
                );
            }
            throw $e;
        }
    }

    /**
     * Xóa bệnh nhân
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM patients
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}