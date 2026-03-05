<?php
/**
 * Gmail SMTP Setup Helper
 * Helps configure Gmail App Password for contact form
 */

echo "<h1>Gmail SMTP Setup for Contact Form</h1>";

echo "<h2>Step 1: Enable 2-Factor Authentication</h2>";
echo "<p>If you haven't already:</p>";
echo "<ol>";
echo "<li>Go to <a href='https://myaccount.google.com/security' target='_blank'>Google Account Security</a></li>";
echo "<li>Enable 2-Step Verification</li>";
echo "</ol>";

echo "<h2>Step 2: Generate App Password</h2>";
echo "<ol>";
echo "<li>Go to <a href='https://myaccount.google.com/apppasswords' target='_blank'>App Passwords</a></li>";
echo "<li>Sign in if prompted</li>";
echo "<li>Select 'Mail' from the dropdown</li>";
echo "<li>Select your device or create a custom name (e.g., 'Portfolio Website')</li>";
echo "<li>Click 'Generate'</li>";
echo "<li><strong>Copy the 16-character password</strong> (ignore spaces)</li>";
echo "</ol>";

echo "<h2>Step 3: Configure Your Contact Form</h2>";
echo "<p>Edit the file <code>forms/email_config.php</code>:</p>";
echo "<pre>";
echo "// Find this line:
// 'password' => '',

// Replace with your App Password:
// 'password' => 'abcd-efgh-ijkl-mnop',</pre>";

echo "<h2>Step 4: Test</h2>";
echo "<p><a href='test_email.php'>Click here to test your email configuration</a></p>";

echo "<h2>Security Notes</h2>";
echo "<ul>";
echo "<li>App Passwords are specific to your Google account</li>";
echo "<li>You can revoke them anytime from your Google Account</li>";
echo "<li>They only allow sending emails, not accessing your Gmail</li>";
echo "</ul>";

echo "<p><a href='../index.html'>← Back to Portfolio</a></p>";
?></content>
<parameter name="filePath">c:\xampp\htdocs\BrianKingetichPortfolio\forms\setup_gmail.php