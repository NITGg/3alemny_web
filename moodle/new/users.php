<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
        .fontawesomesvg {
            width: 1em;
            height: 1em;
            vertical-align: -.125em;
        }
    </style>
</head>

<body>
    <?php
    function getUsersByLastName($lastName)
    {
        $localsecrets = require(__DIR__ . '/../local_secrets.php');
        // Replace with your actual database credentials
        $servername = "localhost";
        $username = "i9505651_mo1";
        $password = $localsecrets['legacydb_password'];
        $dbname = "redaelkasass";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT * FROM mo_user WHERE lastName = ?");
        $stmt->bind_param("s", $lastName);
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch data
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // Close connections
        $stmt->close();
        $conn->close();

        return $users;
    }

    // Example usage
    $lastName = "Final Revision";
    $users = getUsersByLastName($lastName);
    ?>

    <h2>Users with Academic year <?php echo $lastName; ?></h2>

    <button class="btn btn-secondary" id="exportBtn" onclick="window.print()"><svg class='fontawesomesvg' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
            <path d="M32 64C32 28.7 60.7 0 96 0H256V128c0 17.7 14.3 32 32 32H416V288H248c-13.3 0-24 10.7-24 24s10.7 24 24 24H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V64zM416 336V288H526.1l-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39H416zm0-208H288V0L416 128z" />
        </svg> Export to PDF</button>

    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>#</th>
                <th>User Code</th>
                <th>First Name</th>
                <th>Academic year</th>
                <th>Email</th>
                <th>Phone1</th>
                <th>School</th>
                <th>Parent Number</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php $rowNumber = 1; ?>
            <?php foreach ($users as $user) : ?>

                <?php
                require_once(__DIR__ . '/../config.php');
                global $DB, $OUTPUT, $CFG, $USER;
                $school = $DB->get_record('user_info_data', array('fieldid' => 1, 'userid' => $user['id']));
                $parentnumber = $DB->get_record('user_info_data', array('fieldid' => 3, 'userid' => $user['id']));
                ?>
                <tr>
                    <td><?php echo $rowNumber++; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['phone1']; ?></td>
                    <td><?php echo $school ? $school->data : ''; ?></td>
                    <td><?php echo $parentnumber ? $parentnumber->data : ''; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script type="text/javascript" src="./js/table2excel.js"></script>
</body>

</html>