<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiler - Dashboard</title>
    <?php include 'process/db_connection.php'; ?>
    <link rel="stylesheet" href="styles/dash.css">
</head>
<!-- ADD COURSE/YEAR FOR DATA -->
<body>
    <section>
        <div class="header">
            <img src="images/LOGO.png" alt="Logo" class="logo">
            <h2>Profiler Dashboard</h2>
            <div class="logout">
                <img src="images/logout.png" class="icon log" onclick="logout()" title="Logout">
            </div>
        </div>
        <div class="container">
            <div class="actions small">
                <div class="action" title="Add">
                    <img src="images/add.png" class="action-icon" onclick="">
                    <h4>ADD</h4>
                </div>
                <div class="action" title="Show">
                    <img src="images/show.png" class="action-icon" onclick="">
                    <h4>SHOW</h4>
                </div>
                <div class="action" title="Edit">
                    <img src="images/edit.png" class="action-icon" onclick="">
                    <h4>EDIT</h4>
                </div>
                <div class="action" title="Delete">
                    <img src="images/delete.png" class="action-icon" onclick="">
                    <h4>DELETE</h4>
                </div>
            </div>
            <div class="actions large">
                <div class="action" title="Table">
                    <img src="images/table.png" class="action-icon" onclick="">
                    <h4>TABLE</h4>
                </div>
                <div class="action" title="Documents">
                    <img src="images/document.png" class="action-icon" onclick="">
                    <h4>DOCUMENTS</h4>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
