<?php

require_once __DIR__ . '/../models/Ocorrencia.php';
require_once __DIR__ . '/../models/Apartamento.php';
require_once __DIR__ . '/../models/Hospede.php';

class OcorrenciaController
{
    private Ocorrencia $model;
    private Apartamento $apartamentoModel;
    private Hospede $hospedeModel;

    public function __construct()
    {
        $this->model = new Ocorrencia();
        $this->apartamentoModel = new Apartamento();
        $this->hospedeModel = new Hospede();
    }

    public function index(): void
    {
        $ocorrencias = $this->model->all();
        require __DIR__ . '/../views/ocorrencias/index.php';
    }

    public function create(): void
    {
        $errors = [];
        $suites = $this->apartamentoModel->all();
        $hospedes = $this->hospedeModel->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apartamento_id = (int)($_POST['apartamento_id'] ?? 0);
            $morador_id = (int)($_POST['morador_id'] ?? 0);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $tipo_ocorrencia = $_POST['tipo_ocorrencia'] ?? 'Quarto';
            $status = $_POST['status'] ?? 'Pendente';

            // Exigir ao menos uma referência: suíte ou hóspede
            if ($apartamento_id <= 0 && $morador_id <= 0) {
                $errors[] = 'Selecione uma suíte ou escolha um hóspede.';
            }
            if ($titulo === '') {
                $errors[] = 'Título é obrigatório.';
            }
            if ($descricao === '') {
                $errors[] = 'Descrição é obrigatória.';
            }

            if (empty($errors)) {
                $this->model->create([
                    'apartamento_id' => $apartamento_id,
                    'morador_id' => $morador_id,
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'tipo_ocorrencia' => $tipo_ocorrencia,
                    'status' => $status
                ]);
                header('Location: index.php?page=ocorrencias');
                exit;
            }
        }

        require __DIR__ . '/../views/ocorrencias/form.php';
    }

    public function edit(): void
    {
        $errors = [];
        $suites = $this->apartamentoModel->all();
        $hospedes = $this->hospedeModel->all();
        $id = (int)($_GET['id'] ?? 0);
        $ocorrencia = $this->model->find($id);

        if (!$ocorrencia) {
            header('Location: index.php?page=ocorrencias');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $apartamento_id = (int)($_POST['apartamento_id'] ?? 0);
            $morador_id = (int)($_POST['morador_id'] ?? 0);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $tipo_ocorrencia = $_POST['tipo_ocorrencia'] ?? 'Quarto';
            $status = $_POST['status'] ?? 'Pendente';

            // Exigir ao menos uma referência: suíte ou hóspede
            if ($apartamento_id <= 0 && $morador_id <= 0) {
                $errors[] = 'Selecione uma suíte ou escolha um hóspede.';
            }
            if ($titulo === '') {
                $errors[] = 'Título é obrigatório.';
            }
            if ($descricao === '') {
                $errors[] = 'Descrição é obrigatória.';
            }

            if (empty($errors)) {
                $this->model->update($id, [
                    'apartamento_id' => $apartamento_id,
                    'morador_id' => $morador_id,
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'tipo_ocorrencia' => $tipo_ocorrencia,
                    'status' => $status
                ]);
                header('Location: index.php?page=ocorrencias');
                exit;
            }
        }

        require __DIR__ . '/../views/ocorrencias/form.php';
    }

    public function resolver(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->marcarResolvido($id);
        }
        header('Location: index.php?page=ocorrencias');
        exit;
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
        }
        header('Location: index.php?page=ocorrencias');
        exit;
    }
}
