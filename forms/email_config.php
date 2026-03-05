<?php
/**
 * Email Configuration
 * Set your Gmail credentials here to enable SMTP email sending
 */

// Gmail SMTP Configuration
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'mochibrian10@gmail.com',
    'password' => 'cvbv pcpl dzyg ukcg', // <-- SET YOUR GMAIL APP PASSWORD HERE
    'encryption' => 'tls'
];

// Instructions:
// 1. Go to https://myaccount.google.com/apppasswords
// 2. Generate an App Password for "Mail"
// 3. Copy the 16-character password here
// 4. Save this file
//
// Example:
// 'password' => 'abcd-efgh-ijkl-mnop',

// Don't edit below this line
define('SMTP_CONFIG', $smtp_config);
?></content>
<parameter name="filePath">c:\xampp\htdocs\BrianKingetichPortfolio\forms\email_config.php