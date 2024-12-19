<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</head>

<body>

</body>

</html>

<?php
require('assets/config/db.php');
use PHPMailer\PHPMailer\PHPMailer;

function generateToken()
{
  return bin2hex(random_bytes(8));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['token'])) {
    echo "Invalid URL";
    return;
  }
  $token = $_POST['token'];

  try {
    $selectSql = "SELECT * FROM team WHERE token = ?";
    $selectStmt = $conn->prepare($selectSql);

    if ($selectStmt) {
      $selectStmt->bind_param("s", $token);
      $selectStmt->execute();
      $result = $selectStmt->get_result();

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $newToken = generateToken();

          $updateSql = "UPDATE team 
                                  SET rulesaccepted = '1', token = ?
                                  WHERE id = ?";

          $updateStmt = $conn->prepare($updateSql);
          if ($updateStmt) {
            $updateStmt->bind_param("si", $newToken, $row['id']);
            $updateStmt->execute();

            $protocol = isset($_SERVER['HTTPS']) &&
              $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
            $teamdetailsurl = $base_url . "cricket/teamdetails.php?token=" . $newToken;

            if ($updateStmt->affected_rows > 0) {
              sendConfirmationEmail($row['email'], $row['companyname'], $teamdetailsurl);
              echo '
                                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="successModalLabel">Team Registration Successful</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                The team has been registered successfully!
                                                You should have received an email with full details.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="seeDetailsBtn">See Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    $(document).ready(function() {
                                        // Show the modal when the document is ready
                                        $("#successModal").modal("show");
                                        
                                        // Redirect when "See Details" is clicked
                                        $("#seeDetailsBtn").click(function() {
                                            window.location.href = "teamdetails.php?token=' . $newToken . '";
                                        });
                                    });
                                </script>';
              exit();

            } else {
              echo '<script>
                            alert("Form Already Submitted");
                            window.location.href = "index.html";
                            </script>';
              exit();
            }
            $updateStmt->close();
          } else {
            echo 'Error: ' . $conn->error;
          }
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
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

function sendConfirmationEmail($email, $companyname, $teamdetailsurl)
{
  require 'PHPMailer/Exception.php';
  require 'PHPMailer/PHPMailer.php';
  require 'PHPMailer/SMTP.php';

  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'asadc4540@gmail.com'; // Replace with your SMTP username
    $mail->Password = 'Asad@45'; // Replace with your SMTP password
    $mail->SMTPSecure = 'tls';
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587; // Set the SMTP port

    // Recipients
    $mail->setFrom('asadc4540@gmail.com');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Registration Successful!';
    $mail->Body = $mail->Body = '<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email Template</title>
  </head>
  <body style="margin: 0; padding: 0; background-color: #fafafa; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #333333; text-align: left;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fafafa" style="border-spacing: 0; width: 100%; max-width: 600px; margin: 0 auto;">
      <tbody><tr>
        <td align="center">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #000;">
            <!-- Header Section -->
            <tbody><tr>
              <td align="center" style="padding: 20px 0 0;">
                <img src="https://vereigen-media.com/cricket/assets/images/crickbg.png" alt="Event Banner" width="600" style="max-width: 100%; height: auto; display: block;">
              </td>
            </tr>

            <!-- Title Section -->
            <tr>
              <td align="center" style="background-color: #000; padding: 0 15px;">
                <p style="color: #ffcb48; font-size: 24px; font-weight: bold; margin: 0;">
                  You have successfully registered for the DY PATIL Cricket Tournament
                </p>
              </td>
            </tr>

            <!-- Event Details Title -->
            <tr>
              <td align="center" style="background-color: #000; padding: 0 20px; color: #ffffff; text-align: center; font-weight: bold;">
                <p style="font-family: Helvetica, Arial, sans-serif; font-size: 28px; font-weight: 600; margin: 0;">
                  Event Details
                </p>
              </td>
            </tr>

            <!-- Event Information -->
            <tr>
              <td align="center" style="padding: 20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing: 0; text-align: center;">
                  <tbody><tr>
                    <!-- Time Section -->
                    <td align="center" width="50%" style="padding: 10px;">
                      <img src="https://d1csarkz8obe9u.cloudfront.net/uploads/emails/0fd13933271331c923087d92fc118a4a298570.gif" alt="Time Icon" width="50" style="max-width: 100%; height: auto; display: block;">
                      <p style="color: #ffcb48; font-size: 20px; font-weight: 700; margin: 10px 0 0;">Time</p>
                      <p style="color: #fbfbfb; font-size: 16px; margin: 10px 0 0;">13th October 2024,<br> 11:00 AM - 7:00 PM</p>
                    </td>
                    <!-- Venue Section -->
                    <td align="center" width="50%" style="padding: 10px;">
                      <img src="https://d1csarkz8obe9u.cloudfront.net/uploads/emails/c7c72c449eceb51a369bec73fb8aa2b4521839.gif" alt="Venue Icon" width="50" style="max-width: 100%; height: auto; display: block;">
                      <p style="color: #ffcb48; font-size: 20px; font-weight: 700; margin: 10px 0 0;">Venue</p>
                      <p style="color: #fbfbfb;font-size: 16px;margin: 0;">ADYPU, Pune</p>
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>

            <!-- Button Section -->
            <tr>
              <td align="center">
                <a href="' . $teamdetailsurl . '" style="background-color: #ffcb48; padding: 15px 30px; border-radius: 6px; font-size: 18px; font-weight: bold; text-align: center; color: #000; display: inline-block; margin:0;">View your details</a>
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>

      <!-- Footer Section -->
      <tr>
        <td align="center" style="background-color: #000; color: #fff; padding: 20px; text-align: center; font-size: 12px;">
          <p style="margin: 0;"> Bk, Admission Cell, Dr. D. Y. Patil School of MCA Charholi, Via, Lohegaon, Pune, Maharashtra 412105</p>
          <p style="margin: 5px 0;"><a href="#" style="color: #fff; text-decoration: underline;">Privacy Policy</a></p>
        </td>
      </tr>
    </tbody></table>
</body></html>';
    $mail->send();

  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
?>