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
    <div class="row wrapper wrapperone">
        <div class="col-md-7 hero-bg">
            <img src="assets/images/vereigen_logo.png" alt="Vereigen Logo">
        </div>
        <div class="col-md-5 main-form-section pt-5">
            <div class="form-view=">
                <div class="text-center">
                    <h1>Squad Details</h1>
                </div>

                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                    </div>
                  </div>

                    <div class="second-form-section">
                        <form action="insertteamdetails.php" method="post" id="form2" >
                            <div class="row">
                                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                <div class="form-group col-md-6">
                                    <label for="captain" class="form-label text-muted">Captain <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="captain" name="captain">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkcaptain" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkcaptain" name="lkcaptain">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="vicecaptain" class="form-label text-muted">Vice Captain <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="vicecaptain" name="vicecaptain">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkvicecaptain" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkvicecaptain" name="lkvicecaptain">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player3" class="form-label text-muted">Player 3 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player3" name="player3">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer3" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer3" name="lkplayer3">
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player4" class="form-label text-muted">Player 4 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player4" name="player4">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer4" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer4" name="lkplayer4">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player5" class="form-label text-muted">Player 5 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player5" name="player5">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer5" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer5" name="lkplayer5">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player6" class="form-label text-muted">Player 6 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player6" name="player6">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer6" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer6" name="lkplayer6">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player7" class="form-label text-muted">Player 7 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player7" name="player7">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer7" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer7" name="lkplayer7">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player8" class="form-label text-muted">Player 8 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player8" name="player8">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer8" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer8" name="lkplayer8">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player9" class="form-label text-muted">Player 9 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player9" name="player9">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer9" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer9" name="lkplayer9">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player10" class="form-label text-muted">Player 10</label>
                                    <input type="text" class="form-control text-name" id="player10" name="player10">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer10" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer10" name="lkplayer10">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player11" class="form-label text-muted">Player 11</label>
                                    <input type="text" class="form-control text-name" id="player11" name="player11">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer11" class="form-label text-muted">Linked In Profile <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="lkplayer11" name="lkplayer11">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="col-md-6"></div>
        
                                <div class="form-group col-md-6">
                                    <button class="btn w-100 text-center" type="submit" id="btn-secondform">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer m-0">
        <div class="container">
            <p class="mb-0">All rights reserved &copy; 2024</p>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#form2").on('submit', function(event) {
                let isValid = true;

                // Clear any previous error messages
                $(".error").remove();
                $(".form-control").removeClass('is-invalid'); 

                // Captain validation
                if ($("#captain").val().trim() === "") {
                    isValid = false;
                    $("#captain").addClass('is-invalid');  
                    $("#captain").after('<span class="error text-danger">This field is required</span>');
                }

                // Vice Captain validation
                if ($("#vicecaptain").val().trim() === "") {
                    isValid = false;
                    $("#vicecaptain").addClass('is-invalid');  
                    $("#vicecaptain").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 3 validation
                if ($("#player3").val().trim() === "") {
                    isValid = false;
                    $("#player3").addClass('is-invalid');  
                    $("#player3").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 4 validation
                if ($("#player4").val().trim() === "") {
                    isValid = false;
                    $("#player4").addClass('is-invalid');  
                    $("#player4").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 5 validation
                if ($("#player5").val().trim() === "") {
                    isValid = false;
                    $("#player5").addClass('is-invalid');  
                    $("#player5").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 6 validation
                if ($("#player6").val().trim() === "") {
                    isValid = false;
                    $("#player6").addClass('is-invalid');  
                    $("#player6").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 7 validation
                if ($("#player7").val().trim() === "") {
                    isValid = false;
                    $("#player7").addClass('is-invalid');  
                    $("#player7").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 8 validation
                if ($("#player8").val().trim() === "") {
                    isValid = false;
                    $("#player8").addClass('is-invalid');  
                    $("#player8").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 9 validation
                if ($("#player9").val().trim() === "") {
                    isValid = false;
                    $("#player9").addClass('is-invalid');  
                    $("#player9").after('<span class="error text-danger">This field is required</span>');
                }

                // Prevent form submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });

    </script>
</body>
</html>