<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiler - Login</title>
    <?php include 'process/db_connection.php'; ?>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="form">
                <?php
                session_start();
                if (isset($_SESSION['error'])) {
                    $errorMessage = $_SESSION['error'];
                    unset($_SESSION['error']);
                } else {
                    $errorMessage = '';
                }
                ?>
                <div class="title">
                    <p>Log Into Profiler</p>
                </div>
                <form method="POST" action="process/login.php" onsubmit="return validateForm()" autocomplete="off">
                    <div class="field">
                        <label for="username">Username:</label>
                        <input id="username" type="text" name="username">
                    </div>
                    <div class="field">
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password">
                        <img id="toggle" src="images/eye_open.png" class="eye-icon">
                    </div>
                    <?php if (!empty($errorMessage)) : ?>
                        <p class="error"><?php echo $errorMessage; ?></p>
                    <?php endif; ?>
                    <div class="field buttons">
                        <div class="home" onClick="form()">Form</div>
                        <button type="submit">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>

        window.onload = function() {
            fetch('process/unset.php').catch(error => alert('Error: ' + error));
            document.getElementById('username').focus();
        };

        var toggle = document.getElementById('toggle');
        toggle.addEventListener('click', function() {
            if (password.type === 'password') {
                password.type = 'text';
                toggle.src = 'images/eye_close.png';
            } else {
                password.type = 'password';
                toggle.src = 'images/eye_open.png';
            }
        });

        function form() {
            window.location.href = 'home.php';
        }

        function validateForm() {
            var username = document.getElementById('username');
            var password = document.getElementById('password');
            if (username.value.trim() === '') {
                username.style.borderBottomWidth = '1px';
                username.style.borderBottomColor = 'red';
            } else {
                username.style.borderBottomWidth = '';
                username.style.borderBottomColor = '';
            }
            if (password.value.trim() === '') {
                password.style.borderBottomWidth = '1px';
                password.style.borderBottomColor = 'red';
            } else {
                password.style.borderBottomWidth = '';
                password.style.borderBottomColor = '';
            }
            if (username.value.trim() === '' || password.value.trim() === '') {
                return false;
            }
            return true;
        }

    </script>
</body>
</html>