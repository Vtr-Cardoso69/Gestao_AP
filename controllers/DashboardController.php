<?php

require_once __DIR__ . '/../models/Apartamento.php';
require_once __DIR__ . '/../models/Ocorrencia.php';

class DashboardController
{
    private Apartamento $apartamentoModel;
    private Ocorrencia $ocorrenciaModel;

    public function __construct()
    {
        $this->apartamentoModel = new Apartamento();
        $this->ocorrenciaModel = new Ocorrencia();
    }

    public function index(): void
    {
        $totalSuites = count($this->apartamentoModel->all());
        $ocupadas = $this->apartamentoModel->countOccupied();
        $disponiveis = $this->apartamentoModel->countAvailable();
        $pendentes = $this->ocorrenciaModel->countByStatus('Pendente');
        $emAndamento = $this->ocorrenciaModel->countByStatus('Em Andamento');
        $resolvidas = $this->ocorrenciaModel->countByStatus('Resolvido');

        require __DIR__ . '/../views/dashboard/index.php';
    }
}
