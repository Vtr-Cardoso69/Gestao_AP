<?php

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Apartamento.php';
require_once __DIR__ . '/models/Hospede.php';
require_once __DIR__ . '/models/Ocorrencia.php';
require_once __DIR__ . '/controllers/ApartamentoController.php';
require_once __DIR__ . '/controllers/HospedeController.php';
require_once __DIR__ . '/controllers/OcorrenciaController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/BuscaController.php';

$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'suites':
        $controller = new ApartamentoController();
        break;
    case 'hospedes':
        $controller = new HospedeController();
        break;
    case 'ocorrencias':
        $controller = new OcorrenciaController();
        break;
    case 'busca':
        $controller = new BuscaController();
        break;
    default:
        $controller = new DashboardController();
        break;
}

$method = $action;
if (!method_exists($controller, $method)) {
    $method = 'index';
}

$controller->{$method}();
