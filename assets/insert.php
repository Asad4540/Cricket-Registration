<?php
  require('assets/config/db.php'); 

  if ($_SERVER['REQUEST_METHOD'] === 'POST') 
  {
    if (!isset($_POST['companyname'])) {
        echo 'Company Name is required.';
        exit();
    }

    if (!isset($_POST['linkedinurl'])) {
        echo 'Linked In URL is required.';
        exit();
    }

    if (!isset($_POST['contactperson'])) {
        echo 'Contact person name is required!';
        exit();
    }

    if (!isset($_POST['phone'])) {
        echo 'Phone number is required!';
        exit();
    }

    if (!isset($_POST['email'])) {
        echo 'Email is required!';
        exit();
    }

    if (!isset($_POST['jobtitle'])) {
        echo 'Email is required!';
        exit();
    }

    $companyname = $conn->real_escape_string($_POST['companyname']);
    $linkedinurl = $conn->real_escape_string($_POST['linkedinurl']);
    $contactperson = $conn->real_escape_string($_POST['contactperson']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $jobtitle = $conn->real_escape_string($_POST['jobtitle']);
    $token = generateToken();


    $checkEmailSql = "SELECT * FROM team WHERE email = ? AND rulesaccepted = 1";
    $checkEmailStmt = $conn->prepare($checkEmailSql);

    if ($checkEmailStmt) {
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $result = $checkEmailStmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script>
                    alert("Email is already registered with team details");
                    window.location.href = "index.html"; 
                  </script>';
            exit();
        } else {
            $sql = "INSERT INTO team (`companyname`, `linkedinurl`, `contactperson`, `mobile`, `email`, `jobtitle`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssss", $companyname, $linkedinurl, $contactperson, $phone, $email, $jobtitle, $token);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    header("Location: squad.php?token=" . $token);
                    exit();
                } else {
                    echo '<script>
                        alert("There\'s some error");
                        window.location.href = "index.html";
                        </script>';
                    exit();
                }

                $stmt->close();
            } else {
                echo 'Error: ' . $conn->error;
            }
        }

        $checkEmailStmt->close();
    } else {
        echo 'Error preparing the email check statement: ' . $conn->error;
    }
  }

    function generateToken() {
        return bin2hex(random_bytes(8));
    }
?>