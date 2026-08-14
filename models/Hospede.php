<?php

require_once __DIR__ . '/BaseModel.php';

class Hospede extends BaseModel
{
    public function all(): array
    {
        // Usar LEFT JOIN para incluir hóspedes sem apartamento vinculado
        $stmt = $this->db->query('SELECT m.*, a.numero AS apartamento_numero FROM moradores m LEFT JOIN apartamentos a ON m.apartamento_id = a.id ORDER BY a.numero, m.id');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM moradores WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data, int $limite): bool
    {
        if ($this->countByApartamento($data['apartamento_id']) >= $limite) {
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO moradores (apartamento_id, cpf, telefone) VALUES (:apartamento_id, :cpf, :telefone)');
        return $stmt->execute([
            'apartamento_id' => $data['apartamento_id'],
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
        ]);
    }

    public function update(int $id, array $data, int $limite): bool
    {
        $current = $this->find($id);
        if (!$current) {
            return false;
        }

        if ($current['apartamento_id'] !== $data['apartamento_id']) {
            $count = $this->countByApartamento($data['apartamento_id']);
            if ($count >= $limite) {
                return false;
            }
        }

        $stmt = $this->db->prepare('UPDATE moradores SET apartamento_id = :apartamento_id, cpf = :cpf, telefone = :telefone WHERE id = :id');
        return $stmt->execute([
            'apartamento_id' => $data['apartamento_id'],
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM moradores WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countByApartamento(int $apartamentoId): int
    {
        // Se o id for inválido (0 ou negativo), não há hóspedes
        if ($apartamentoId <= 0) {
            return 0;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM moradores WHERE apartamento_id = :apartamento_id');
        $stmt->execute(['apartamento_id' => $apartamentoId]);
        return (int)$stmt->fetchColumn();
    }

    public function search(string $term): array
    {
        $searchTerm = "%{$term}%";
        // LEFT JOIN para não excluir hóspedes sem apartamento
        $sql = 'SELECT m.*, a.numero AS apartamento_numero FROM moradores m LEFT JOIN apartamentos a ON m.apartamento_id = a.id WHERE m.cpf LIKE ? OR m.telefone LIKE ? OR a.numero LIKE ? ORDER BY a.numero, m.id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
