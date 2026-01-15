# Email Configuration for Booking Form

The booking form requires SMTP configuration to send emails. PHP's `mail()` function doesn't work on Railway without proper SMTP setup.

## Option 1: Gmail SMTP (Recommended for Quick Setup)

1. Create a Gmail App Password:
   - Go to https://myaccount.google.com/apppasswords
   - Generate an app password for "Mail"
   - Copy the 16-character password

2. Set Railway Environment Variables:
   ```
   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_USERNAME=your-email@gmail.com
   SMTP_PASSWORD=your-16-char-app-password
   SMTP_FROM_EMAIL=noreply@nrlc.ai
   SMTP_FROM_NAME=NRLC.ai
   ```

## Option 2: SendGrid (Recommended for Production)

1. Sign up for SendGrid (free tier: 100 emails/day)
2. Create an API key
3. Set Railway Environment Variables:
   ```
   SMTP_HOST=smtp.sendgrid.net
   SMTP_PORT=587
   SMTP_USERNAME=apikey
   SMTP_PASSWORD=your-sendgrid-api-key
   SMTP_FROM_EMAIL=noreply@nrlc.ai
   SMTP_FROM_NAME=NRLC.ai
   ```

## Option 3: Mailgun

1. Sign up for Mailgun (free tier: 5,000 emails/month)
2. Get SMTP credentials from Mailgun dashboard
3. Set Railway Environment Variables:
   ```
   SMTP_HOST=smtp.mailgun.org
   SMTP_PORT=587
   SMTP_USERNAME=your-mailgun-username
   SMTP_PASSWORD=your-mailgun-password
   SMTP_FROM_EMAIL=noreply@nrlc.ai
   SMTP_FROM_NAME=NRLC.ai
   ```

## Testing

After setting environment variables, test the booking form. Emails will be sent to:
- **Team notification**: info@neuralcommandllc.com
- **User confirmation**: The email address submitted in the form

## Troubleshooting

If emails still don't send:
1. Check Railway logs for SMTP connection errors
2. Verify environment variables are set correctly
3. Test SMTP credentials using a mail client
4. Check spam/junk folders
