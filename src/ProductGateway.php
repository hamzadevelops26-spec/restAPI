<?php
class ProductGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    private function castTypes(array $row): array
    {
        $row['is_available'] = (bool) $row['is_available'];
        return $row;
    }


    public function getAll()
    {
        $sql = "SELECT * FROM product";

        $stmt = $this->conn->query($sql);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'castTypes'], $rows);
    }
    public function create(array $data): string
    {
        $sql  = "INSERT INTO product (name , size , is_available)

         VALUES (:name , :size , :is_available) ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data['name'], pdo::PARAM_STR);

        $stmt->bindValue(":size", $data['size'] ?? 0, pdo::PARAM_STR);

        $stmt->bindValue(":is_available", (bool) $data['is_available'], pdo::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, pdo::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(pdo::FETCH_ASSOC);

        if (! $data == false) {
            $data['is_available'] = (bool) $data['is_available'];
        }

        return $data;
    }

    public function update(array $current, array $new)
    {
        $sql = "UPDATE product SET name = :name , size = :size , is_available = :is_available WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], pdo::PARAM_STR);

        $stmt->bindValue(":size", $new["size"] ?? $current["size"], pdo::PARAM_INT);

        $stmt->bindValue(":is_available", $new["is_available"] ?? $current["is_available"], pdo::PARAM_BOOL);

        $stmt->bindValue(":id", $current['id'], pdo::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM product WHERE id = :id ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, pdo::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
