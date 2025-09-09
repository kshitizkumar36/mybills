<?php
session_start();
// db connection
include 'connection.php';

// handle form submission
if (isset($_POST['add_debits'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $invoice_for = $_POST['debit_for'];      // match form input
        $amount = $_POST['debit_amount'];
        $date_time = $_POST['debit_datetime'];
        $user_id= $_POST['user_id'];
        $trip_id= $_POST['trip_id'];

        // handle file upload
        $proof_file = null;
        if (!empty($_FILES['debit_proof']['name'])) {
            $target_dir = "debits/";  // changed folder name
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $proof_file = $target_dir . time() . "_" . basename($_FILES["debit_proof"]["name"]);
            move_uploaded_file($_FILES["debit_proof"]["tmp_name"], $proof_file);
        }

        // insert into debits table
        $stmt = $conn->prepare("INSERT INTO debits (trip_id,invoice_for, amount, date_time, proof,created_by) VALUES (?,?, ?, ?, ?,?)");
        $stmt->bind_param("dsdssd", $trip_id,$invoice_for, $amount, $date_time, $proof_file,$user_id);

          if ($stmt->execute()) {
            // ✅ Set session message
            session_start();
            $_SESSION['success'] = "Debit updated successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error updating debit!";
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        }

    }
}


if (isset($_POST['delete_debit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];

        // 1. Get old proof file
        $query = "SELECT proof FROM debits WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldData = $result->fetch_assoc();
        $old_proof = $oldData['proof'];

        // 2. Delete proof file if exists
        if (!empty($old_proof) && file_exists($old_proof)) {
            unlink($old_proof);
        }

        // 3. Delete the debit record
        $stmt = $conn->prepare("DELETE FROM debits WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['success'] = "Debit Removed successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error deleting debit!";
        }

        // 4. Redirect to previous page
        $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
        header("Location: $back");
        exit;
    }
}




if (isset($_POST['edit_debit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $invoice_for = $_POST['invoice_for'];
        $amount = $_POST['amount'];
        $date_time = $_POST['date_time'];

        // 1. purana proof nikal lo
        $query = "SELECT proof FROM debits WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldData = $result->fetch_assoc();
        $old_proof = $oldData['proof'];

        // 2. handle new file
        $proof_file = $old_proof; // default: purana hi rahe
        if (!empty($_FILES['proof']['name'])) {
            // agar new file aayi hai
            $target_dir = "debits/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $proof_file = $target_dir . time() . "_" . basename($_FILES["proof"]["name"]);

            if (move_uploaded_file($_FILES["proof"]["tmp_name"], $proof_file)) {
                // purana file delete
                if (!empty($old_proof) && file_exists($old_proof)) {
                    unlink($old_proof);
                }
            }
        }

        // 3. Update query
        $stmt = $conn->prepare("UPDATE debits SET invoice_for = ?, amount = ?, date_time = ?, proof = ? WHERE id = ?");
        $stmt->bind_param("sdssi", $invoice_for, $amount, $date_time, $proof_file, $id);

        if ($stmt->execute()) {
            // ✅ Set session message
            session_start();
            $_SESSION['success'] = "Debit updated successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error updating debit!";
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        }


    }
}





if (isset($_POST['add_credit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $credit_source = $_POST['credit_source'];
        $amount = $_POST['credit_amount'];
        $date_time = $_POST['credit_datetime'];
        $user_id = $_POST['user_id'];
        $trip_id = $_POST['trip_id'];

        // handle file upload
        $proof_file = null;
        if (!empty($_FILES['credit_proof']['name'])) {
            $target_dir = "credits/";  // changed folder name
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $proof_file = $target_dir . time() . "_" . basename($_FILES["credit_proof"]["name"]);
            move_uploaded_file($_FILES["credit_proof"]["tmp_name"], $proof_file);
        }

        // insert into debits table
        $stmt = $conn->prepare("INSERT INTO credits (trip_id,source, amount, date_time, proof,created_by) VALUES (?,?, ?, ?, ?,?)");
        $stmt->bind_param("dsdssd", $trip_id,$credit_source, $amount, $date_time, $proof_file,$user_id);

        if ($stmt->execute()) {
            // ✅ Set session message
            session_start();
            $_SESSION['success'] = "Credit Recorded successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error Recording Credit!";
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        }
    }
}


if (isset($_POST['edit_credit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];  
        $credit_source = $_POST['source'];
        $amount = $_POST['amount'];
        $date_time = $_POST['date_time'];

        // check if a new proof is uploaded
        if (!empty($_FILES['proof']['name'])) {
            $target_dir = "credits/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // fetch old proof
            $result = $conn->query("SELECT proof FROM credits WHERE id = '$id'");
            $old = $result->fetch_assoc();
            if (!empty($old['proof']) && file_exists($old['proof'])) {
                unlink($old['proof']); // delete old proof file
            }

            // upload new proof
            $proof_file = $target_dir . time() . "_" . basename($_FILES["proof"]["name"]);
            move_uploaded_file($_FILES["proof"]["tmp_name"], $proof_file);

            // update with new proof
            $stmt = $conn->prepare("UPDATE credits SET source=?, amount=?, date_time=?, proof=? WHERE id=?");
            $stmt->bind_param("sdssi", $credit_source, $amount, $date_time, $proof_file, $id);
        } else {
            // update without changing proof
            $stmt = $conn->prepare("UPDATE credits SET source=?, amount=?, date_time=? WHERE id=?");
            $stmt->bind_param("sdsi", $credit_source, $amount, $date_time, $id);
        }

         if ($stmt->execute()) {
            // ✅ Set session message
            session_start();
            $_SESSION['success'] = "Credit updated successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error updating Credit!";
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        }
    }
}




/* ================== DELETE CREDIT ================== */
if (isset($_POST['delete_credit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];

        

        // fetch proof file before deleting
        $result = $conn->query("SELECT proof FROM credits WHERE id = '$id'");
        $old = $result->fetch_assoc();
        if (!empty($old['proof']) && file_exists($old['proof'])) {
            unlink($old['proof']); // delete proof file
        }

        // delete record from DB
        $stmt = $conn->prepare("DELETE FROM credits WHERE id = ?");
        $stmt->bind_param("i", $id);

        
         if ($stmt->execute()) {
            // ✅ Set session message
            session_start();
            $_SESSION['success'] = "Credit Removed successfully!";

            // Redirect back to previous page
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        } else {
            session_start();
            $_SESSION['error'] = "Error Removing Credit!";
            $back = $_SERVER['HTTP_REFERER'] ?? 'trip_details.php';
            header("Location: $back");
            exit;
        }
    }
}


// new code starts here

if (isset($_POST['new_trip_from_landing_page'])) {
    $tripName = $_POST['tripName'];
    $startingPlace = $_POST['startingPlace'];
    $destination = $_POST['destination'];
    $tripType = $_POST['tripType'];
    $budget = $_POST['budget'];
    $people = $_POST['people'];
    echo $people;
    die;
}


if (isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = '❌ Passwords do not match. Please try again.';
            document.getElementById('errorMessage').innerText = errorMessage;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          });
        </script>";
        include('signup.php'); // reload signup page with modal
        exit();
    }

    $check_existing = "SELECT * FROM `users` WHERE `email`='$email'";
    $run_existing = mysqli_query($conn, $check_existing);

    if (mysqli_num_rows($run_existing) > 0) {
        // Email already exists
        echo "<script>
            alert('⚠️ This email is already registered. Please use another one.');
            window.history.back();
          </script>";
        exit();
    } else {
        $query_insert = "INSERT INTO `users`( `name`, `email`, `password`) VALUES ('$fullname','$email','$password')";
        $run_query = mysqli_query($conn, $query_insert);
        if ($run_query) {
            // Email already exists
            echo "
<script>
  window.location.href='login.php?signup_success=" . urlencode($fullname) . "';
</script>";
            exit();



        }
    }





}




if (isset($_POST['forget_password'])) {
    $email = $_POST['email'];

    $check_existing = "SELECT * FROM `users` WHERE `email`='$email'";
    $run_existing = mysqli_query($conn, $check_existing);

    if (mysqli_num_rows($run_existing) == 0) {
        // Email does not exist
        echo "
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('errorMessage').innerText = '❌ We could not find any account linked with current Email ID!';
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          });
        </script>";
        include('forget.php'); // Show the form again with modal
        exit();
    } else {

    }
    // Else: Email exists => Proceed to send reset link logic here (next step)
}




if (isset($_POST['login'])) {

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if user exists
    $check_login = "SELECT `id`, `name`, `password` FROM `users` WHERE `email`='$email' LIMIT 1";
    $run_login = mysqli_query($conn, $check_login);

    if (!$run_login) {
        // Query failed
        die("Database error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($run_login) > 0) {
        $row = mysqli_fetch_assoc($run_login);
        $user_id = $row['id'];
        $db_password = $row['password'];

        // ✅ Verify hashed password
        // if (password_verify($password, $db_password)) {
        if ($password == $db_password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $row['name'];

            echo "<script>
                    alert('✅ Login successful! Welcome back, {$row['name']}');
                    window.location.href='dashboard.php';
                  </script>";
            exit;
        } else {

            echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = '❌ Passwords do not match. Please try again.';
            document.getElementById('errorMessage').innerText = errorMessage;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          });
        </script>";
            include('login.php'); // reload signup page with modal
            exit();
        }
    } else {


        echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = '⚠️ No account found with this email. Please sign up first.';
            document.getElementById('errorMessage').innerText = errorMessage;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          });
        </script>";
        include('signup.php'); // reload signup page with modal
        exit();


    }
}




