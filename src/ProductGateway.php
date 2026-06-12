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
}
