<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="text-center mb-4">
    <h1 class="page-title">Painel de Controle</h1>
    
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h5>Total de suítes</h5>
            <p class="display-6 mb-0"><?php echo $totalSuites; ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <h5>Disponíveis</h5>
            <p class="display-6 mb-0"><?php echo $disponiveis; ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <h5>Ocupadas</h5>
            <p class="display-6 mb-0"><?php echo $ocupadas; ?></p>
        </div>
    </div>
</div>
<div class="row g-4 mt-3">
    <div class="col-md-12">
        <div class="card p-4">
            <h5>Ocorrências por status</h5>
            <div class="row text-center mt-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <strong>Pendentes</strong>
                        <p class="mb-0 display-6"><?php echo $pendentes; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <strong>Em andamento</strong>
                        <p class="mb-0 display-6"><?php echo $emAndamento; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <strong>Resolvidas</strong>
                        <p class="mb-0 display-6"><?php echo $resolvidas; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
