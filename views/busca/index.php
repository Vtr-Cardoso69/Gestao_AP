<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Resultados da busca</h2>
        <p class="text-muted">Exibindo resultados para: <strong><?php echo htmlspecialchars($termo); ?></strong></p>
    </div>
    <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
</div>

<?php if (!empty($ocorrencias)): ?>
    <h4>Ocorrências</h4>
    <div class="card p-3 mb-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Suíte</th>
                        <th>CPF</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ocorrencias as $ocorrencia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ocorrencia['apartamento_numero']); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['morador_cpf'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['tipo_ocorrencia']); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['status']); ?></td>
                            <td><?php echo htmlspecialchars($ocorrencia['data_registro']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($hospedes)): ?>
    <h4>Hóspedes</h4>
    <div class="card p-3 mb-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Suíte</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Cadastrado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hospedes as $hospede): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($hospede['apartamento_numero']); ?></td>
                            <td><?php echo htmlspecialchars($hospede['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($hospede['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($hospede['created_at'] ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($apartamentos)): ?>
    <h4>Suítes / Apartamentos</h4>
    <div class="card p-3 mb-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Bloco/Andar</th>
                        <th>Categoria</th>
                        <th>Limite</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($apartamentos as $apt): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($apt['numero']); ?></td>
                            <td><?php echo htmlspecialchars($apt['bloco_andar']); ?></td>
                            <td><?php echo htmlspecialchars($apt['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($apt['limite_hospedes']); ?></td>
                            <td><?php echo htmlspecialchars($apt['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if (empty($ocorrencias) && empty($hospedes) && empty($apartamentos)): ?>
    <div class="alert alert-warning">Nenhum resultado encontrado para <strong><?php echo htmlspecialchars($termo); ?></strong>.</div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
