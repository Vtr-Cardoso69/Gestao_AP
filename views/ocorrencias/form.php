<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="mb-4">
    <h2><?php echo isset($ocorrencia) ? 'Editar ocorrência' : 'Nova ocorrência'; ?></h2>
    <p class="text-muted">Vincule a ocorrência à suíte ou a um hóspede específico.</p>
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
                    <option value="<?php echo $suite['id']; ?>" <?php echo (isset($ocorrencia['apartamento_id']) ? $ocorrencia['apartamento_id'] : '') == $suite['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($suite['numero'] . ' - ' . $suite['categoria']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hóspede (opcional)</label>
            <select name="morador_id" class="form-select">
                <option value="">Sem vínculo direto</option>
                <?php foreach ($hospedes as $hospede): ?>
                    <option value="<?php echo $hospede['id']; ?>" <?php echo (isset($ocorrencia['morador_id']) ? $ocorrencia['morador_id'] : '') == $hospede['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($hospede['cpf'] . ' (Suíte ' . $hospede['apartamento_numero'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?php echo htmlspecialchars($ocorrencia['titulo'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4" required><?php echo htmlspecialchars($ocorrencia['descricao'] ?? ''); ?></textarea>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tipo de ocorrência</label>
                <select name="tipo_ocorrencia" class="form-select">
                    <?php $tipo = $ocorrencia['tipo_ocorrencia'] ?? 'Quarto'; ?>
                    <option value="Quarto" <?php echo $tipo === 'Quarto' ? 'selected' : ''; ?>>Quarto</option>
                    <option value="Pertence Esquecido" <?php echo $tipo === 'Pertence Esquecido' ? 'selected' : ''; ?>>Pertence Esquecido</option>
                    <option value="Atendimento" <?php echo $tipo === 'Atendimento' ? 'selected' : ''; ?>>Atendimento</option>
                    <option value="Outros" <?php echo $tipo === 'Outros' ? 'selected' : ''; ?>>Outros</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php $status = $ocorrencia['status'] ?? 'Pendente'; ?>
                    <option value="Pendente" <?php echo $status === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Em Andamento" <?php echo $status === 'Em Andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="Resolvido" <?php echo $status === 'Resolvido' ? 'selected' : ''; ?>>Resolvido</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary"><?php echo isset($ocorrencia) ? 'Salvar alterações' : 'Registrar ocorrência'; ?></button>
            <a href="index.php?page=ocorrencias" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
