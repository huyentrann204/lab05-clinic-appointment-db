<?php

class PatientController
{
    private function repository(): PatientRepository
    {
        $config = require __DIR__ . '/../../config/database.php';

        $pdo = (new Database($config))
            ->getConnection();

        return new PatientRepository($pdo);
    }

    public function index(): void
    {
        try {
            $q = trim($_GET['q'] ?? '');
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $perPage = 10;
            $sort = $_GET['sort'] ?? 'created_at';
            $direction = $_GET['direction'] ?? 'desc';
            $offset = ($page - 1) * $perPage;

            $repo = $this->repository();
            $total = $repo->countAll($q);

            $totalPages = max(
                1,
                (int) ceil($total / $perPage)
            );

            if ($page > $totalPages) {
                $page = $totalPages;
                $offset = ($page - 1) * $perPage;
            }

            $patients = $repo->getPaginated(
                $q,
                $perPage,
                $offset,
                $sort,
                $direction
            );

            view(
                'patients/index',
                compact(
                    'patients',
                    'q',
                    'page',
                    'perPage',
                    'total',
                    'totalPages',
                    'sort',
                    'direction'
                )
            );
        } catch (Exception $e) {
            // Bắt lỗi mất kết nối DB và hiển thị Safe Error Message
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }
    public function create(): void
    {
        $errors = [];

        // Bổ sung 'status' vào mảng dữ liệu cũ (old data)
        $old = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'gender' => 'Other',
            'status' => 'new' 
        ];

        view(
            'patients/create',
            compact('errors', 'old')
        );
    }

    public function store(): void
    {
        $data = $this->validate($_POST);
        $errors = $data['errors'];
        $old = $data['values'];

        if (!empty($errors)) {
            view(
                'patients/create',
                compact('errors', 'old')
            );
            return;
        }

        try {
            $this->repository()
                ->create($old);

            flash_set(
                'success',
                'Patient created successfully.'
            );

            redirect('/patients');

        } catch (DuplicateRecordException $e) {
            $errors['email'] =
                'Email này đã tồn tại trong hệ thống.';

            view(
                'patients/create',
                compact('errors', 'old')
            );

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $patient = $this->repository()
            ->findById($id);

        if (!$patient) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $errors = [];
        $old = $patient;

        view(
            'patients/edit',
            compact(
                'errors',
                'old',
                'id'
            )
        );
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $patient = $this->repository()
            ->findById($id);

        if (!$patient) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $data = $this->validate($_POST);
        $errors = $data['errors'];
        $old = $data['values'];

        if (!empty($errors)) {
            view(
                'patients/edit',
                compact(
                    'errors',
                    'old',
                    'id'
                )
            );
            return;
        }

        try {
            $this->repository()
                ->update($id, $old);

            flash_set(
                'success',
                'Patient updated successfully.'
            );

            redirect('/patients');

        } catch (DuplicateRecordException $e) {
            $errors['email'] =
                'Email này đã tồn tại trong hệ thống.';

            view(
                'patients/edit',
                compact(
                    'errors',
                    'old',
                    'id'
                )
            );

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function delete(): void
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);

            $patient = $this->repository()
                ->findById($id);

            if (!$patient) {
                http_response_code(404);
                view('errors/404');
                return;
            }

            $this->repository()
                ->delete($id);

            flash_set(
                'success',
                'Patient deleted successfully.'
            );

            redirect('/patients');

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    private function validate(array $input): array
    {
        // Bổ sung hứng dữ liệu status từ form
        $values = [
            'name' => trim($input['name'] ?? ''),
            'email' => trim($input['email'] ?? ''),
            'phone' => trim($input['phone'] ?? ''),
            'gender' => trim($input['gender'] ?? 'Other'),
            'status' => trim($input['status'] ?? 'new')
        ];

        $errors = [];

        $allowedGenders = [
            'Male',
            'Female',
            'Other'
        ];

        // Mảng các trạng thái hợp lệ theo chuẩn tài liệu
        $allowedStatuses = [
            'new',
            'contacted',
            'qualified',
            'lost'
        ];

        if ($values['name'] === '') {
            $errors['name'] =
                'Vui lòng nhập họ tên.';
        }

        if ($values['email'] === '') {
            $errors['email'] =
                'Vui lòng nhập email.';
        } elseif (
            !filter_var(
                $values['email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {
            $errors['email'] =
                'Email không đúng định dạng.';
        }

        if (
            !in_array(
                $values['gender'],
                $allowedGenders,
                true
            )
        ) {
            $errors['gender'] =
                'Giới tính không hợp lệ.';
        }

        // Bắt lỗi validate nếu user gửi trạng thái linh tinh
        if (
            !in_array(
                $values['status'],
                $allowedStatuses,
                true
            )
        ) {
            $errors['status'] =
                'Trạng thái không hợp lệ.';
        }

        return [
            'values' => $values,
            'errors' => $errors
        ];
    }
}