<?php
class StudentManager {
    private $filePath = 'students.json';

    public function __construct() {
        // Create the JSON file if it doesn't exist
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    /**
     * Returns an array of all student objects
     */
    public function getAllStudents() {
        $jsonData = file_get_contents($this->filePath);
        $students = json_decode($jsonData, true);
        return $students ? $students : [];
    }

    /**
     * Finds and returns a single student by ID
     */
    public function getStudentById($id) {
        $students = $this->getAllStudents();
        foreach ($students as $student) {
            if ($student['id'] == $id) {
                return $student;
            }
        }
        return null;
    }

    /**
     * Appends a new student to the file
     */
    public function create($data) {
        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $students = $this->getAllStudents();

        // Generate unique ID
        $newId = $this->generateUniqueId($students);
        
        // Check for duplicate email
        foreach ($students as $student) {
            if ($student['email'] === $data['email']) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }

        // Create new student object
        $newStudent = [
            'id' => $newId,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => $data['status']
        ];

        // Add to array and save
        $students[] = $newStudent;
        $this->saveToFile($students);

        return ['success' => true, 'message' => 'Student created successfully'];
    }

    /**
     * Finds the student by ID and updates their details
     */
    public function update($id, $data) {
        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $students = $this->getAllStudents();
        $updated = false;

        // Check for duplicate email (excluding current student)
        foreach ($students as $student) {
            if ($student['email'] === $data['email'] && $student['id'] != $id) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }

        foreach ($students as $key => $student) {
            if ($student['id'] == $id) {
                $students[$key] = [
                    'id' => $id,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'status' => $data['status']
                ];
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveToFile($students);
            return ['success' => true, 'message' => 'Student updated successfully'];
        }

        return ['success' => false, 'message' => 'Student not found'];
    }

    /**
     * Removes the student from the array and saves the file
     */
    public function delete($id) {
        $students = $this->getAllStudents();
        $initialCount = count($students);

        $students = array_filter($students, function($student) use ($id) {
            return $student['id'] != $id;
        });

        // Re-index array
        $students = array_values($students);

        if (count($students) < $initialCount) {
            $this->saveToFile($students);
            return ['success' => true, 'message' => 'Student deleted successfully'];
        }

        return ['success' => false, 'message' => 'Student not found'];
    }

    /**
     * Save students array to JSON file
     */
    private function saveToFile($students) {
        file_put_contents($this->filePath, json_encode($students, JSON_PRETTY_PRINT));
    }

    /**
     * Generate unique ID for new student
     */
    private function generateUniqueId($students) {
        if (empty($students)) {
            return 1;
        }

        $maxId = 0;
        foreach ($students as $student) {
            if ($student['id'] > $maxId) {
                $maxId = $student['id'];
            }
        }

        return $maxId + 1;
    }
}
?>