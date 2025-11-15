<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiler - Form</title>
    <?php include 'process/db_connection.php'; ?>
    <link rel="stylesheet" href="styles/home.css">
</head>
<body>
    <?php
    session_start();
    $loggedIn = isset($_SESSION['account_name']);
    $show = isset($_SESSION['id']);
    if (isset($_SESSION['error'])) {
        $errorMessage = $_SESSION['error'];
        unset($_SESSION['error']);
    } else {
        $errorMessage = '';
    }
    if (isset($_SESSION['success'])) {
        $successMessage = $_SESSION['success'];
        unset($_SESSION['success']);
    } else {
        $successMessage = '';
    }
    ?>
    <section>
        <div class="header">
            <img src="images/LOGO.png" alt="Logo" class="logo">
            <h2>Profiler Form</h2>
            <div class="icons">
                <?php echo $loggedIn ? '<img src="images/back.png" class="icon" title="Back" onClick="back()">' : 
                '<img src="images/login.png" class="icon" title="Login" onClick="login()">'; ?>
            </div>
        </div>
        <div class="container">
            <div class="form">
                <?php if (!empty($successMessage)) : ?>
                    <p class="success"><?php echo $successMessage; ?></p>
                <?php endif; ?>
                <?php if (!empty($errorMessage)) : ?>
                    <p class="error"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
                <form id="form" method="POST" action="process/add.php" enctype="multipart/form-data" onsubmit="return validateForm(<?php echo $show; ?>)" autocomplete="off">
                    <?php echo ($loggedIn && $show) ? '<div id="edit" class="edit" onClick="editProfile()">EDIT</div>
                            <input type="hidden" name="id" value="' . $_SESSION['id'] . '">' : ''; ?>
                    <h5>PERSONAL DETAILS</h5>
                    <div class="field-group normal">
                        <div class="field">
                            <label class="label" for="firstname">First name</label>
                            <input onkeydown="validateText(event)" id="firstname" type="text" name="firstname" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['firstname'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="middlename">Middle name</label>
                            <input onkeydown="validateText(event)" id="middlename" type="text" name="middlename" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['middlename'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="lastname">Last name</label>
                            <input onkeydown="validateText(event)" id="lastname" type="text" name="lastname" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['lastname'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="student_id">Student ID</label>
                            <input onkeydown="validateNumber(event)" id="student_id" type="text" name="student_id" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['student_id'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="age">Age</label>
                            <input id="age" type="number" name="age" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['age'] . '" disabled' : ''; ?> min="5" max="100" autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="birthdate">Birthdate</label>
                            <input id="birthdate" type="date" name="birthdate" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['birthdate'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="gender">Gender</label>
                            <select id="gender" name="gender" <?php echo ($loggedIn && $show) ? 'disabled' : ''; ?>>
                                <option value="default" disabled <?php echo ($loggedIn && $show) ? '' : 'selected'; ?>>Select your gender</option>
                                <option value="Male" <?php echo ($loggedIn && $show && $_SESSION['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($loggedIn && $show && $_SESSION['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($loggedIn && $show && $_SESSION['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="field">
                            <label class="label" for="phone">Phone</label>
                            <input onkeydown="validateNumber(event)" id="phone" type="tel" name="phone" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['phone'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="email">Email</label>
                            <input id="email" type="email" name="email" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['email'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="address">Address</label>
                            <input id="address" type="text" name="address" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['address'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="citizenship">Citizenship</label>
                            <input onkeydown="validateText(event)" id="citizenship" type="text" name="citizenship" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['citizenship'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                        <div class="field">
                            <label class="label" for="religion">Religion</label>
                            <input onkeydown="validateText(event)" id="religion" type="text" name="religion" <?php echo ($loggedIn && $show) ? 
                                'value="' . $_SESSION['religion'] . '" disabled' : ''; ?> autocomplete="off">
                        </div>
                    </div>
                    <div class="field-group-nest">
                        <div class="nest family">
                            <h5>FAMILY DETAILS</h5>
                            <div class="field-group">
                                <div class="field">
                                    <label class="label" for="guardian">Guardian's name</label>
                                    <input onkeydown="validateText(event)" id="guardian" type="text" name="guardian" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['guardian'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                                <div class="field">
                                    <label class="label" for="father">Father's name</label>
                                    <input onkeydown="validateText(event)" id="father" type="text" name="father" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['father'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                                <div class="field">
                                    <label class="label" for="relation">Relation</label>
                                    <select id="relation" name="relation" <?php echo ($loggedIn && $show) ? 'disabled' : ''; ?>>
                                        <option value="default" disabled <?php echo ($loggedIn && $show) ? '' : 'selected'; ?>>Relationship to guardian</option>
                                        <option value="Father" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Father') ? 'selected' : ''; ?>>Father</option>
                                        <option value="Mother" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Mother') ? 'selected' : ''; ?>>Mother</option>
                                        <option value="Brother" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Brother') ? 'selected' : ''; ?>>Brother</option>
                                        <option value="Sister" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Sister') ? 'selected' : ''; ?>>Sister</option>
                                        <option value="Uncle" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Uncle') ? 'selected' : ''; ?>>Uncle</option>
                                        <option value="Aunt" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Aunt') ? 'selected' : ''; ?>>Aunt</option>
                                        <option value="Grandfather" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Grandfather') ? 'selected' : ''; ?>>Grandfather</option>
                                        <option value="Grandmother" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Grandmother') ? 'selected' : ''; ?>>Grandmother</option>
                                        <option value="Other" <?php echo ($loggedIn && $show && $_SESSION['relation'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label class="label" for="mother">Mother's name</label>
                                    <input onkeydown="validateText(event)" id="mother" type="text" name="mother" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['mother'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                                <div class="field">
                                    <label class="label" for="gphone">Phone</label>
                                    <input onkeydown="validateNumber(event)" id="gphone" type="tel" name="gphone" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['gphone'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="nest">
                            <h5>EMERGERCY DETAILS</h5>
                            <div class="field-group emergency">
                                <div class="field">
                                    <label class="label" for="ename">Emergency person</label>
                                    <input onkeydown="validateText(event)" id="ename" type="text" name="ename" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['ename'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                                <div class="field">
                                    <label class="label" for="ephone">Phone</label>
                                    <input onkeydown="validateNumber(event)" id="ephone" type="tel" name="ephone" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['ephone'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                                <div class="field">
                                    <label class="label" for="eaddress">Address</label>
                                    <input id="eaddress" type="text" name="eaddress" <?php echo ($loggedIn && $show) ? 
                                        'value="' . $_SESSION['eaddress'] . '" disabled' : ''; ?> autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="file-view-container" class="field files">
                        <label class="label" for="file">Verification</label>
                        <input class="file<?php echo ($loggedIn && $show) ? ' hide' : ''; ?>" type="file" id="file" name="file[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                        <div id="file-viewer" class="file-viewer<?php echo ($loggedIn && $show) ? '' : ' hide'; ?>">
                            <?php
                            if ($loggedIn && $show) {
                                $images = [];
                                $pdfs = [];
                                foreach(json_decode($_SESSION['files'], true) as $filePath) {
                                    if (file_exists($filePath)) {
                                        $type = mime_content_type($filePath);
                                        if (strpos($type, 'image/') === 0) {
                                            $images[] = $filePath;
                                        } else if ($type === 'application/pdf') {
                                            $pdfs[] = $filePath;
                                        }
                                    }
                                }
                                if (count($pdfs) > 0) {
                                    echo '<div class="uploaded-pdfs">';
                                    foreach($pdfs as $pdf) {
                                        echo '<iframe class="pdf" src="' . $pdf . '"></iframe>'; // INSUFFICIENT FILEPATH CHECK
                                    }
                                    echo '</div>';
                                }
                                if (count($images) > 0) {
                                    echo '<div class="uploaded-images">';
                                    foreach($images as $image) {
                                        echo '<img class="images" src="' . $image . '">';   // INSUFFICIENT FILEPATH CHECK
                                    }
                                    echo '</div>';
                                }
                                if (count($pdfs) === 0 && count($images) === 0) {
                                    echo '<p class="missing">Missing/No uploaded files</p>';
                                }
                            }
                             ?>
                        </div>
                    </div>
                    <div id="field-buttons" class="field buttons<?php echo ($loggedIn && $show) ? ' hide' : ''; ?>">
                        <div id="cancel" class="cancel hide" onClick="cancel()">Cancel</div>
                        <button type="submit" id="submit" class="submit<?php echo ($loggedIn && $show) ? ' hide' : ''; ?>">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>

        function login() {
            window.location.href = 'login.php';
        }

        function back() {
            window.location.href = 'admin.php';
        }

        function cancel() {
            window.location.reload();
        }

        function validateText(event) {
            const key = event.key;
            const regex = /^[a-zA-ZÀ-ÖØ-öø-ÿ\'\-\. ]+$/;
            if (!regex.test(key) && !['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'].includes(key)) {
                event.preventDefault();
            }
        }

        function validateNumber(event) {
            if (!/^[0-9\-]+$/.test(event.key) &&
                event.key !== "Backspace" && 
                event.key !== "Delete" &&
                event.key !== "ArrowLeft" && 
                event.key !== "ArrowRight" &&
                event.key !== "Tab") {
                event.preventDefault();
            }
        }

        function editProfile() {
            document.getElementById('form').action = 'process/edit.php';
            document.getElementById('submit').classList.remove('hide');
            document.getElementById('cancel').classList.remove('hide');
            document.getElementById('field-buttons').classList.remove('hide');
            document.getElementById('file-view-container').classList.add('hide');
            document.getElementById('edit').classList.add('hide');
            var elements = ['firstname','middlename','lastname','student_id',
                            'age','birthdate','gender','phone','email','address',
                            'citizenship','religion','guardian','father','relation',
                            'mother','gphone','ename','ephone','eaddress','file'];
            elements.forEach(function(id) {
                var element = document.getElementById(id);
                if (element) { element.disabled = false; }
            });
        }

        function validateForm(edit) {
            var elements = ['firstname','middlename','lastname','student_id',
                            'age','birthdate','gender','phone','email','address',
                            'citizenship','religion','guardian','relation',
                            'gphone','ename','ephone','eaddress','file'];
            var valid = true;
            let errors = [];
            elements.forEach(function(id) {
                var element = document.getElementById(id);
                var label = document.querySelector('label[for="' + id + '"]');
                if (element) {
                    if (element.tagName === 'INPUT') {
                        switch (element.type) {
                            case 'text':
                            case 'number':
                                var idPattern = /^(\d{2}-\d{4}-\d{5,})$/;
                                if (element.value.trim() === '' || (id === 'student_id' && !idPattern.test(element.value.trim()))) {
                                    element.style.borderBottomWidth = '1px';
                                    element.style.borderBottomColor = 'red';
                                    valid = false;
                                    if (element.value.trim() === '') {
                                        errors.push(label.textContent + ' is empty');
                                    } else if (id === 'student_id' && !idPattern.test(element.value.trim())) {
                                        errors.push(label.textContent + ' should be in 00-0000-0000+ format');
                                    }
                                } else {
                                    element.style.borderBottomWidth = '';
                                    element.style.borderBottomColor = '';
                                }
                                break;
                            case 'date':
                                if (!element.value) {
                                    element.style.borderBottomWidth = '1px';
                                    element.style.borderBottomColor = 'red';
                                    valid = false;
                                    errors.push(label.textContent + ' is not set');
                                } else {
                                    element.style.borderBottomWidth = '';
                                    element.style.borderBottomColor = '';
                                }
                                break;
                            case 'file':
                                if (!edit) {
                                    const allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                                    const files = Array.from(element.files);
                                    const invalid = files.some(file => {
                                        const extension = file.name.split('.').pop().toLowerCase();
                                        return !allowed.includes(extension);
                                    });
                                    if (element.files.length === 0 || invalid) {
                                        element.parentElement.style.borderBottomWidth = '1px';
                                        element.parentElement.style.borderBottomColor = 'red';
                                        valid = false;
                                        if (element.files.length === 0) {
                                            errors.push(label.textContent + ' is empty');
                                        } else if (invalid) {
                                            errors.push(label.textContent + ' has invalid file/s');
                                        }
                                    } else {
                                        element.parentElement.style.borderBottomWidth = '';
                                        element.parentElement.style.borderBottomColor = '';
                                    }
                                }
                                break;
                            case 'tel':
                                var telPattern = /^(0(9\d{9})|63(9\d{9})|(9\d{9}))$/;
                                if (element.value.trim() === '' || !telPattern.test(element.value.trim())) {
                                    element.style.borderBottomWidth = '1px';
                                    element.style.borderBottomColor = 'red';
                                    valid = false;
                                    if (element.value.trim() === '') {
                                        errors.push(label.textContent + ' is empty');
                                    } else if (!telPattern.test(element.value.trim())) {
                                        errors.push(label.textContent + ' has invalid format');
                                    }
                                } else {
                                    element.style.borderBottomWidth = '';
                                    element.style.borderBottomColor = '';
                                }
                                break;
                            case 'email':
                                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                if (element.value.trim() === '' || !emailPattern.test(element.value.trim())) {
                                    element.style.borderBottomWidth = '1px';
                                    element.style.borderBottomColor = 'red';
                                    valid = false;
                                    if (element.value.trim() === '') {
                                        errors.push(label.textContent + ' is empty');
                                    } else if (!emailPattern.test(element.value)) {
                                        errors.push(label.textContent + ' has invalid format');
                                    }
                                } else {
                                    element.style.borderBottomWidth = '';
                                    element.style.borderBottomColor = '';
                                }
                                break;
                        }
                    } else if (element.tagName === 'SELECT') {
                        if (element.value === 'default') {
                            element.style.borderBottomWidth = '1px';
                            element.style.borderBottomColor = 'red';
                            valid = false;
                            errors.push(label.textContent + ' has no selection');
                        } else {
                            element.style.borderBottomWidth = '';
                            element.style.borderBottomColor = '';
                        }
                    }
                }
            });
            if (!valid) {
                alert(errors.join('  |  '));
            }
            return valid;
        }

    </script>
</body>
</html>