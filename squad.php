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
    <title>DY PATIL Cricket tournament</title>
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
            <img src="assets/images/dyp-logo.png" alt="DYP Logo" width="250px" height="auto">>
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
                                    <input type="text" class="form-control text-name" id="captain" name="captain" placeholder="Captain">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkcaptain" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkcaptain" name="lkcaptain"  placeholder="Enter your mobile no">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="vicecaptain" class="form-label text-muted">Vice Captain <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="vicecaptain" name="vicecaptain"  placeholder="Vice Captain">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkvicecaptain" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkvicecaptain" name="lkvicecaptain"  placeholder="Enter your mobile no">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player3" class="form-label text-muted">Player 3 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player3" name="player3" placeholder="Player 3">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer3" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer3" name="lkplayer3"  placeholder="Enter your mobile no">
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player4" class="form-label text-muted">Player 4 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player4" name="player4" placeholder="Player 4">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer4" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer4" name="lkplayer4"  placeholder="Enter your mobile no">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player5" class="form-label text-muted">Player 5 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player5" name="player5" placeholder="Player 5">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer5" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer5" name="lkplayer5"  placeholder="Enter your mobile no">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player6" class="form-label text-muted">Player 6 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player6" name="player6" placeholder="Player 6">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer6" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer6" name="lkplayer6"  placeholder="Enter your mobile no">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player7" class="form-label text-muted">Player 7 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player7" name="player7" placeholder="Player 7">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer7" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer7" name="lkplayer7"  placeholder="Enter your mobile no">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player8" class="form-label text-muted">Player 8 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player8" name="player8" placeholder="Player 8">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lkplayer8" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer8" name="lkplayer8"  placeholder="Enter your mobile no">
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player9" class="form-label text-muted">Player 9 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player9" name="player9" placeholder="Player 9">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer9" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer9" name="lkplayer9"  placeholder="Enter your mobile no">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player10" class="form-label text-muted">Player 10 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player10" name="player10" placeholder="Player 10">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer10" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer10" name="lkplayer10"  placeholder="Enter your mobile no">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="player11" class="form-label text-muted">Player 11 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-name" id="player11" name="player11" placeholder="Player 11">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lkplayer11" class="form-label text-muted">Contact No</label>
                                    <input type="text" class="form-control text-name" id="lkplayer11" name="lkplayer11"  placeholder="Enter your mobile no">
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
        <footer class="footer m-0 Squadfooter">
            <div class="container">
                <p class="mb-0">All rights reserved &copy; 2024</p>
            </div>
        </footer>
    </div>

    
    
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
                if ($("#captain").val() === "") {
                    isValid = false;
                    console.log('captain');
                    $("#captain").addClass('is-invalid');  
                    $("#captain").after('<span class="error text-danger">This field is required</span>');
                }

                // Vice Captain validation
                if ($("#vicecaptain").val() === "") {
                    isValid = false;
                    console.log('vicecaptain');
                    $("#vicecaptain").addClass('is-invalid');  
                    $("#vicecaptain").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 3 validation
                if ($("#player3").val() === "") {
                    isValid = false;
                    console.log('player3');
                    $("#player3").addClass('is-invalid');  
                    $("#player3").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 4 validation
                if ($("#player4").val() === "") {
                    isValid = false;
                    console.log('player4');
                    $("#player4").addClass('is-invalid');  
                    $("#player4").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 5 validation
                if ($("#player5").val() === "") {
                    isValid = false;
                    console.log('player5');
                    $("#player5").addClass('is-invalid');  
                    $("#player5").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 6 validation
                if ($("#player6").val() === "") {
                    isValid = false;
                    console.log('player6');
                    $("#player6").addClass('is-invalid');  
                    $("#player6").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 7 validation
                if ($("#player7").val() === "") {
                    isValid = false;
                    console.log('player7');
                    $("#player7").addClass('is-invalid');  
                    $("#player7").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 8 validation
                if ($("#player8").val() === "") {
                    isValid = false;
                    console.log('player8');
                    $("#player8").addClass('is-invalid');  
                    $("#player8").after('<span class="error text-danger">This field is required</span>');
                }

                // Player 9 validation
                if ($("#player9").val() === "") {
                    isValid = false;
                    console.log('player9');
                    $("#player9").addClass('is-invalid');  
                    $("#player9").after('<span class="error text-danger">This field is required</span>');
                }

                if ($("#player10").val() === "") {
                    isValid = false;
                    console.log('player10');
                    $("#player10").addClass('is-invalid');  
                    $("#player10").after('<span class="error text-danger">This field is required</span>');
                }

                if ($("#player11").val() === "") {
                    isValid = false;
                    console.log('player11');
                    $("#player11").addClass('is-invalid');  
                    $("#player11").after('<span class="error text-danger">This field is required</span>');
                }
                
                // let lkcaptain = $("#lkcaptain").val();
                // if (lkcaptain === "") {
                //     isValid = false;
                //     console.log('lkcaptain');
                //     $("#lkcaptain").addClass('is-invalid');  
                //     $("#lkcaptain").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkcaptain !== "" && !isValidURL(lkcaptain)) {
                //     isValid = false;
                //     console.log('lkcaptainurl');
                //     $("#lkcaptain").addClass('is-invalid');  
                //     $("#lkcaptain").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkvicecaptain = $("#lkvicecaptain").val();
                // if (lkvicecaptain === "") {
                //     isValid = false;
                //     console.log('lkvicecaptain');
                //     $("#lkvicecaptain").addClass('is-invalid');  
                //     $("#lkvicecaptain").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkvicecaptain !== "" && !isValidURL(lkvicecaptain)) {
                //     isValid = false;
                //     console.log('lkvicecaptainurl');
                //     $("#lkvicecaptain").addClass('is-invalid');  
                //     $("#lkvicecaptain").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer3 = $("#lkplayer3").val();
                // if (lkplayer3 === "") {
                //     isValid = false;
                //     console.log('lkplayer3');
                //     $("#lkplayer3").addClass('is-invalid');  
                //     $("#lkplayer3").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer3 !== "" && !isValidURL(lkplayer3)) {
                //     isValid = false;
                //     console.log('lkplayer3url');
                //     $("#lkplayer3").addClass('is-invalid');  
                //     $("#lkplayer3").after('<span class="error text-danger">Not a linked a URL</span>');
                // }
                
                // let lkplayer4 = $("#lkplayer4").val();
                // if (lkplayer4 === "") {
                //     isValid = false;
                //     console.log('lkplayer4');
                //     $("#lkplayer4").addClass('is-invalid');  
                //     $("#lkplayer4").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer4 !== "" && !isValidURL(lkplayer4)) {
                //     isValid = false;
                //     console.log('lkplayer4url');
                //     $("#lkplayer4").addClass('is-invalid');  
                //     $("#lkplayer4").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer5 = $("#lkplayer5").val();
                // if (lkplayer5 === "") {
                //     isValid = false;
                //     console.log('lkplayer5');
                //     $("#lkplayer5").addClass('is-invalid');  
                //     $("#lkplayer5").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer5 !== "" && !isValidURL(lkplayer5)) {
                //     isValid = false;
                //     console.log('lkplayer5url');
                //     $("#lkplayer5").addClass('is-invalid');  
                //     $("#lkplayer5").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer6 = $("#lkplayer6").val();
                // if (lkplayer6 === "") {
                //     isValid = false;
                //     console.log('lkplayer6');
                //     $("#lkplayer6").addClass('is-invalid');  
                //     $("#lkplayer6").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer6 !== "" && !isValidURL(lkplayer6)) {
                //     isValid = false;
                //     console.log('lkplayer6url');
                //     $("#lkplayer6").addClass('is-invalid');  
                //     $("#lkplayer6").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer7 = $("#lkplayer7").val();
                // if (lkplayer7 === "") {
                //     isValid = false;
                //     console.log('lkplayer7');
                //     $("#lkplayer7").addClass('is-invalid');  
                //     $("#lkplayer7").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer7 !== "" && !isValidURL(lkplayer7)) {
                //     isValid = false;
                //     console.log('lkplayer7url');
                //     $("#lkplayer7").addClass('is-invalid');  
                //     $("#lkplayer7").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer8 = $("#lkplayer8").val();
                // if (lkplayer8 === "") {
                //     isValid = false;
                //     console.log('lkplayer8');
                //     $("#lkplayer8").addClass('is-invalid');  
                //     $("#lkplayer8").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer8 !== "" && !isValidURL(lkplayer8)) {
                //     isValid = false;
                //     console.log('lkplayer8url');
                //     $("#lkplayer8").addClass('is-invalid');  
                //     $("#lkplayer8").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer9 = $("#lkplayer9").val();
                // if (lkplayer9 === "") {
                //     isValid = false;
                //     console.log('lkplayer9');
                //     $("#lkplayer9").addClass('is-invalid');  
                //     $("#lkplayer9").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer9 !== "" && !isValidURL(lkplayer9)) {
                //     isValid = false;
                //     console.log('lkplayer9url');
                //     $("#lkplayer9").addClass('is-invalid');  
                //     $("#lkplayer9").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer10 = $("#lkplayer10").val();
                // if (lkplayer10 === "") {
                //     isValid = false;
                //     console.log('lkplayer10');
                //     $("#lkplayer10").addClass('is-invalid');  
                //     $("#lkplayer10").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer10 !== "" && !isValidURL(lkplayer10)) {
                //     isValid = false;
                //     console.log('lkplayer10url');
                //     $("#lkplayer10").addClass('is-invalid');  
                //     $("#lkplayer10").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // let lkplayer11 = $("#lkplayer11").val();
                // if (lkplayer11 === "") {
                //     isValid = false;
                //     console.log('lkplayer11');
                //     $("#lkplayer11").addClass('is-invalid');  
                //     $("#lkplayer11").after('<span class="error text-danger">This field is required</span>');
                // }else if (lkplayer11 !== "" && !isValidURL(lkplayer11)) {
                //     isValid = false;
                //     console.log('lkplayer11url');
                //     $("#lkplayer11").addClass('is-invalid');  
                //     $("#lkplayer11").after('<span class="error text-danger">Not a linked a URL</span>');
                // }

                // Prevent form submission if validation fails
                if (!isValid) {
                    console.log(isValid);
                    event.preventDefault();
                    return false;
                }
            });
            
        });

        // function isValidURL(url) {
        //     const pattern = new RegExp('^(https?:\\/\\/)' + // protocol (http or https)
        //         '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        //         '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ipv4 address
        //         '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        //         '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        //         '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator

        //     return pattern.test(url);
        // }

        function isValidURL(url) {
            const pattern = new RegExp('^https:\\/\\/(www\\.linkedin\\.com\\/in\\/[a-zA-Z0-9-]+|in\\.linkedin\\.com\\/in\\/[a-zA-Z0-9-]+|www\\.linkedin\\.com\\/company\\/[a-zA-Z0-9-]+(?:\\/mycompany\\/?)?)\\/??$', 'i');
            return pattern.test(url);
        }

        

    </script>
</body>
</html>