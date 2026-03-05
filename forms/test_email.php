<?php
/**
 * Email Configuration Test for XAMPP
 */

// Test email configuration
$to = 'mochibrian10@gmail.com';
$subject = 'Portfolio Contact Form Test';
$message = 'This is a test email from your portfolio contact form.';
$headers = 'From: Portfolio Test <test@portfolio.local>' . "\r\n" .
           'Reply-To: test@portfolio.local' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

echo "<h1>Email Configuration Test</h1>";
echo "<p>Testing email functionality...</p>";

// Try to send test email
if (@mail($to, $subject, $message, $headers)) {
    echo "<p style='color: green;'>✓ Email sent successfully to $to</p>";
} else {
    echo "<p style='color: red;'>✗ Email failed to send</p>";
    echo "<p><strong>To fix this:</strong></p>";
    echo "<ol>";
    echo "<li>Open XAMPP Control Panel</li>";
    echo "<li>Click 'Config' next to Apache</li>";
    echo "<li>Select 'PHP (php.ini)'</li>";
    echo "<li>Find the [mail function] section</li>";
    echo "<li>Update these settings:</li>";
    echo "</ol>";
    echo "<pre>";
    echo "SMTP = smtp.gmail.com\n";
    echo "smtp_port = 587\n";
    echo "sendmail_from = your-gmail@gmail.com\n";
    echo "sendmail_path = \"\\\"C:\\xampp\\sendmail\\sendmail.exe\\\" -t\"\n";
    echo "</pre>";
    echo "<p>Also configure sendmail.ini in C:\\xampp\\sendmail\\sendmail.ini</p>";
}

// Check if log file exists and show recent entries
$log_file = __DIR__ . '/email_log.txt';
if (file_exists($log_file)) {
    echo "<h2>Recent Email Logs</h2>";
    $logs = file_get_contents($log_file);
    $lines = explode("\n", $logs);
    $recent_lines = array_slice($lines, -20); // Last 20 lines
    echo "<pre>" . htmlspecialchars(implode("\n", $recent_lines)) . "</pre>";
} else {
    echo "<p>No email logs found yet.</p>";
}
?></content>
<parameter name="filePath">c:\xampp\htdocs\BrianKingetichPortfolio\forms\test_email.php