<?php

class AppointmentRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $this->pdo = (new Database($config))
            ->getConnection();
    }

    /**
     * Đếm tổng số lịch hẹn
     */
    public function countAll(string $q = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            WHERE
                appointment_code LIKE :q
                OR patient_name LIKE :q
                OR patient_email LIKE :q
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
            'appointment_code',
            'appointment_date',
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
                appointment_code,
                patient_name,
                patient_email,
                appointment_date,
                status,
                created_at
            FROM appointments
            WHERE
                appointment_code LIKE :q
                OR patient_name LIKE :q
                OR patient_email LIKE :q
            ORDER BY {$sort} {$direction}
            LIMIT :limit
            OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':q', "%{$q}%");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Tạo lịch hẹn mới
     */
    public function create(array $data): void
    {
        try {

            $sql = "
                INSERT INTO appointments
                (
                    appointment_code,
                    patient_name,
                    patient_email,
                    appointment_date,
                    status,
                    note
                )
                VALUES
                (
                    :appointment_code,
                    :patient_name,
                    :patient_email,
                    :appointment_date,
                    :status,
                    :note
                )
            ";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'appointment_code' => $data['appointment_code'],
                'patient_name' => $data['patient_name'],
                'patient_email' => $data['patient_email'],
                'appointment_date' => $data['appointment_date'],
                'status' => $data['status'],
                'note' => $data['note']
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new DuplicateRecordException();
            }

            throw $e;
        }
    }

    /**
     * Tìm theo ID
     */
    public function findById(int $id): ?array
    {
        $sql = "
            SELECT *
            FROM appointments
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $appointment = $stmt->fetch();

        return $appointment ?: null;
    }

    /**
     * Update lịch hẹn
     */
    public function update(
        int $id,
        array $data
    ): void {

        try {

            $sql = "
                UPDATE appointments
                SET
                    appointment_code = :appointment_code,
                    patient_name = :patient_name,
                    patient_email = :patient_email,
                    appointment_date = :appointment_date,
                    status = :status,
                    note = :note
                WHERE id = :id
            ";

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'id' => $id,
                'appointment_code' => $data['appointment_code'],
                'patient_name' => $data['patient_name'],
                'patient_email' => $data['patient_email'],
                'appointment_date' => $data['appointment_date'],
                'status' => $data['status'],
                'note' => $data['note']
            ]);

        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                throw new DuplicateRecordException();
            }

            throw $e;
        }
    }

    /**
     * Xóa lịch hẹn
     */
    public function delete(int $id): void
    {
        $sql = "
            DELETE FROM appointments
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);
    }
}