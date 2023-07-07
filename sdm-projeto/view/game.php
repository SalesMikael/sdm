<?php
class Question {
  private $id;
  private $statement;
  private $alternatives;
  private $correctAnswer;

  public function __construct($id, $statement, $alternatives, $correctAnswer) {
    $this->id = $id;
    $this->statement = $statement;
    $this->alternatives = $alternatives;
    $this->correctAnswer = $correctAnswer;
  }

  public function getId() {
    return $this->id;
  }

  public function getStatement() {
    return $this->statement;
  }

  public function getAlternatives() {
    return $this->alternatives;
  }

  public function getCorrectAnswer() {
    return $this->correctAnswer;
  }
}

class Game {
  private $connection;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function getRandomQuestion() {
    $query = "SELECT idPerguntas, enunciado, alternativa1, alternativa2, alternativa3, alternativa4, resposta FROM perguntas WHERE revisao = 1 ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($this->connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      $id = $row['idPerguntas'];
      $statement = $row['enunciado'];
      $alternatives = array(
        $row['alternativa1'],
        $row['alternativa2'],
        $row['alternativa3'],
        $row['alternativa4']
      );
      $correctAnswer = $row['resposta'];

      return new Question($id, $statement, $alternatives, $correctAnswer);
    }

    return null;
  }

  public function closeConnection() {
    mysqli_close($this->connection);
  }
}
?>
