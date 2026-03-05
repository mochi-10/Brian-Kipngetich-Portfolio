<?php
/**
 * SMTP Email Function for Gmail
 * Sends emails directly via Gmail SMTP
 */

function send_smtp_email($to, $subject, $message, $from_name, $from_email, $smtp_config = null) {
    // Default Gmail SMTP configuration
    if (!$smtp_config) {
        $smtp_config = [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'mochibrian10@gmail.com', // Your Gmail
            'password' => '', // Will be set via environment or config
            'encryption' => 'tls'
        ];
    }

    // If no password is set, fall back to file logging
    if (empty($smtp_config['password'])) {
        return false;
    }

    $socket = fsockopen($smtp_config['host'], $smtp_config['port'], $errno, $errstr, 30);
    if (!$socket) {
        return false;
    }

    // Read initial response
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '220')) {
        fclose($socket);
        return false;
    }

    // Send EHLO
    fputs($socket, "EHLO " . $smtp_config['host'] . "\r\n");
    $response = '';
    while ($line = fgets($socket, 515)) {
        $response .= $line;
        if (substr($line, 3, 1) == ' ') break;
    }

    // Start TLS if required
    if ($smtp_config['encryption'] == 'tls') {
        fputs($socket, "STARTTLS\r\n");
        $response = fgets($socket, 515);
        if (!smtp_check_response($response, '220')) {
            fclose($socket);
            return false;
        }

        // Enable crypto
        stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
    }

    // Send EHLO again after TLS
    fputs($socket, "EHLO " . $smtp_config['host'] . "\r\n");
    $response = '';
    while ($line = fgets($socket, 515)) {
        $response .= $line;
        if (substr($line, 3, 1) == ' ') break;
    }

    // Authenticate
    fputs($socket, "AUTH LOGIN\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '334')) {
        fclose($socket);
        return false;
    }

    // Send username (base64 encoded)
    fputs($socket, base64_encode($smtp_config['username']) . "\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '334')) {
        fclose($socket);
        return false;
    }

    // Send password (base64 encoded)
    fputs($socket, base64_encode($smtp_config['password']) . "\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '235')) {
        fclose($socket);
        return false;
    }

    // Send MAIL FROM
    fputs($socket, "MAIL FROM:<{$from_email}>\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '250')) {
        fclose($socket);
        return false;
    }

    // Send RCPT TO
    fputs($socket, "RCPT TO:<{$to}>\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '250')) {
        fclose($socket);
        return false;
    }

    // Send DATA
    fputs($socket, "DATA\r\n");
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '354')) {
        fclose($socket);
        return false;
    }

    // Send email content
    $email_content = "From: {$from_name} <{$from_email}>\r\n";
    $email_content .= "To: {$to}\r\n";
    $email_content .= "Subject: {$subject}\r\n";
    $email_content .= "MIME-Version: 1.0\r\n";
    $email_content .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $email_content .= "\r\n";
    $email_content .= $message;
    $email_content .= "\r\n.\r\n";

    fputs($socket, $email_content);

    // Check response
    $response = fgets($socket, 515);
    if (!smtp_check_response($response, '250')) {
        fclose($socket);
        return false;
    }

    // Send QUIT
    fputs($socket, "QUIT\r\n");
    fgets($socket, 515);

    fclose($socket);
    return true;
}

function smtp_check_response($response, $expected_code) {
    return substr($response, 0, 3) == $expected_code;
}
?></content>
<parameter name="filePath">c:\xampp\htdocs\BrianKingetichPortfolio\forms\smtp_mail.php