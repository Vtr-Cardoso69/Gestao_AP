<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Ocorrências</h2>
        
    </div>
    <a href="index.php?page=ocorrencias&action=create" class="btn btn-primary">Nova ocorrência</a>
</div>
<div class="card p-3">
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ocorrencias)): ?>
                    <tr><td colspan="7" class="text-center">Nenhuma ocorrência encontrada.</td></tr>
                <?php endif; ?>
                <?php foreach ($ocorrencias as $ocorrencia): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ocorrencia['apartamento_numero']); ?></td>
                        <td><?php echo htmlspecialchars($ocorrencia['morador_cpf'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($ocorrencia['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($ocorrencia['tipo_ocorrencia']); ?></td>
                        <td><?php echo htmlspecialchars($ocorrencia['status']); ?></td>
                        <td><?php echo htmlspecialchars($ocorrencia['data_registro']); ?></td>
                        <td>
                            <a href="index.php?page=ocorrencias&action=edit&id=<?php echo $ocorrencia['id']; ?>" class="btn btn-sm btn-outline-primary">Informações</a>
                            <?php if ($ocorrencia['status'] !== 'Resolvido'): ?>
                                <a href="index.php?page=ocorrencias&action=resolver&id=<?php echo $ocorrencia['id']; ?>" class="btn btn-sm btn-outline-success">Resolver</a>
                            <?php endif; ?>
                            <a href="index.php?page=ocorrencias&action=delete&id=<?php echo $ocorrencia['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja excluir esta ocorrência?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
