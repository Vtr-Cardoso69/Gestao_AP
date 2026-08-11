<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="mb-4">
    <h2><?php echo isset($hospede) ? 'Editar hóspede' : 'Novo hóspede'; ?></h2>
    <p class="text-muted">Cada suíte pode ter até o limite definido no cadastro.</p>
</div>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="card p-4">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Suíte</label>
            <select name="apartamento_id" class="form-select" required>
                <option value="">Selecione uma suíte</option>
                <?php foreach ($suites as $suite): ?>
                    <option value="<?php echo $suite['id']; ?>" <?php echo (isset($hospede['apartamento_id']) ? $hospede['apartamento_id'] : '') == $suite['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($suite['numero'] . ' - ' . $suite['categoria']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">CPF</label>
            <input maxlength="14" type="text" name="cpf" class="form-control" required value="<?php echo htmlspecialchars($hospede['cpf'] ?? '') ; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input maxlength="15" type="text" name="telefone" class="form-control" required value="<?php echo htmlspecialchars($hospede['telefone'] ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?php echo isset($hospede) ? 'Salvar alterações' : 'Cadastrar hóspede'; ?></button>
        <a href="index.php?page=hospedes" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
