<?php

require_once __DIR__ . '/../models/Hospede.php';
require_once __DIR__ . '/../models/Apartamento.php';

class HospedeController
{
    private Hospede $model;
    private Apartamento $apartamentoModel;

    public function __construct()
    {
        $this->model = new Hospede();
        $this->apartamentoModel = new Apartamento();
    }

    public function index(): void
    {
        $hospedes = $this->model->all();
        require __DIR__ . '/../views/hospedes/index.php';
    }

    public function create(): void
    {
        $errors = [];
        $suites = $this->apartamentoModel->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apartamento_id = (int)($_POST['apartamento_id'] ?? 0);
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');

            if ($apartamento_id <= 0) {
                $errors[] = 'Selecione uma suíte.';
            }
            if ($cpf === '') {
                $errors[] = 'CPF é obrigatório.';
            }
            if ($telefone === '') {
                $errors[] = 'Telefone é obrigatório.';
            }

            if (empty($errors)) {
                $limite = $this->apartamentoModel->getLimiteHospedes($apartamento_id);
                if (!$this->model->create([ 'apartamento_id' => $apartamento_id, 'cpf' => $cpf, 'telefone' => $telefone ], $limite)) {
                    $errors[] = 'Não é possível adicionar mais hóspedes nesta suíte.';
                } else {
                    $this->atualizaStatusSuite($apartamento_id);
                    header('Location: index.php?page=hospedes');
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/hospedes/form.php';
    }

    public function edit(): void
    {
        $errors = [];
        $suites = $this->apartamentoModel->all();
        $id = (int)($_GET['id'] ?? 0);
        $hospede = $this->model->find($id);

        if (!$hospede) {
            header('Location: index.php?page=hospedes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apartamento_id = (int)($_POST['apartamento_id'] ?? 0);
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');

            if ($apartamento_id <= 0) {
                $errors[] = 'Selecione uma suíte.';
            }
            if ($cpf === '') {
                $errors[] = 'CPF é obrigatório.';
            }
            if ($telefone === '') {
                $errors[] = 'Telefone é obrigatório.';
            }

            if (empty($errors)) {
                $limite = $this->apartamentoModel->getLimiteHospedes($apartamento_id);
                if (!$this->model->update($id, [ 'apartamento_id' => $apartamento_id, 'cpf' => $cpf, 'telefone' => $telefone ], $limite)) {
                    $errors[] = 'Não é possível adicionar mais hóspedes nesta suíte.';
                } else {
                    if ($hospede['apartamento_id'] !== $apartamento_id) {
                        $this->atualizaStatusSuite($hospede['apartamento_id']);
                    }
                    $this->atualizaStatusSuite($apartamento_id);
                    header('Location: index.php?page=hospedes');
                    exit;
                }
            }
        }

        require __DIR__ . '/../views/hospedes/form.php';
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $hospede = $this->model->find($id);
            $this->model->delete($id);
            if ($hospede && isset($hospede['apartamento_id'])) {
                $this->atualizaStatusSuite($hospede['apartamento_id']);
            }
        }
        header('Location: index.php?page=hospedes');
        exit;
    }

    private function atualizaStatusSuite(int $apartamentoId): void
    {
        if ($apartamentoId <= 0) {
            return;
        }

        $limite = $this->apartamentoModel->getLimiteHospedes($apartamentoId);
        $total = $this->model->countByApartamento($apartamentoId);
        $status = $total >= $limite ? 'Ocupado' : 'Disponivel';
        $this->apartamentoModel->updateStatus($apartamentoId, $status);
    }
}
