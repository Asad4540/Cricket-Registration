<?php
require('../assets/config/db.php');
session_start();
if (!isset($_SESSION['username'])) {
  session_destroy();
  echo '<script>
        alert("Un-authorized access - Please login");
        window.location.href = "login.php";
      </script>';
  exit();
}

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']); 

    $selectSql = "SELECT * FROM team WHERE token = ?";

    $stmt = $conn->prepare($selectSql);

    if ($stmt) {
        $stmt->bind_param("s", $token); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['rulesaccepted'] == 0) {
                echo '<script>
                    alert("Invalid URL!");
                    window.location.href = "index.php";
                    </script>';
                exit();
            }
        } else {
            // Token not found
            echo "Invalid token!";
            exit;
        }
    } else {
        echo 'Error: ' . $conn->error;
    }
} else {
    echo '<script>
        alert("Invalid URL!");
        window.location.href = "index.php";
        </script>';
    exit();
}



try {
    $selectSql = "SELECT * FROM team WHERE token = ?";
    $selectStmt = $conn->prepare($selectSql);
    if ($selectStmt) {
        $selectStmt->bind_param("s", $token);
        $selectStmt->execute();
        $result = $selectStmt->get_result();

        if ($result->num_rows > 0) {
            $team = $result->fetch_assoc();
        } else {
            echo '<script>
                alert("Invalid URL!");
                window.location.href = "index.php";
                </script>';
            exit();
        }

        $selectStmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
        exit;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/dyp-logo.png" alt="Bootstrap" width="150px" height="auto">
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="text-end"><a href="../assets/pdf/cricket_rules.pdf" target="_blank" style="text-decoration: none;">View Rules</a> | <a onclick="printAsTable()" style="cursor: pointer;">Print</a></div>
        <div class="card mt-3">
            <div class="card-body" id="printableArea">
                <div class="text-center">
                    <h2>Team Details</h2>
                </div>
                <hr>
                <div class="row">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Company Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['companyname'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Company Linked URL</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['linkedinurl'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Contact Person</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['contactperson'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Phone Number</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['mobile'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Company Email</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['email'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Job Title</label>
                        <input type="text" value="<?php echo htmlspecialchars($team['jobtitle'] ?? 'null'); ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <h2>Squad Details</h2>
                </div>
                <hr>
                <div class="row">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Captain</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['captain'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkcaptain'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkcaptain'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Vice Captain</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['vicecaptain'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkvicecaptain'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkvicecaptain'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 3</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player3'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer3'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer3'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 4</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player4'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer4'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer4'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 5</label>
                        
                        <div class="row">
                            <div class="col-10">
                            <input type="text" value="<?php echo htmlspecialchars($team['player5'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer5'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer5'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 6</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player6'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer6'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer6'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 7</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player7'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer7'] != ''){
                                        echo '<a target="_blank" href="#" class="btn btn-info btn-sm" disabled><span><img src="../assets/images/linked_In.png" class="img-fluid"/></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 8</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player8'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer8'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer8'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"/></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 9</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player9'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer9'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer9'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 10</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player10'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer10'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer10'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="from-group col-md-4">
                        <label for="" class="text-muted form-label">Player 11</label>
                        
                        <div class="row">
                            <div class="col-10">
                                <input type="text" value="<?php echo htmlspecialchars($team['player11'] ?? 'null'); ?>" class="form-control" readonly>
                            </div>
                            <div class="col-2">
                                <?php
                                    if($team['lkplayer11'] != ''){
                                        echo '<a target="_blank" href="' . htmlspecialchars($team['lkplayer11'] ?? 'null') . '" class="btn btn-info btn-sm"><span><img src="../assets/images/linked_In.png" class="img-fluid"></span></a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function printAsTable() {
            // Extract values and labels
            var printableContent = `
                <table>
                    <h2>Team <?php echo htmlspecialchars($team['companyname'] ?? 'null'); ?></h2>
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th colspan="2">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Company Name</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['companyname'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr><td>Company Linked URL</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['linkedinurl'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr><td>Contact Person</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['contactperson'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr><td>Phone Number</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['mobile'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr><td>Company Email</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['email'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr><td>Captain</td><td colspan="2">${document.querySelector('input[value="<?php echo htmlspecialchars($team['captain'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 3</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['vicecaptain'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkvicecaptain'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 3</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player3'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer3'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 4</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player4'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer4'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 5</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player5'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer5'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 6</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player6'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer6'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 7</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player7'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer7'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 8</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player8'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer8'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 9</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player9'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer9'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 10</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player10'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer10'] ?? 'null'); ?>"]').value}</td></tr>
                        <tr colspan="3"><td>Player 11</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['player11'] ?? 'null'); ?>"]').value}</td><td>${document.querySelector('input[value="<?php echo htmlspecialchars($team['lkplayer11'] ?? 'null'); ?>"]').value}</td></tr>
                    </tbody>
                </table>
            `;

            // Open a new window
            var newWindow = window.open('', '', 'width=800,height=600');
            newWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            table, th, td { border: 1px solid #ddd; }
                            th, td { padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        ${printableContent}
                    </body>
                </html>
            `);

            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        }
    </script>
</body>

</html>