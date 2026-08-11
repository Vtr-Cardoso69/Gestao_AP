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
                $this->model->create([
                    'numero' => $numero,
                    'bloco_andar' => $bloco_andar,
                    'categoria' => $categoria,
                    'limite_hospedes' => $limite_hospedes,
                    'status' => 'Disponivel'
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
                $status = $this->calculateSuiteStatus($id, $limite_hospedes);
                $this->model->update($id, [
                    'numero' => $numero,
                    'bloco_andar' => $bloco_andar,
                    'categoria' => $categoria,
                    'limite_hospedes' => $limite_hospedes,
                    'status' => $status
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
