<?php
    require('assets/config/db.php'); 

    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $selectSql = "SELECT * FROM team WHERE token = ?";

        if ($selectStmt = $conn->prepare($selectSql)) {
            $selectStmt->bind_param("s", $token);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Check the 'rulesaccepted' column
                if ($row['rulesaccepted'] == 1) {
                    echo '<script>
                    alert("Form Already Submitted");
                    window.location.href = "assets/pdf/cricket_rules.pdf";
                    </script>';
                    exit();
                }
            } else {
                echo '<script>
                alert("Invalid URL!");
                window.location.href = "index.html";
                </script>';
                exit();
            }

            $selectStmt->close();
        } else {
            echo 'Error preparing the select statement: ' . $conn->error;
        }
    }else{
        echo '<script>
        alert("Invalid URL!");
        window.location.href = "index.html";
        </script>';
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VM Cricket tournament</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');
    </style>
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/images/vereigen_logo.png" alt="Bootstrap" width="150px" height="auto">
            </a>
        </div>
    </nav>
    <div class="wrappertwo">
        <div class="wrapperto-header">
            <h1>Match Rules</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <li>Group stage matches will be conducted</li>
                    <li>Draws will be made at 11am, captains are required to be present.</li>
                    
                    <h2>Player Rule</h2>
                    <ul>
                        <li>Only 7 Players a side + 3 Substitutes Player</li>
                    </ul>

                    <h2>Over Rule</h2>
                    <ul>
                        <li>For Group Matches 6 Overs per innings</li>
                    <li>For Knockout Matches 6 Overs per innings</li>
                    </ul>

                    <h2>Over Limit</h2>
                    <ul>
                        <li>2 Bowlers 2 Over Max. (Remaining 2 overs 1 Bowler/Over)</li>
                    </ul>

                    <h2>Batting Rule</h2>
                    <ul>
                        <li>Only one runner is allowed on the pitch while batting.</li>
                    </ul>

                    <h2>BOUNDARIES & SIXES RULE</h2>
                    <ul>
                        <li>Boundaries & Sixes are allowed in only Front Side.</li>
                        <li>All other Sides only Runs are considered.</li>
                        <li>Ball reaching the boundary after connecting with other nets will be considered 4 runs.</li>
                        <li>Hitting ball outside the net except the front will be considered 1 run and also the player can cross if the run is completed.</li>
                    </ul>
                
                    <h2>BOWLING RULE</h2>
                    <ul>
                        <li>Only one- step Bowling is Allowed, and the one foot must be land within the crease, if rule is not followed Ball is considered as No Ball.(free hit next ball)</li>
                        <li>Over pacing will have one warning and another in same over will be considered No Ball(free hit next ball). Exception if the batsmen has no objection regarding the pace.</li>
                        <li>Bowling should be done ahead of the umpire or it would be considered as No ball.</li>
                        <li>If ball landed outside the pitch during bowling it will be considered as No ball.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h2>OUT RULES</h2>
                    <ul>
                        <li>Bowled</li>
                        <li>Catch Out.</li>
                        <li>Run-Out.</li>
                        <li>Hit-Wicket.</li>
                    </ul>

                    <h2>NO BALL, WIDE BALL & BYES RULE</h2>
                    <ul>
                        <li>Runs will be counted for each No Ball & Wide Ball.</li>
                        <li>After No Ball next ball is considered as Free Hit.</li>
                        <li>Bye Runs are not allowed, however batsman can rotate the strike.</li>
                    </ul>
                
                
                    <h2>FIELDING RULE</h2>
                    <ul>
                        <li>Maximum 3 players are allowed to stand behind the non-strikers stumps, if rule is not followed Ball is considered as No Ball.(free hit next ball).</li>
                        <li>Overthrow runs are allowed.</li>
                    </ul>

                    <h2>IN CASE OF TIE</h2>
                    <ul>
                        <li>All players must be present all the time on the ground as match will be played in quick succession.</li>
                        <li>If the full team doesn’t report 10 minutes prior to the official start time as per schedule, the opposite team will be awarded as winners.</li>
                        <li>A player who has played in one team is not allowed to play in another team. Player list submitted is the Final no change allowed.</li>
                        <li>Umpire decisions are final & irrevocable.</li>
                        <li>All players are expected to be courteous to each other and with the officials.</li>
                        <li>Arguments with umpire will lead to player/team disqualification. This will be strictly followed.</li>
                        <li>Intoxication of any substances is not allowed.</li>
                    </ul>
                </div>

                <div class="text-end">
                    <form action="finalsubmit.php" method="post" id="form3">
                    <!-- Proper PHP in HTML -->
                     <?php
                        $token = $_GET['token']
                     ?>
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8'); ?>">

                        <button class="btn w-md-100 w-25 text-center" type="submit" id="btn-thirdform">Agree & Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="mb-0">All rights reserved &copy; 2024</p>
        </div>
    </footer>
    
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
</body>
</html>