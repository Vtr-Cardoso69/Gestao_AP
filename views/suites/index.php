<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Suítes</h2>
        <p class="text-muted">Gestão de suítes e temas românticos.</p>
    </div>
    <a href="index.php?page=suites&action=create" class="btn btn-primary">Nova suíte</a>
</div>
<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Bloco / Andar</th>
                    <th>Categoria</th>
                    <th>Limite</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suites as $suite): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($suite['numero']); ?></td>
                        <td><?php echo htmlspecialchars($suite['bloco_andar']); ?></td>
                        <td><?php echo htmlspecialchars($suite['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($suite['limite_hospedes']); ?></td>
                        <td><?php echo htmlspecialchars($suite['status']); ?></td>
                        <td>
                            <a href="index.php?page=suites&action=edit&id=<?php echo $suite['id']; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="index.php?page=suites&action=delete&id=<?php echo $suite['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja excluir esta suíte?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
