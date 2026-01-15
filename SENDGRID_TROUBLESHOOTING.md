# SendGrid "Maximum Credits Exceeded" Fix

## The Problem

Your logs show:
```
Password authentication failed: 451 Authentication failed: Maximum credits exceeded
```

This means SendGrid is rejecting emails because:
1. **Free tier limit hit** (100 emails/day)
2. **Account not verified** (need to verify email)
3. **Account suspended** (check SendGrid dashboard)

## Quick Fixes

### Option 1: Verify SendGrid Account

1. Go to https://app.sendgrid.com
2. Check for verification emails
3. Verify your email address
4. Check account status in dashboard

### Option 2: Check Email Usage

1. Go to SendGrid Dashboard → Activity
2. Check if you've sent 100+ emails today
3. Free tier resets daily at midnight UTC

### Option 3: Upgrade SendGrid Plan

If you need more than 100 emails/day:
1. Go to SendGrid → Settings → Billing
2. Upgrade to a paid plan (starts at $15/month for 40,000 emails)

### Option 4: Use Gmail Instead (Temporary)

If SendGrid is blocked, switch to Gmail:

1. Enable 2-Step Verification on Gmail
2. Get App Password
3. Update Railway variables:
   ```
   SMTP_HOST = smtp.gmail.com
   SMTP_PORT = 587
   SMTP_USERNAME = neuralcommand@gmail.com
   SMTP_PASSWORD = your-gmail-app-password
   SMTP_FROM_EMAIL = noreply@nrlc.ai
   SMTP_FROM_NAME = NRLC.ai
   ```

### Option 5: Use Mailgun (Alternative)

Mailgun offers 5,000 emails/month free:

1. Sign up at https://www.mailgun.com
2. Verify domain or use sandbox
3. Get SMTP credentials
4. Update Railway variables:
   ```
   SMTP_HOST = smtp.mailgun.org
   SMTP_PORT = 587
   SMTP_USERNAME = postmaster@your-domain.mailgun.org
   SMTP_PASSWORD = your-mailgun-password
   SMTP_FROM_EMAIL = noreply@nrlc.ai
   SMTP_FROM_NAME = NRLC.ai
   ```

## Most Likely Issue

**SendGrid account needs email verification.** Check your email inbox for a verification email from SendGrid and click the verification link.
