<?php
require_once __DIR__ . '/../models/Student.php';

class StudentController {
    private $student;

    public function __construct() {
        $this->student = new Student();
    }

    public function handleRequest($method, $data) {
        switch ($method) {
            case 'POST':
                echo json_encode(["success" => $this->student->addStudent($data['lastName'], $data['firstName'], $data['midtermScore'], $data['finalScore'])]);
                break;
            case 'GET':
                if (isset($data['id'])) {
                    echo json_encode($this->student->getStudent($data['id']));
                } elseif (isset($data['finalGrades'])) {
                    echo json_encode($this->student->getAllFinalGrades());
                } else {
                    echo json_encode($this->student->getAllStudents());
                }
                break;
            case 'PUT':
                echo json_encode(["success" => $this->student->updateStudent($data['id'], $data['midtermScore'], $data['finalScore'])]);
                break;
            case 'DELETE':
                echo json_encode(["success" => $this->student->deleteStudent($data['id'])]);
                break;
            default:
                echo json_encode(["error" => "Invalid request method"]);
        }
    }
}
?>
