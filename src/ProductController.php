<?php
class ProductController
{
    public function __construct(private ProductGateway $gateway) {}
    public function processRequest(string $method, ?string $id)
    {
        if ($id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id) {}
    private function processCollectionRequest(string $method)
    {
        switch ($method) {
            case 'GET':
                echo json_encode($this->gateway->getAll(),);
                break;
            case 'POST':
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidaionErrors($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(201);

                echo json_encode([
                    "message" => "Item created",
                    "id" => $id,

                ]);
        }
    }
    private function getValidaionErrors(array $data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors = "name is empty";
        }
        if (array_key_exists("size", $data)) {
            if (filter_var($data['size'], FILTER_VALIDATE_INT === false)) {
                $errors[] = "size must be an integer";
            }
        }
        return $errors;
    }
}
