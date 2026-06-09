<?php
class ProductGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->conn->query($sql);
        // var_dump($stmt);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
