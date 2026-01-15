# Switch from SendGrid to Gmail SMTP

**Your SendGrid trial ended, so we need to switch to Gmail.**

## Quick Setup (5 minutes)

### Step 1: Enable 2-Step Verification on Gmail

1. Go to: https://myaccount.google.com/security
2. Click "2-Step Verification"
3. Follow setup (you'll need your phone)
4. Complete the setup

### Step 2: Get Gmail App Password

1. Go to: https://myaccount.google.com/apppasswords
2. Select "Mail" and "Other (Custom name)"
3. Enter: "NRLC Booking Form"
4. Click "Generate"
5. **Copy the 16-character password** (looks like: `abcd efgh ijkl mnop`)

### Step 3: Update Railway Variables

Go to Railway → Your Service → Variables tab

**Delete these SendGrid variables:**
- SMTP_HOST
- SMTP_PORT
- SMTP_USERNAME
- SMTP_PASSWORD

**Add these Gmail variables:**
```
SMTP_HOST = smtp.gmail.com
SMTP_PORT = 587
SMTP_USERNAME = neuralcommand@gmail.com
SMTP_PASSWORD = abcd efgh ijkl mnop (paste your 16-char app password)
SMTP_FROM_EMAIL = neuralcommand@gmail.com
SMTP_FROM_NAME = NRLC.ai
```

**Important:**
- Use the exact Gmail address that has 2-Step Verification enabled
- Paste the app password exactly as shown (spaces are OK)
- Railway will redeploy automatically

### Step 4: Test

1. Wait 1-2 minutes for Railway to redeploy
2. Test the booking form
3. Emails should now send! ✅

---

## Why Gmail Works

- ✅ Free forever
- ✅ No trial period
- ✅ 500 emails/day limit (plenty for booking forms)
- ✅ Works immediately after setup
- ✅ Reliable delivery

---

## Alternative: Mailgun (If Gmail Doesn't Work)

If you prefer not to use Gmail, Mailgun offers 5,000 emails/month free:

1. Sign up at https://www.mailgun.com
2. Verify your email
3. Get SMTP credentials from dashboard
4. Update Railway variables with Mailgun SMTP settings

But Gmail is easier and faster to set up!
