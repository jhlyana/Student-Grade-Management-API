<?php
require_once __DIR__ . '/../config/Database.php';

class Student {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function addStudent($lastName, $firstName, $midtermScore, $finalScore) {
        $query = "INSERT INTO students (lastName, firstName, midtermScore, finalScore) VALUES (:lastName, :firstName, :midtermScore, :finalScore)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':midtermScore', $midtermScore);
        $stmt->bindParam(':finalScore', $finalScore);
        return $stmt->execute();
    }

    public function getAllStudents() {
        $query = "SELECT *, (0.4 * midtermScore + 0.6 * finalScore) AS finalGrade FROM students";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudent($id) {
        $query = "SELECT *, (0.4 * midtermScore + 0.6 * finalScore) AS finalGrade FROM students WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllFinalGrades() {
        $query = "SELECT id, lastName, firstName, (0.4 * midtermScore + 0.6 * finalScore) AS finalGrade, 
                  CASE WHEN (0.4 * midtermScore + 0.6 * finalScore) >= 75 THEN 'Pass' ELSE 'Fail' END AS status 
                  FROM students";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, $midtermScore, $finalScore) {
        $query = "UPDATE students SET midtermScore = :midtermScore, finalScore = :finalScore WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':midtermScore', $midtermScore);
        $stmt->bindParam(':finalScore', $finalScore);
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $query = "DELETE FROM students WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
