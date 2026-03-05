CONTACT FORM CONFIGURATION
==========================

Your contact form now sends emails directly to Gmail! Here's how it works:

1. **SMTP Configured**: Emails sent directly to mochibrian10@gmail.com via Gmail SMTP
2. **No SMTP Config**: Emails logged to email_log.txt file
3. **Fallback**: If SMTP fails, messages are still logged

TO ENABLE GMAIL SMTP EMAIL SENDING:
===================================

1. **Generate Gmail App Password**:
   - Go to: https://myaccount.google.com/apppasswords
   - Sign in with mochibrian10@gmail.com
   - Select "Mail" as the app
   - Select your device (or create custom name)
   - Copy the 16-character password

2. **Configure Email Settings**:
   - Open `forms/email_config.php`
   - Find: `'password' => '',`
   - Replace with: `'password' => 'your-16-char-app-password',`
   - Save the file

3. **Test Your Setup**:
   - Visit: http://localhost/BrianKingetichPortfolio/forms/test_email.php
   - Should show "✓ Email sent successfully via SMTP"

SECURITY NOTES:
==============
- App Passwords are specific to your Google account
- They provide access only to Gmail sending
- You can revoke them anytime from Google Account settings
- Never share your App Password

TROUBLESHOOTING:
================
- If SMTP fails: Check your App Password is correct
- If still failing: Verify 2-factor authentication is enabled on Gmail
- Test page will show detailed status

Fully working PHP/AJAX contact form script is available in the pro version of the template.
You can buy it from: https://bootstrapmade.com/snapfolio-bootstrap-portfolio-template/