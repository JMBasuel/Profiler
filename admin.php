<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiler - Admin</title>
    <?php include 'process/db_connection.php'; ?>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['account_name'])) {
        $_SESSION['error'] = "Login required";
        header("Location: login.php");
        exit();
    }
    ?>
    <section>
        <div class="header">
            <img src="images/LOGO.png" alt="Logo" class="logo">
            <h2>Profiler Timeline</h2>
            <div class="logout">
                <img src="images/logout.png" class="icon log" onclick="logout()" title="Logout">
            </div>
        </div>
        <div class="actions-container">
            <div></div>
            <div class="actions">
                <input type="text" id="filter" onkeyup="filterTable()" placeholder="Search for items...">
                <div class="add">
                    <img src="images/add.png" class="icon" onClick="addProfile()">
                </div>
            </div>
            <div></div>
        </div>
        <div class="table"></div>
    </section>

    <script>

        window.onload = function() {
            fetch('process/unset.php').catch(error => alert('Error: ' + error));
            initTable();
        };

        function addProfile() {
            window.location.href = 'home.php';
        }

        function logout() {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                // logout.php WILL REDIRECT TO login.php ONCE ALL SESSION VARIABLE ARE RESET
                // THIS IS TO PREVENT ACCESS TO admin.php AFTER LOGGING OUT THEN RETURNING TO THE PAGE
                window.location.href = "process/logout.php";
            }
        }

        function filterTable() {
            const filter = document.getElementById("filter").value;
            const tbody = document.querySelector("table").querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
        
            const filtered = [];
            const excess = [];
        
            rows.forEach(row => {
                const cells = row.getElementsByTagName("td");
                let match = false;
        
                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].getElementsByTagName("form").length > 0) {
                        continue;
                    }

                    const text = cells[i].textContent || cells[i].innerText;
                    const element = cells[i];
                    element.innerHTML = text;
        
                    if (text.includes(filter) && filter !== "") {
                        match = true;
                        const start = text.indexOf(filter);
                        const end = start + filter.length;
            
                        const highlight = `${text.substring(0, start)}<span class="match">${text.substring(start, end)}</span>${text.substring(end)}`;
                        element.innerHTML = highlight;
                    }
                }
        
                if (match) {
                    filtered.push(row);
                } else {
                    excess.push(row);
                }
            });
        
            filtered.forEach(row => tbody.appendChild(row));
            excess.forEach(row => tbody.appendChild(row));
        }

        function sortTable(index) {
            const table = document.querySelector("table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const isAsc = table.querySelectorAll("th")[index].classList.contains("asc");

            if (rows.length > 1) {
                const sortedRows = rows.sort(function (a, b) {
                    var cellA = a.cells[index].textContent.trim();
                    var cellB = b.cells[index].textContent.trim();
                    if (cellA === '-') return 1;
                    if (cellB === '-') return -1;
                    if (!isNaN(cellA) && !isNaN(cellB)) {
                        cellA = parseFloat(cellA);
                        cellB = parseFloat(cellB);
                    }
                    if (isAsc) {
                        return cellA > cellB ? 1 : -1;
                    } else {
                        return cellA < cellB ? 1 : -1;
                    }
                });
                sortedRows.forEach(row => tbody.appendChild(row));
                table.querySelectorAll("th").forEach(function (th, i) {
                    th.classList.remove("asc", "desc");
                    if (index === i) {
                        th.classList.add(isAsc ? "desc" : "asc");
                    }
                });
            }
        }

        function initTable() {
            fetch('table_display.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.table').innerHTML = data;
                
                const showSetup = Array.from(document.getElementsByClassName('showSetup'));
                const deleteForm = Array.from(document.getElementsByClassName('deleteProfile'));
                showSetup.forEach(form => {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        const data = new FormData(this);
                        fetch('process/setup_form.php', {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.text())
                        .then(() => {
                            window.location.href = 'home.php';
                        })
                        .catch(error => alert('Setup error: ' + error));
                    });
                });
                deleteForm.forEach(form => {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        var confirmed = confirm("Are you sure you want to delete this profile?");
                        if (confirmed) {
                            const data = new FormData(this);
                            fetch('process/delete.php', {
                                method: 'POST',
                                body: data
                            })
                            .then(response => response.text())
                            .then(() => {
                                initTable();
                            })
                            .catch(error => alert('Delete error: ' + error));
                        }
                    });
                });
            });
        }
    </script>
</body>
</html>
