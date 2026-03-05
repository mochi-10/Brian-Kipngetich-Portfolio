<?php
/**
 * Email Configuration Test for XAMPP
 */

// Include SMTP functions and config
require_once 'smtp_mail.php';
require_once 'email_config.php';

// Test email configuration
$to = 'mochibrian10@gmail.com';
$subject = 'Portfolio Contact Form Test';
$message = 'This is a test email from your portfolio contact form.';
$from_name = 'Portfolio Test';
$from_email = 'test@portfolio.local';

echo "<h1>Email Configuration Test</h1>";
echo "<p>Testing email functionality...</p>";

// Try to send test email
$smtp_config = SMTP_CONFIG;
if (!empty($smtp_config['password'])) {
    // Test SMTP
    if (send_smtp_email($to, $subject, $message, $from_name, $from_email, $smtp_config)) {
        echo "<p style='color: green;'>✓ Email sent successfully via SMTP to $to</p>";
    } else {
        echo "<p style='color: red;'>✗ SMTP email failed</p>";
    }
} else {
    // Test PHP mail
    if (@mail($to, $subject, $message, "From: $from_name <$from_email>")) {
        echo "<p style='color: green;'>✓ Email sent successfully via PHP mail() to $to</p>";
    } else {
        echo "<p style='color: red;'>✗ PHP mail() failed</p>";
    }
}

echo "<h2>SMTP Configuration Status</h2>";
if (!empty($smtp_config['password'])) {
    echo "<p style='color: green;'>✓ SMTP is configured with Gmail</p>";
    echo "<p><strong>Note:</strong> Make sure you've generated an App Password from Google Account settings</p>";
} else {
    echo "<p style='color: orange;'>⚠ SMTP not configured - using PHP mail() or file logging</p>";
    echo "<p>To enable Gmail SMTP:</p>";
    echo "<ol>";
    echo "<li>Go to <a href='https://myaccount.google.com/apppasswords' target='_blank'>Google App Passwords</a></li>";
    echo "<li>Generate a password for 'Mail'</li>";
    echo "<li>Edit <code>forms/email_config.php</code> and set the password</li>";
    echo "</ol>";
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