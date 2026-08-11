<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="mb-4">
    <h2><?php echo isset($suite) ? 'Editar suíte' : 'Nova suíte'; ?></h2>
    <p class="text-muted">Preencha os dados para registrar ou atualizar a suíte.</p>
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
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Número da suíte</label>
            <input type="text" name="numero" class="form-control" required value="<?php echo htmlspecialchars($suite['numero'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Bloco / Andar</label>
            <select name="bloco_andar" class="form-select" required>
                <?php $selectedBloco = $suite['bloco_andar'] ?? '';?>
                <option value="" <?php echo $selectedBloco === '' ? 'selected' : ''; ?>>Selecione Bloco</option>
                <option value="A" <?php echo $selectedBloco === 'A' ? 'selected' : ''; ?>>A</option>
                <option value="B" <?php echo $selectedBloco === 'B' ? 'selected' : ''; ?>>B</option>
                <option value="AA" <?php echo $selectedBloco === 'AA' ? 'selected' : ''; ?>>AA</option>
                <option value="AB" <?php echo $selectedBloco === 'AB' ? 'selected' : ''; ?>>AB</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria / Tema</label>
            <input type="text" name="categoria" class="form-control" value="<?php echo htmlspecialchars($suite['categoria'] ?? 'Suíte Romântica'); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Limite de hóspedes</label>
            <input type="number" name="limite_hospedes" class="form-control" min="1" max="6" value="<?php echo htmlspecialchars($suite['limite_hospedes'] ?? 2); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <?php $selectedStatus = $suite['status'] ?? 'Disponivel'; ?>
                <option value="Disponivel" <?php echo $selectedStatus === 'Disponivel' ? 'selected' : ''; ?>>Disponível</option>
                <option value="Ocupado" <?php echo $selectedStatus === 'Ocupado' ? 'selected' : ''; ?>>Ocupado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo isset($suite) ? 'Salvar alterações' : 'Cadastrar suíte'; ?></button>
        <a href="index.php?page=suites" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
