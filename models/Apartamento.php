<?php

require_once __DIR__ . '/BaseModel.php';

class Apartamento extends BaseModel
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM apartamentos ORDER BY numero ASC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM apartamentos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO apartamentos (numero, bloco_andar, categoria, limite_hospedes, status, auto_status) VALUES (:numero, :bloco_andar, :categoria, :limite_hospedes, :status, :auto_status)');
        return $stmt->execute([
            'numero' => $data['numero'],
            'bloco_andar' => $data['bloco_andar'],
            'categoria' => $data['categoria'],
            'limite_hospedes' => $data['limite_hospedes'],
            'status' => $data['status'],
            'auto_status' => $data['auto_status'] ?? 1,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE apartamentos SET numero = :numero, bloco_andar = :bloco_andar, categoria = :categoria, limite_hospedes = :limite_hospedes, status = :status, auto_status = :auto_status WHERE id = :id');
        return $stmt->execute([
            'numero' => $data['numero'],
            'bloco_andar' => $data['bloco_andar'],
            'categoria' => $data['categoria'],
            'limite_hospedes' => $data['limite_hospedes'],
            'status' => $data['status'],
            'auto_status' => $data['auto_status'] ?? 1,
            'id' => $id,
        ]);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE apartamentos SET status = :status WHERE id = :id AND auto_status = 1');
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function getLimiteHospedes(int $id): int
    {
        $stmt = $this->db->prepare('SELECT limite_hospedes FROM apartamentos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return (int)$stmt->fetchColumn();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM apartamentos WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countOccupied(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM apartamentos WHERE status = 'Ocupado'");
        return (int)$stmt->fetchColumn();
    }

    public function countAvailable(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM apartamentos WHERE status = 'Disponivel'");
        return (int)$stmt->fetchColumn();
    }

    public function search(string $term): array
    {
        $searchTerm = "%{$term}%";
        $sql = 'SELECT * FROM apartamentos WHERE numero LIKE ? OR bloco_andar LIKE ? OR categoria LIKE ? ORDER BY numero ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
