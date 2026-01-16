<?php
require_once 'StudentManager.php';

$studentManager = new StudentManager();
$error = '';
$success = '';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$studentId = $_GET['id'];
$student = $studentManager->getStudentById($studentId);

// If student not found, redirect
if (!$student) {
    header('Location: index.php?message=' . urlencode('Student not found'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'phone' => trim($_POST['phone']),
        'status' => $_POST['status']
    ];

    // Validate required fields
    if (empty($data['name']) || empty($data['email']) || empty($data['phone'])) {
        $error = 'All fields are required';
    } else {
        $result = $studentManager->update($studentId, $data);
        if ($result['success']) {
            header('Location: index.php?message=' . urlencode($result['message']));
            exit;
        } else {
            $error = $result['message'];
        }
    }
} else {
    // Pre-populate form with existing data
    $_POST = $student;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Student | Student.io</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
      }
    </style>
  </head>
  <body class="h-full">
    <div class="min-h-full flex flex-col">
      <nav class="bg-indigo-600 pb-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <span class="text-white font-bold text-xl tracking-tight"
                  >STUDENT.IO</span
                >
              </div>
            </div>
            <div class="hidden md:block">
              <div class="ml-4 flex items-center md:ml-6">
                <button
                  class="rounded-full bg-indigo-700 p-1 text-indigo-200 hover:text-white focus:outline-none"
                >
                  <span class="sr-only">View notifications</span>
                  <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Edit Student
            </h1>
          </div>
        </header>
      </nav>

      <main class="-mt-32">
        <div class="mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
          <?php if ($error): ?>
          <div class="rounded-md bg-red-50 p-4 mb-6">
            <div class="flex">
              <div class="ml-3">
                <p class="text-sm font-medium text-red-800">
                  <?php echo htmlspecialchars($error); ?>
                </p>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <form
            method="POST"
            action="edit.php?id=<?php echo $studentId; ?>"
            class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
          >
            <div class="px-4 py-6 sm:p-8">
              <div class="mb-8">
                <h2 class="text-base font-semibold leading-7 text-gray-900">
                  Student Information
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                  Update the student's personal details and enrollment status.
                </p>
              </div>

              <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                  <label
                    for="name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Name</label
                  >
                  <div class="mt-2">
                    <input
                      type="text"
                      name="name"
                      id="name"
                      required
                      autocomplete="name"
                      placeholder="John Doe"
                      value="<?php echo htmlspecialchars($_POST['name']); ?>"
                      class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6 outline-none focus:ring-1 focus:ring-indigo-600"
                    />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="email"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Email address</label
                  >
                  <div class="mt-2">
                    <input
                      id="email"
                      name="email"
                      type="email"
                      required
                      autocomplete="email"
                      placeholder="john@example.com"
                      value="<?php echo htmlspecialchars($_POST['email']); ?>"
                      class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6 outline-none focus:ring-1 focus:ring-indigo-600"
                    />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="phone"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Phone Number</label
                  >
                  <div class="mt-2">
                    <input
                      type="tel"
                      name="phone"
                      id="phone"
                      required
                      autocomplete="tel"
                      placeholder="+880 1712-123456"
                      value="<?php echo htmlspecialchars($_POST['phone']); ?>"
                      class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6 outline-none focus:ring-1 focus:ring-indigo-600"
                    />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="status"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Enrollment Status</label
                  >
                  <div class="mt-2">
                    <select
                      id="status"
                      name="status"
                      required
                      class="block w-full rounded-md border-0 p-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:max-w-xs sm:text-sm sm:leading-6 outline-none focus:ring-1 focus:ring-indigo-600"
                    >
                      <option value="Active" <?php echo ($_POST['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                      <option value="On Leave" <?php echo ($_POST['status'] === 'On Leave') ? 'selected' : ''; ?>>On Leave</option>
                      <option value="Graduated" <?php echo ($_POST['status'] === 'Graduated') ? 'selected' : ''; ?>>Graduated</option>
                      <option value="Inactive" <?php echo ($_POST['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8 bg-gray-50 rounded-b-xl"
            >
              <a
                href="index.php"
                class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700"
                >Cancel</a
              >
              <button
                type="submit"
                class="rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              >
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </main>
      <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <p class="text-center text-sm text-gray-500">
            &copy; 2025 Student Management System.
          </p>
        </div>
      </footer>
    </div>
  </body>
</html>