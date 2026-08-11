<?php

require_once __DIR__ . '/../models/Ocorrencia.php';
require_once __DIR__ . '/../models/Hospede.php';
require_once __DIR__ . '/../models/Apartamento.php';

class BuscaController
{
    public function index(): void
    {
        $termo = trim($_GET['term'] ?? '');
        $scope = $_GET['scope'] ?? ($_GET['page'] ?? 'all');

        $ocorrencias = [];
        $hospedes = [];
        $apartamentos = [];

        if ($termo !== '') {
            if ($scope === 'ocorrencias') {
                $ocModel = new Ocorrencia();
                $ocorrencias = $ocModel->search($termo);
            } elseif ($scope === 'hospedes') {
                $hModel = new Hospede();
                $hospedes = $hModel->search($termo);
            } elseif ($scope === 'suites' || $scope === 'apartamentos') {
                $aModel = new Apartamento();
                $apartamentos = $aModel->search($termo);
            } else {
                // search all
                $ocModel = new Ocorrencia();
                $hModel = new Hospede();
                $aModel = new Apartamento();
                $ocorrencias = $ocModel->search($termo);
                $hospedes = $hModel->search($termo);
                $apartamentos = $aModel->search($termo);
            }
        }

        require __DIR__ . '/../views/busca/index.php';
    }
}
