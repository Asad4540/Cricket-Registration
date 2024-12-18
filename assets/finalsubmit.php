<?php
require('assets/config/db.php');
use PHPMailer\PHPMailer\PHPMailer;

function generateToken() {
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
                        $teamdetailsurl = $base_url."vm_cricket_tournament/teamdetails.php?token=".$newToken;

                        if ($updateStmt->affected_rows > 0) {
                            sendConfirmationEmail($row['email'],$row['companyname'],$teamdetailsurl);
                            echo '<script>
                            alert("Team Registered Successfully!");
                            window.location.href = "teamdetails.php?token=' . $newToken . '";
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

function sendConfirmationEmail($email,$companyname,$teamdetailsurl) {
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'lucy.smith@ittech-news.com'; // Replace with your SMTP username
        $mail->Password = 'vmxazdvtlnrrrvkm'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Set the encryption method
        $mail->Port = 587; // Set the SMTP port

        // Recipients
        $mail->setFrom('lucy.smith@ittech-news.com');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'ittech-news.com';
        $mail->Body = $mail->Body = "<!DOCTYPE html>
            <html lang='en'>

            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Download PDF Button</title>
            </head>

            <body>

                <div style='text-align: center;'>
                    <p>You have successfully registered for Vereigemedia cricket tournament with team <b>$companyname</b></p>

                    <p>Please find your team details and match rules <a href=".$teamdetailsurl.">here</a></p>
                </div>
            </body>

            </html>";
        $mail->send();
      
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
