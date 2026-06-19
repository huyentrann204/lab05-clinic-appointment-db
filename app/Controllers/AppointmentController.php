<?php
// app/Controllers/AppointmentController.php

class AppointmentController
{
    private function repository(): AppointmentRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();
        return new AppointmentRepository($pdo);
    }

    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $sort = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['direction'] ?? 'desc';

        $offset = ($page - 1) * $perPage;
        $repo = $this->repository();

        $total = $repo->countAll($q);
        $totalPages = max(1, (int) ceil($total / $perPage));

        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $appointments = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('appointments/index', compact('appointments', 'q', 'page', 'perPage', 'total', 'totalPages', 'sort', 'direction'));
    }

    public function create(): void
    {
        $errors = [];
        $old = [
            'appointment_code' => '', 
            'patient_name' => '', 
            'patient_email' => '', 
            'appointment_date' => '', 
            'status' => 'Pending', 
            'note' => ''
        ];
        view('appointments/create', compact('errors', 'old'));
    }

    
    public function store(): void
    {
        $data = $this->validate($_POST);
        $errors = $data['errors'];
        $old = $data['values'];

        if (!empty($errors)) {
            view('appointments/create', compact('errors', 'old'));
            return;
        }

        try {
            $this->repository()->create($old);
            flash_set('success', 'Appointment created successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            
            $errors['appointment_code'] = 'Mã lịch hẹn này đã tồn tại. ';
            view('appointments/create', compact('errors', 'old'));
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $appointment = $this->repository()->findById($id);

        if (!$appointment) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $errors = [];
        $old = $appointment;
        view('appointments/edit', compact('errors', 'old', 'id'));
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->validate($_POST);
        $errors = $data['errors'];
        $old = $data['values'];

        if (!empty($errors)) {
            view('appointments/edit', compact('errors', 'old', 'id'));
            return;
        }

        try {
            $this->repository()->update($id, $old);
            flash_set('success', 'Appointment updated successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            $errors['appointment_code'] = 'Mã lịch hẹn này đã tồn tại. ';
            view('appointments/edit', compact('errors', 'old', 'id'));
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->repository()->delete($id);
        flash_set('success', 'Appointment deleted successfully.');
        redirect('/appointments');
    }

    private function validate(array $input): array
    {
        $values = [
            'appointment_code' => trim($input['appointment_code'] ?? ''),
            'patient_name' => trim($input['patient_name'] ?? ''),
            'patient_email' => trim($input['patient_email'] ?? ''),
            'appointment_date' => trim($input['appointment_date'] ?? ''),
            'status' => trim($input['status'] ?? 'Pending'),
            'note' => trim($input['note'] ?? ''),
        ];

        $errors = [];
        $allowedStatuses = ['Pending', 'Completed', 'Cancelled'];

        if ($values['appointment_code'] === '') {
            $errors['appointment_code'] = 'Vui lòng nhập mã lịch hẹn.';
        }
        if ($values['patient_name'] === '') {
            $errors['patient_name'] = 'Vui lòng nhập tên bệnh nhân.';
        }
        // Cho phép rỗng, nhưng nếu nhập thì phải đúng định dạng email
        if ($values['patient_email'] !== '' && !filter_var($values['patient_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['patient_email'] = 'Email khách hàng không đúng định dạng. ';
        }
        if ($values['appointment_date'] === '') {
            $errors['appointment_date'] = 'Vui lòng chọn ngày hẹn.';
        }
        if (!in_array($values['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Trạng thái không hợp lệ.';
        }

        return ['values' => $values, 'errors' => $errors];
    }
}