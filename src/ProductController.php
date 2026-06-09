<?php
class ProductController
{
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
                echo json_encode(["id" => 123]);
                break;
        }
    }
}
