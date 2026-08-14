<?php

require_once __DIR__ . '/BaseModel.php';

class Ocorrencia extends BaseModel
{
    public function all(): array
    {
        // Usar LEFT JOIN para permitir ocorrências que não estejam vinculadas a uma suíte
        $sql = 'SELECT o.*, a.numero AS apartamento_numero, m.cpf AS morador_cpf FROM ocorrencias o LEFT JOIN apartamentos a ON o.apartamento_id = a.id LEFT JOIN moradores m ON o.morador_id = m.id ORDER BY o.data_registro DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ocorrencias WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO ocorrencias (apartamento_id, morador_id, titulo, descricao, tipo_ocorrencia, status) VALUES (:apartamento_id, :morador_id, :titulo, :descricao, :tipo_ocorrencia, :status)');
        return $stmt->execute([
            // Converter valores vazios/0 para NULL para o banco
            'apartamento_id' => $data['apartamento_id'] ?: null,
            'morador_id' => $data['morador_id'] ?: null,
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'tipo_ocorrencia' => $data['tipo_ocorrencia'],
            'status' => $data['status'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE ocorrencias SET apartamento_id = :apartamento_id, morador_id = :morador_id, titulo = :titulo, descricao = :descricao, tipo_ocorrencia = :tipo_ocorrencia, status = :status WHERE id = :id');
        return $stmt->execute([
            'apartamento_id' => $data['apartamento_id'] ?: null,
            'morador_id' => $data['morador_id'] ?: null,
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'],
            'tipo_ocorrencia' => $data['tipo_ocorrencia'],
            'status' => $data['status'],
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ocorrencias WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function marcarResolvido(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE ocorrencias SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => 'Resolvido', 'id' => $id]);
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM ocorrencias WHERE status = :status');
        $stmt->execute(['status' => $status]);
        return (int)$stmt->fetchColumn();
    }

    public function search(string $term): array
    {
        $searchTerm = "%{$term}%";
        $sql = 'SELECT o.*, a.numero AS apartamento_numero, m.cpf AS morador_cpf FROM ocorrencias o LEFT JOIN apartamentos a ON o.apartamento_id = a.id LEFT JOIN moradores m ON o.morador_id = m.id WHERE o.titulo LIKE ? OR o.descricao LIKE ? OR a.numero LIKE ? OR m.cpf LIKE ? ORDER BY o.data_registro DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
