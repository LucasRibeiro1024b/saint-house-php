<?php
header("Content-Type: application/json; charset=UTF-8");

class api {
  private $conn = null;
  private $method = null;
  private $obj = null;

  public function __construct() {    
    $servername = "localhost";
    $username = "root";
    $password = "root";

    try {
      $connection = new PDO("mysql:host=$servername;dbname=santacasa", $username, $password);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn = $connection;
    } catch(PDOException $e) {
      $e->getMessage();
    }

    $this->obj = json_decode(file_get_contents('php://input'), true);
  }

  public function handleRequest() {
    $url = $_SERVER["REQUEST_URI"];
    $url = explode("/", $url);
    $this->method = $_SERVER['REQUEST_METHOD'];

    if (!array_key_exists(4, $url)) {
      header("Status: 404 Not Found");
      return;
    }

    header("Status: 200");

    switch ($url[4]) {
      case 'paciente':
        if (!$this->handlePaciente()) {
          header("Status: 404");
        };
        break;
      
      case "ptendtime":
        if (!$this->handlePtendtime()) {
          header("Status: 404");
        };
        break;

      default:
        header("Status: 404 Not Found");
        return;
    }

    return;
  }

  public function handlePaciente() {
    switch ($this->method) {
      case 'POST':
      case 'PUT':
        if ($this->method == "POST") {
          try {
            $sql = "INSERT INTO paciente (nome, sexo, dt_nascimento)
            VALUES (:nome, :sexo, :dt_nascimento)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nome', $this->obj["nome"]);
            $stmt->bindParam(':sexo', $this->obj["sexo"]);
            $stmt->bindParam(':dt_nascimento', $this->obj["dt_nascimento"]);
            $stmt->execute();

            echo json_encode(["message" => "New record created successfully"]);
            return true;
          } catch(PDOException $e) {
            echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
            return false;
          }
        }

        try {
          $sql = "UPDATE paciente SET nome = :nome, sexo = :sexo, dt_nascimento = :dt_nascimento WHERE id = :id";

          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':id', $this->obj["id"]);
          $stmt->bindParam(':nome', $this->obj["nome"]);
          $stmt->bindParam(':sexo', $this->obj["sexo"]);
          $stmt->bindParam(':dt_nascimento', $this->obj["dt_nascimento"]);
          $stmt->execute();

          echo json_encode(["message" => "Record updated successfully"]);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      case 'GET':
        try {
          $sql = "SELECT * FROM paciente";
          $stmt = $this->conn->prepare($sql);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $stmt->execute();

          $rows = [];
          foreach($stmt->fetchAll() as $k) {
            $rows[] = [
              "id" => $k["id"],
              "nome" => $k["nome"],
              "sexo" => $k["sexo"],
              "dt_nascimento" => $k["dt_nascimento"],
            ];
          }

          echo json_encode($rows);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      case 'DELETE':
        try {
          $sql = "DELETE FROM paciente WHERE id = :id";
          $stmt = $this->conn->prepare($sql);

          $stmt->bindParam(':id', $this->obj["id"]);
          $stmt->execute();

          echo json_encode(["message" => "Record deleted successfully"]);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      default:
        return false;
    }
  }

  public function handlePtendtime() {
    switch ($this->method) {
      case 'POST':
      case 'PUT':
        if ($this->method == "POST") {
          try {
            $sql = "INSERT INTO ptendtime (id_paciente, tipo_at, dt_atendimento)
            VALUES (:id_paciente, :tipo_at, :dt_atendimento)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_paciente', $this->obj["id_paciente"]);
            $stmt->bindParam(':tipo_at', $this->obj["tipo_at"]);
            $stmt->bindParam(':dt_atendimento', $this->obj["dt_atendimento"]);
            $stmt->execute();

            echo json_encode(["message" => "New record created successfully"]);
            return true;
          } catch(PDOException $e) {
            echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
            return false;
          }
        }

        try {
          $sql = "UPDATE ptendtime SET id_paciente = :id_paciente, tipo_at = :tipo_at, dt_atendimento = :dt_atendimento WHERE id = :id";

          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':id', $this->obj["id"]);
          $stmt->bindParam(':id_paciente', $this->obj["id_paciente"]);
          $stmt->bindParam(':tipo_at', $this->obj["tipo_at"]);
          $stmt->bindParam(':dt_atendimento', $this->obj["dt_atendimento"]);
          $stmt->execute();

          echo json_encode(["message" => "Record updated successfully"]);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      case 'GET':
        try {
          $sql = "SELECT * FROM ptendtime";
          $stmt = $this->conn->prepare($sql);
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          $stmt->execute();

          $rows = [];
          foreach($stmt->fetchAll() as $k) {
            $rows[] = [
              "id" => $k["id"],
              "id_paciente" => $k["id_paciente"],
              "tipo_at" => $k["tipo_at"],
              "dt_atendimento" => $k["dt_atendimento"],
            ];
          }

          echo json_encode($rows);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      case 'DELETE':
        try {
          $sql = "DELETE FROM ptendtime WHERE id = :id";
          $stmt = $this->conn->prepare($sql);

          $stmt->bindParam(':id', $this->obj["id"]);
          $stmt->execute();

          echo json_encode(["message" => "Record deleted successfully"]);
        } catch(PDOException $e) {
          echo json_encode(["message" => $sql . "<br>" . $e->getMessage()]);
          return false;
        }

        return true;

      default:
        return false;
    }
  }
}

$api = new api();
$api->handleRequest();