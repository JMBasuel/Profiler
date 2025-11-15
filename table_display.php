<?php
include 'process/db_connection.php';

$stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS profiles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        added DATETIME DEFAULT CURRENT_TIMESTAMP,
        aby VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        student_id VARCHAR(255) NOT NULL,
        age INT NOT NULL,
        birthdate DATE NOT NULL,
        gender VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        citizenship VARCHAR(255) NOT NULL,
        religion VARCHAR(255) NOT NULL,
        phone VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        mother VARCHAR(255),
        father VARCHAR(255),
        guardian VARCHAR(255),
        gphone VARCHAR(255),
        relation VARCHAR(255),
        ename VARCHAR(255),
        ephone VARCHAR(255),
        eaddress VARCHAR(255),
        edited DATETIME DEFAULT CURRENT_TIMESTAMP,
        eby VARCHAR(255),
        files VARCHAR(255) NOT NULL
    );
");
$stmt->execute();

$sql = "SELECT * FROM profiles";
$result = $conn->query($sql);
$fields = $result->fetch_fields();
$colIndex =-1;

echo '<table>';
echo '<thead><tr>';
foreach ($fields as $field) {
    if (in_array($field->name, array('added', 'aby', 'name', 'student_id', 'gender', 'edited', 'eby'))) {
        $colIndex += 1;
        if ($field->type === MYSQLI_TYPE_DATETIME || $field->type === MYSQLI_TYPE_LONG || $field->name === 'name') {
            echo '<th class="sort" onClick="sortTable(' . $colIndex . ')">' . 
            $field->name . '<span class="arrow">&#9660;</span></th>';
        } else if ($field->name === 'aby' || $field->name === 'eby') {
            echo '<th>by</th>';
        } else {
            echo '<th>' . $field->name . '</th>';
        }
    }
}
echo '<th class="action"></th>
    <th class="action"></th>
    </tr></thead>';

if ($result->num_rows > 0) {
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        foreach($fields as $field) {
            if (in_array($field->name, array('added', 'aby', 'name', 'student_id', 'gender', 'edited', 'eby'))) {
                if ($field->type === MYSQLI_TYPE_DATETIME && !is_null($row[$field->name])) {
                    $datetime = new DateTime($row[$field->name]);
                    echo '<td>' . ($datetime->format('Y-m-d H:i')) . '</td>';
                } else if ($field->name === 'name' && !is_null($row[$field->name])) {
                    echo '<td>' . (str_replace('.', ' ', $row['name'])) . '</td>';
                } else {
                    echo '<td>' . ((is_null($row[$field->name])) ? '-' : $row[$field->name]) . '</td>';
                }
            }
        }
        echo '<td class="action"><form class="showSetup">';
            foreach($fields as $field) {
                if (!in_array($field->name, array('added', 'aby', 'edited', 'eby'))) {
                    if ($field->name === 'name') {
                        echo '<input type="hidden" name="firstname" value="' . (explode('.', explode(', ', $row['name'])[1])[0]) . '">';
                        echo '<input type="hidden" name="middlename" value="' . 
                        ((is_null(explode('.', explode(', ', $row['name'])[1])[1])) ? '' : explode('.', explode(', ', $row['name'])[1])[1]) . '">';
                        echo '<input type="hidden" name="lastname" value="' . (explode(', ', $row['name'])[0]) . '">';
                    } else {
                        echo "<input type='hidden' name='" . $field->name . "' value='" . $row[$field->name] . "'>";
                    }
                }
            }
        echo '<button type="submit">SHOW</button></form></td>';
        echo '<td class="action">
            <form class="deleteProfile">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button type="submit">DEL</button>
            </form></td></tr>';
    }
    echo '</tbody></table>';
}

$conn->close();
?>