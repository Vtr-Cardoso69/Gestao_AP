<?php

require_once __DIR__ . '/../models/Apartamento.php';
require_once __DIR__ . '/../models/Hospede.php';

class ApartamentoController
{
    private Apartamento $model;
    private Hospede $hospedeModel;

    public function __construct()
    {
        $this->model = new Apartamento();
        $this->hospedeModel = new Hospede();
    }



    public function index(): void
    {
        // Recalcula status de todas as suítes rapidamente antes de exibir
        $suites = $this->model->all();
        foreach ($suites as $s) {
            $id = (int)$s['id'];
            $limite = $this->model->getLimiteHospedes($id);
            $total = $this->hospedeModel->countByApartamento($id);
            $status = $total >= $limite ? 'Ocupado' : 'Disponivel';
            if ($s['status'] !== $status) {
                $this->model->updateStatus($id, $status);
            }
        }

        // Buscar novamente para garantir exibição com status atualizados
        $suites = $this->model->all();
        require __DIR__ . '/../views/suites/index.php';
    }



    public function create(): void
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = trim($_POST['numero'] ?? '');
            $bloco_andar = trim($_POST['bloco_andar'] ?? '');
            $categoria = trim($_POST['categoria'] ?? 'Suíte Romântica');
            $limite_hospedes = max(1, min(6, (int)($_POST['limite_hospedes'] ?? 2)));
            $status = $_POST['status'] ?? 'Disponivel';

            if ($numero === '') {
                $errors[] = 'Número da suíte é obrigatório.';
            }
            if ($bloco_andar === '') {
                $errors[] = 'Bloco / Andar é obrigatório.';
            }
            if ($limite_hospedes < 1) {
                $errors[] = 'Limite de hóspedes deve ser no mínimo 1.';
            }

            if (empty($errors)) {
                $auto_status = isset($_POST['auto_status']) ? 1 : 0;
                $this->model->create([
                    'numero' => $numero,
                    'bloco_andar' => $bloco_andar,
                    'categoria' => $categoria,
                    'limite_hospedes' => $limite_hospedes,
                    'status' => $status,
                    'auto_status' => $auto_status,
                ]);
                header('Location: index.php?page=suites');
                exit;
            }
        }
        require __DIR__ . '/../views/suites/form.php';
    }



    public function edit(): void
    {
        $errors = [];
        $id = (int)($_GET['id'] ?? 0);
        $suite = $this->model->find($id);



        if (!$suite) {
            header('Location: index.php?page=suites');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = trim($_POST['numero'] ?? '');
            $bloco_andar = trim($_POST['bloco_andar'] ?? '');
            $categoria = trim($_POST['categoria'] ?? 'Suíte Romântica');
            $limite_hospedes = max(1, min(6, (int)($_POST['limite_hospedes'] ?? 2)));
            $status = $_POST['status'] ?? 'Disponivel';

            if ($numero === '') {
                $errors[] = 'Número da suíte é obrigatório.';
            }
            if ($bloco_andar === '') {
                $errors[] = 'Bloco / Andar é obrigatório.';
            }
            if ($limite_hospedes < 1) {
                $errors[] = 'Limite de hóspedes deve ser no mínimo 1.';
            }

            if (empty($errors)) {
                // Respeita o status e auto_status enviados pelo usuário no formulário.
                $auto_status = isset($_POST['auto_status']) ? 1 : 0;
                $this->model->update($id, [
                    'numero' => $numero,
                    'bloco_andar' => $bloco_andar,
                    'categoria' => $categoria,
                    'limite_hospedes' => $limite_hospedes,
                    'status' => $status,
                    'auto_status' => $auto_status,
                ]);
                header('Location: index.php?page=suites');
                exit;
            }
        }
        require __DIR__ . '/../views/suites/form.php';
    }


    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
        }
        header('Location: index.php?page=suites');
        exit;
    }

    private function calculateSuiteStatus(int $apartamentoId, int $limiteHospedes): string
    {
        $total = $this->hospedeModel->countByApartamento($apartamentoId);
        return $total >= $limiteHospedes ? 'Ocupado' : 'Disponivel';
    }
}
