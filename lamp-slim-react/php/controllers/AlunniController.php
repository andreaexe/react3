<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    sleep(2);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function delete(Request $request, Response $response, $args){
    sleep(2);

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $mysqli_connection->query("DELETE FROM alunni WHERE id = ". $args["id"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(201);
  }

  public function insert(Request $request, Response $response, $args) {
    $conn = new mysqli("my_mariadb", "root", "ciccio", "scuola");
    $body = json_decode($request->getBody()->getContents(), true);    
    $nome = $body["nome"];
    $cognome = $body["cognome"];
    $raw_query = "INSERT INTO alunni(nome, cognome) VALUES('$nome', '$cognome')";
    $result = $conn->query($raw_query);
    if ($result && $conn->affected_rows > 0) {
      $response->getBody()->write(json_encode(array("message" => "Success")));
    } else {
      $response->getBody()->write(json_encode(array("message" => $conn->error)));
    }
    return $response->withHeader("content-type", "application/json")->withStatus(201);
  }

}
