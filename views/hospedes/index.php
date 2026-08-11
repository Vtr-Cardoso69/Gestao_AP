<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Hóspedes</h2>
        <p class="text-muted">Cadastro anônimo com CPF e telefone para contato emergencial.</p>
    </div>
    <a href="index.php?page=hospedes&action=create" class="btn btn-primary">Novo hóspede</a>
</div>
<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Suíte</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Cadastrado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hospedes as $hospede): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hospede['apartamento_numero']); ?></td>
                        <td><?php echo htmlspecialchars($hospede['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($hospede['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($hospede['created_at']); ?></td>
                        <td>
                            <a href="index.php?page=hospedes&action=edit&id=<?php echo $hospede['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="index.php?page=hospedes&action=delete&id=<?php echo $hospede['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja excluir este hóspede?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
