<?php
// 👇 Make sure these variables are defined before using
$title = "My Awesome Post";
$subtitle = "This is a great post that talks about amazing things.";

$to = 'kshitiz.ranchi@gmail.com';
$subject = "📰 New Post Alert: $title";

// Email body
$message = "
<html>
<head>
    <title>New Post Found</title>
    <style>
        .image-link {
            display: inline-block;
            width: 100%;
            max-width: 100%;
        }
        .responsive-img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <center style='background-color:#eaf1fb; border-radius:20px; padding:20px; background-color: lightblue; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);'>
        <img src='https://thetechindia.in/assets/imgs/logo/mylogo.png' alt='Logo' width='120' style='margin-bottom: 10px;'>
        <h2>Baba ji ki Jai ho!!!</h2>
        <h3>New Post Found: <strong>" . htmlspecialchars($title) . "</strong></h3>
        
        <div style='background-color:yellow; padding:12px 20px; border-radius:10px; margin: 20px 0;'>
            <h4>Post Details:</h4>
            <p><strong>Subtitle:</strong> " . nl2br(htmlspecialchars($subtitle)) . "</p>
        </div>

        <p>If you did not request this, please ignore this email.</p>
    </center>
</body>
</html>
";

// Headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: MyBills App <kshitiz@thetechindia.in>\r\n";

// ✅ Send the email
if (mail($to, $subject, $message, $headers)) {
    echo "✅ Mail sent successfully!";
} else {
    echo "❌ Failed to send mail.";
}
?>
