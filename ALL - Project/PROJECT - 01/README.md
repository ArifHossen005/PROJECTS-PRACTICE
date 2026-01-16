# Assignment: 01

### Name: MD ARIF HOSSEN

### Email: arifsohag2500@gmail.com

---

## Student Management System

A complete PHP-based student management system with CRUD operations (Create, Read, Update, Delete) using JSON file storage.

### Features

* ✅ View all students in a clean table interface
* ✅ Add new students with validation
* ✅ Edit existing student information
* ✅ Delete students with confirmation
* ✅ Email validation
* ✅ Duplicate email prevention
* ✅ Unique ID generation
* ✅ Status badges (Active, On Leave, Graduated, Inactive)
* ✅ Responsive design with Tailwind CSS

### File Structure

```
project-root/
│
├── StudentManager.php    # Class containing all CRUD logic
├── index.php             # Main page - Student list view
├── create.php            # Add new student form
├── edit.php              # Edit student form
├── students.json         # JSON file for data storage (auto-created)
└── README.md             # Project documentation
```


### Usage

#### View Students

* Navigate to `index.php` to see all students
* Empty state message shown when no students exist

#### Add Student

1. Click "Add Student" button
2. Fill in all required fields:
   * Name
   * Email (validated format)
   * Phone
   * Enrollment Status
3. Click "Create Student"

#### Edit Student

1. Click "Edit" link next to any student
2. Modify the information
3. Click "Save Changes"

#### Delete Student

1. Click "Delete" link next to any student
2. Confirm deletion in popup
3. Student is removed from the system

### Data Structure

Each student in `students.json` has the following structure:

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "+880 1712-123456",
  "status": "Active"
}
```

### StudentManager Class Methods

* `getAllStudents()` - Returns array of all students
* `getStudentById($id)` - Returns single student by ID
* `create($data)` - Creates new student with validation
* `update($id, $data)` - Updates existing student
* `delete($id)` - Removes student from system

### Validation Rules

* All fields are required
* Email must be in valid format
* Duplicate emails are not allowed
* Unique IDs are auto-generated
* Data is sanitized to prevent XSS

### Technologies Used

* **Backend** : PHP 7.4+
* **Frontend** : HTML5, Tailwind CSS
* **Data Storage** : JSON file
* **Font** : Google Fonts (Inter)
