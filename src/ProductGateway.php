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
}
