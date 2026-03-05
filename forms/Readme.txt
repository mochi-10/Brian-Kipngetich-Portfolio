CONTACT FORM CONFIGURATION
==========================

Your contact form is now working! Here's how it handles submissions:

1. **Production Server**: Emails are sent directly to mochibrian10@gmail.com
2. **Local Development (XAMPP)**: Emails are logged to email_log.txt file

TO ENABLE REAL EMAIL SENDING IN XAMPP:
=====================================

1. Open XAMPP Control Panel
2. Click "Config" next to Apache
3. Select "PHP (php.ini)"
4. Find the [mail function] section and update:

   SMTP = smtp.gmail.com
   smtp_port = 587
   sendmail_from = your-gmail@gmail.com
   sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

5. Save and restart Apache

6. Configure C:\xampp\sendmail\sendmail.ini:
   [sendmail]
   smtp_server=smtp.gmail.com
   smtp_port=587
   smtp_ssl=tls
   auth_username=your-gmail@gmail.com
   auth_password=your-app-password

   Note: Use Gmail App Password, not your regular password!
   Generate one at: https://myaccount.google.com/apppasswords

TEST YOUR SETUP:
===============
Visit: http://localhost/BrianKingetichPortfolio/forms/test_email.php

This will test your email configuration and show recent logs.

ALTERNATIVE: Use a service like SendGrid, Mailgun, or Formspree for reliable email delivery on any hosting.

Fully working PHP/AJAX contact form script is available in the pro version of the template.
You can buy it from: https://bootstrapmade.com/snapfolio-bootstrap-portfolio-template/