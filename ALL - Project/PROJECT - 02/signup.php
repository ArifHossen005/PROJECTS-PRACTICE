<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
          header("Location: dashboard.php");
          exit();
}

require_once 'config/database.php';
require_once 'models/User.php';
require_once 'controllers/AuthController.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$auth = new AuthController($db, $user);

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $name = $_POST['name'] ?? '';
          $email = $_POST['email'] ?? '';
          $password = $_POST['password'] ?? '';
          $confirm_password = $_POST['confirm_password'] ?? '';

          $result = $auth->register($name, $email, $password, $confirm_password);

          if ($result['success']) {
                    $success = $result['message'];
                    header("refresh:2;url=login.php");
          } else {
                    $errors = $result['errors'];
          }
}
?>
<!doctype html>
<html lang="en">

<head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>Sign Up | Interactive Cares</title>
          <script src="https://cdn.tailwindcss.com"></script>
          <script>
                    tailwind.config = {
                              theme: {
                                        extend: {
                                                  animation: {
                                                            float: "float 3s ease-in-out infinite",
                                                            fadeIn: "fadeIn 0.5s ease-in forwards",
                                                  },
                                                  keyframes: {
                                                            float: {
                                                                      "0%, 100%": {
                                                                                transform: "translateY(0px)"
                                                                      },
                                                                      "50%": {
                                                                                transform: "translateY(-10px)"
                                                                      },
                                                            },
                                                            fadeIn: {
                                                                      from: {
                                                                                opacity: 0,
                                                                                transform: "translateY(10px)"
                                                                      },
                                                                      to: {
                                                                                opacity: 1,
                                                                                transform: "translateY(0)"
                                                                      },
                                                            },
                                                  },
                                        },
                              },
                    };
          </script>
          <style>
                    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

                    body {
                              font-family: "Inter", sans-serif;
                              overflow-x: hidden;
                    }

                    .glass {
                              backdrop-filter: blur(10px);
                              -webkit-backdrop-filter: blur(10px);
                    }

                    .input-focus:focus {
                              box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                    }
          </style>
</head>

<body
          class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen flex items-center justify-center p-4">
          <div class="max-w-md w-full space-y-8">
                    <div class="text-center animate-float">
                              <div
                                        class="mx-auto bg-gradient-to-r from-indigo-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg mb-4">
                                        <svg
                                                  xmlns="http://www.w3.org/2000/svg"
                                                  viewBox="0 0 24 24"
                                                  fill="currentColor"
                                                  class="w-6 h-6 text-white">
                                                  <path
                                                            fill-rule="evenodd"
                                                            d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                                            clip-rule="evenodd" />
                                        </svg>
                              </div>
                              <h1
                                        class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Create Account
                              </h1>
                              <p class="mt-2 text-gray-600">Join us today to get started</p>
                    </div>

                    <div
                              class="bg-white glass rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
                              <?php if (!empty($errors)): ?>
                                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                                  <ul class="list-disc list-inside">
                                                            <?php foreach ($errors as $error): ?>
                                                                      <li><?php echo htmlspecialchars($error); ?></li>
                                                            <?php endforeach; ?>
                                                  </ul>
                                        </div>
                              <?php endif; ?>

                              <?php if (!empty($success)): ?>
                                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                                  <?php echo htmlspecialchars($success); ?> Redirecting to login...
                                        </div>
                              <?php endif; ?>

                              <form method="POST" action="signup.php" class="space-y-6 animate-fadeIn">
                                        <div class="grid grid-cols-1 gap-4">
                                                  <div>
                                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                                            <div class="relative">
                                                                      <div
                                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                                <svg
                                                                                          xmlns="http://www.w3.org/2000/svg"
                                                                                          fill="none"
                                                                                          viewBox="0 0 24 24"
                                                                                          stroke-width="1.5"
                                                                                          stroke="currentColor"
                                                                                          class="w-5 h-5 text-gray-400">
                                                                                          <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                                                </svg>
                                                                      </div>
                                                                      <input
                                                                                type="text"
                                                                                name="name"
                                                                                value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                                                                class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-focus transition-all duration-300"
                                                                                placeholder="John doe"
                                                                                required />
                                                            </div>
                                                  </div>
                                        </div>

                                        <div>
                                                  <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                                  <div class="relative">
                                                            <div
                                                                      class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                      <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                class="w-5 h-5 text-gray-400">
                                                                                <path
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                                      </svg>
                                                            </div>
                                                            <input
                                                                      type="email"
                                                                      name="email"
                                                                      value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                                                      class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-focus transition-all duration-300"
                                                                      placeholder="you@example.com"
                                                                      required />
                                                  </div>
                                        </div>

                                        <div>
                                                  <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                                  <div class="relative">
                                                            <div
                                                                      class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                      <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                class="w-5 h-5 text-gray-400">
                                                                                <path
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                                      </svg>
                                                            </div>
                                                            <input
                                                                      type="password"
                                                                      name="password"
                                                                      class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-focus transition-all duration-300"
                                                                      placeholder="••••••••"
                                                                      required
                                                                      minlength="8" />
                                                  </div>
                                        </div>

                                        <div>
                                                  <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                                  <div class="relative">
                                                            <div
                                                                      class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                      <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor"
                                                                                class="w-5 h-5 text-gray-400">
                                                                                <path
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                                      </svg>
                                                            </div>
                                                            <input
                                                                      type="password"
                                                                      name="confirm_password"
                                                                      class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-focus transition-all duration-300"
                                                                      placeholder="••••••••"
                                                                      required
                                                                      minlength="8" />
                                                  </div>
                                        </div>

                                        <div class="flex items-start">
                                                  <div class="flex items-center h-5">
                                                            <input
                                                                      id="terms"
                                                                      name="terms"
                                                                      type="checkbox"
                                                                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                                  </div>
                                                  <div class="ml-3 text-sm">
                                                            <label for="terms" class="text-gray-700">I agree to the
                                                                      <a
                                                                                href="#"
                                                                                class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Terms and Conditions</a>
                                                                      and
                                                                      <a
                                                                                href="#"
                                                                                class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Privacy Policy</a></label>
                                                  </div>
                                        </div>

                                        <button
                                                  type="submit"
                                                  class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                                                  <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                                            <svg
                                                                      xmlns="http://www.w3.org/2000/svg"
                                                                      fill="none"
                                                                      viewBox="0 0 24 24"
                                                                      stroke-width="1.5"
                                                                      stroke="currentColor"
                                                                      class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors">
                                                                      <path
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                            </svg>
                                                  </span>
                                                  Create Account
                                        </button>
                              </form>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                              <p>
                                        Already have an account?
                                        <a
                                                  href="login.php"
                                                  class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Sign in</a>
                              </p>
                    </div>
          </div>
</body>

</html>