if (isset($_POST['new_trip'])) {
    $trip_name = $_POST['trip_name'];
    $source_state = $_POST['source_state'];
    $dest_state = $_POST['dest_state'];
    $start_date = $_POST['start_date'];
    $budget = $_POST['budget'];
    $people = $_POST['people'];
    $user_id = $_SESSION['user_id'];



    $insert_query = "INSERT INTO `trip`(`trip_name`, `source`, `destination`, `start_date`, `budget`, `people`,`created_by`) 
                     VALUES ('$trip_name','$source_state','$dest_state','$start_date','$budget','$people','$user_id')";
    $run_query = mysqli_query($conn, $insert_query);

    if ($run_query) {
        // ✅ store success message in session
        $_SESSION['success'] = "🎉 Trip created successfully!";
        header("Location: dashboard.php"); // redirect to dashboard
        exit();
    } else {
        // ✅ store error in session
        $_SESSION['error'] = "❌ Something went wrong. Please try again.";
        header("Location: create_trip.php"); // redirect back to form
        exit();
    }
}

// if(isset($_POST['new_trip']))
// {
//     $trip_name= $_POST['trip_name'];
//     $source_state= $_POST['source_state'];
//     $dest_state= $_POST['dest_state'];
//     $start_date= $_POST['start_date'];
//     $budget= $_POST['budget'];
//     $people= $_POST['people'];

//     $insert_query="INSERT INTO `trip`( `trip_name`, `source`, `destination`, `start_date`, `budget`, `people`) 
//     VALUES ('$trip_name','$source_state','$dest_state','$start_date','$budget','$people')";
//     $run_query=mysqli_query($conn,$insert_query);
//  if ($run_query) {
//     echo "
//     <script>
//       document.addEventListener('DOMContentLoaded', function() {
//         var successMessage = '🎉 Trip created successfully!';
//         document.getElementById('signupSuccessMessage').innerText = successMessage;
//         var successModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
//         successModal.show();
//       });
//     </script>";
//     include('dashboard.php'); // apni form wali file reload karna
//     exit();
// } else {
//     echo "
//     <script>
//       document.addEventListener('DOMContentLoaded', function() {
//         var errorMessage = '❌ Something went wrong. Please try again.';
//         document.getElementById('errorMessage').innerText = errorMessage;
//         var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
//         errorModal.show();
//       });
//     </script>";
//     include('create_trip.php');
//     exit();
// }
// }






?>