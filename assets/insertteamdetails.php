<?php
  require('assets/config/db.php'); 

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!isset($_POST['captain'])) {
        echo 'Captain is required.'; // Corrected 'Captaine' to 'Captain'
        exit();
    }

    if (!isset($_POST['vicecaptain'])) {
        echo 'Vice-captain is required.';
        exit();
    }

    // Sanitize input data
    $token = $conn->real_escape_string($_POST['token']);
    $captain = $conn->real_escape_string($_POST['captain']);
    $vicecaptain = $conn->real_escape_string($_POST['vicecaptain']);
    $player3 = $conn->real_escape_string($_POST['player3']);
    $player4 = $conn->real_escape_string($_POST['player4']);
    $player5 = $conn->real_escape_string($_POST['player5']);
    $player6 = $conn->real_escape_string($_POST['player6']);
    $player7 = $conn->real_escape_string($_POST['player7']);
    $player8 = $conn->real_escape_string($_POST['player8']);
    $player9 = $conn->real_escape_string($_POST['player9']);
    $player10 = $conn->real_escape_string($_POST['player10']);
    $player11 = $conn->real_escape_string($_POST['player11']);
    $lkcaptain = $conn->real_escape_string($_POST['lkcaptain']);
    $lkvicecaptain = $conn->real_escape_string($_POST['lkvicecaptain']);
    $lkplayer3 = $conn->real_escape_string($_POST['lkplayer3']);
    $lkplayer4 = $conn->real_escape_string($_POST['lkplayer4']);
    $lkplayer5 = $conn->real_escape_string($_POST['lkplayer5']);
    $lkplayer6 = $conn->real_escape_string($_POST['lkplayer6']);
    $lkplayer7 = $conn->real_escape_string($_POST['lkplayer7']);
    $lkplayer8 = $conn->real_escape_string($_POST['lkplayer8']);
    $lkplayer9 = $conn->real_escape_string($_POST['lkplayer9']);
    $lkplayer10 = $conn->real_escape_string($_POST['lkplayer10']);
    $lkplayer11 = $conn->real_escape_string($_POST['lkplayer11']);

    try {
        // Prepare the select query
        $selectSql = "SELECT * FROM team WHERE token = ?";
        $selectStmt = $conn->prepare($selectSql);
        if ($selectStmt) {
            $selectStmt->bind_param("s", $token);
            $selectStmt->execute();
            $result = $selectStmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $newtoken = generateToken(); // Assuming generateToken() is defined elsewhere

                    // Prepare the update query
                    $updateSql = "UPDATE team 
                                    SET captain = ?, 
                                        vicecaptain = ?, 
                                        player3 = ?, 
                                        player4 = ?, 
                                        player5 = ?, 
                                        player6 = ?, 
                                        player7 = ?, 
                                        player8 = ?, 
                                        player9 = ?, 
                                        player10 = ?,
                                        player11 = ?,
                                        lkcaptain = ?,
                                        lkvicecaptain = ?,
                                        lkplayer3 = ?,
                                        lkplayer4 = ?,
                                        lkplayer5 = ?,
                                        lkplayer6 = ?,
                                        lkplayer7 = ?,
                                        lkplayer8 = ?,
                                        lkplayer9 = ?,
                                        lkplayer10 = ?,
                                        lkplayer11 = ?,
                                        token = ?
                                    WHERE id = ?";

                    $updateStmt = $conn->prepare($updateSql);
                    if ($updateStmt) {
                        // Bind parameters to update statement
                        $updateStmt->bind_param(
                            "sssssssssssssssssssssssi",
                            $captain, $vicecaptain, $player3, $player4, $player5,
                            $player6, $player7, $player8, $player9, $player10, $player11,
                            $lkcaptain, $lkvicecaptain, $lkplayer3, $lkplayer4, $lkplayer5,
                            $lkplayer6, $lkplayer7, $lkplayer8, $lkplayer9, $lkplayer10,
                            $lkplayer11, $newtoken, $row['id']
                        );

                        $updateStmt->execute();

                        // Check if the update was successful
                        if ($updateStmt->affected_rows > 0) {
                            header("Location: agree.php?token=" . $newtoken);
                            exit();
                        } else {
                            echo '<script>
                                alert("There\'s some error submitting the form.");
                                window.location.href = "index.html";
                                </script>';
                            exit();
                        }

                        $updateStmt->close();
                    } else {
                        // Handle update statement preparation error
                        echo 'Error: ' . $conn->error;
                    }
                }
            } else {
                // Handle no matching record
                echo '<script>
                    alert("Invalid token.");
                    window.location.href = "index.html";
                    </script>';
                exit();
            }

            $selectStmt->close();
        } else {
            // Handle select statement preparation error
            echo 'Error: ' . $conn->error;
        }
    } catch (\Throwable $th) {
        // Catch any exceptions and output error message
        echo $th->getMessage();
    }
}

function generateToken() {
    return bin2hex(random_bytes(8));
}
?>