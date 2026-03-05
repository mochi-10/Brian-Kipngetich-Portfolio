<?php
/**
 * Contact Form Handler for Portfolio Website
 * 
 * This script processes contact form submissions and sends emails
 * 
 * @package Portfolio
 * @author Your Name
 * @version 1.0
 */

// Configuration
error_reporting(E_ALL);
ini_set('display_errors', 0);  // Suppress display for AJAX responses

// Include SMTP functions and config
require_once 'smtp_mail.php';
require_once 'email_config.php';

// Constants
define('RECEIVING_EMAIL', 'mochibrian10@gmail.com');
define('SITE_URL', '/'); // Change this to your site URL

/**
 * Sanitize input data
 * 
 * @param string $data Raw input data
 * @return string Sanitized data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate email address
 * 
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Prepare email content
 * 
 * @param array $formData Form submission data
 * @return string Formatted email content
 */
function prepare_email_content($formData) {
    $content = "You have received a new message from your portfolio website:\n\n";
    $content .= "Name: {$formData['name']}\n";
    $content .= "Email: {$formData['email']}\n";
    
    if (!empty($formData['phone'])) {
        $content .= "Phone: {$formData['phone']}\n";
    }
    
    $content .= "Subject: {$formData['subject']}\n";
    $content .= "Message:\n{$formData['message']}\n";
    
    return $content;
}

// Check if this is an AJAX request
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Initialize response
$response_message = 'There was a problem sending your message. Please try again.';
$response_status = 'error';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and collect form data
    $formData = [
        'name' => isset($_POST['name']) ? sanitize_input($_POST['name']) : '',
        'email' => isset($_POST['email']) ? sanitize_input($_POST['email']) : '',
        'subject' => isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '',
        'phone' => isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '',
        'message' => isset($_POST['message']) ? sanitize_input($_POST['message']) : ''
    ];
    
    // Validate required fields
    $errors = [];
    
    if (empty($formData['name'])) {
        $errors[] = 'Name is required';
    }
    
    if (empty($formData['email'])) {
        $errors[] = 'Email is required';
    } elseif (!validate_email($formData['email'])) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($formData['subject'])) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($formData['message'])) {
        $errors[] = 'Message is required';
    }
    
    // Process if no errors
    if (empty($errors)) {
        
        // Prepare email
        $email_content = prepare_email_content($formData);
        $email_subject = "Portfolio Contact: {$formData['subject']}";
        
        // Email headers
        $headers = [
            "From: {$formData['name']} <{$formData['email']}>",
            "Reply-To: {$formData['email']}",
            "X-Mailer: PHP/" . phpversion()
        ];
        
        // Try to send email via SMTP first
        $smtp_config = SMTP_CONFIG;
        if (!empty($smtp_config['password'])) {
            // Use SMTP if password is configured
            $email_sent = send_smtp_email(
                RECEIVING_EMAIL,
                $email_subject,
                $email_content,
                $formData['name'],
                $formData['email'],
                $smtp_config
            );
        } else {
            // Fall back to PHP mail() function
            $email_sent = @mail(RECEIVING_EMAIL, $email_subject, $email_content, implode("\r\n", $headers));
        }

        // If email sending fails, log to file
        if (!$email_sent) {
            $log_file = dirname(__FILE__) . '/email_log.txt';
            $log_entry = "\n\n" . str_repeat("=", 80) . "\n";
            $log_entry .= "Date: " . date('Y-m-d H:i:s') . "\n";
            $log_entry .= "From: {$formData['name']} <{$formData['email']}>\n";
            $log_entry .= "To: " . RECEIVING_EMAIL . "\n";
            $log_entry .= "Subject: {$email_subject}\n";
            $log_entry .= str_repeat("-", 80) . "\n";
            $log_entry .= $email_content;

            file_put_contents($log_file, $log_entry, FILE_APPEND);

            if (!empty($smtp_config['password'])) {
                // SMTP configured but failed
                $response_status = 'error';
                $response_message = 'Failed to send email. Please check SMTP configuration.';
            } else {
                // No SMTP configured, logged for review
                $response_status = 'success';
                $response_message = 'Thank you for your message! (Email logged for review - check forms/email_log.txt)';
            }
        } else {
            $response_status = 'success';
            $response_message = 'Thank you for your message. We will get back to you soon!';
        }
        
    } else {
        $response_message = implode("<br>", $errors);
    }
    
    // Return response
    if ($is_ajax) {
        // For AJAX requests, return plain text OK or error message
        if ($response_status === 'success') {
            echo 'OK';
        } else {
            echo $response_message;
        }
        exit;
    }
}

// Only output HTML for non-AJAX requests and GET requests
if (!$is_ajax && $_SERVER["REQUEST_METHOD"] == "POST") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission - Portfolio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .message-container {
            max-width: 500px;
            width: 100%;
        }
        
        .message-box {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }
        
        .success, .error {
            animation: slideIn 0.5s ease-out;
        }
        
        .success h2 {
            color: #28a745;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .error h2 {
            color: #dc3545;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .message-box p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 16px;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108,117,125,0.3);
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 480px) {
            .message-box {
                padding: 30px 20px;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="message-box">
            <div class="<?php echo htmlspecialchars($response_status); ?>">
                <h2>
                    <?php echo $response_status == 'success' ? '✓ Success!' : '✗ Error!'; ?>
                </h2>
                <p><?php echo $response_message; ?></p>
                <div class="actions">
                    <a href="javascript:history.back()" class="btn btn-secondary">← Go Back</a>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Return to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    exit;
}
?>