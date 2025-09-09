<?php
session_start();
if(!$_SESSION['user_id'])
{
     echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = '🙄 Your Login expires, Please Login again!.';
            document.getElementById('errorMessage').innerText = errorMessage;
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
          });
        </script>";
            include('login.php'); // reload signup page with modal
            exit();
}
$user_id= $_SESSION['user_id'];
$user_name= $_SESSION['name'];

?>