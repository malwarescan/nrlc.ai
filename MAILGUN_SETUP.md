# Mailgun Setup (No App Password Needed!)

**Gmail App Passwords isn't working? Use Mailgun instead - it's easier!**

## Why Mailgun is Better

- ✅ **5,000 emails/month FREE** (vs Gmail's complexity)
- ✅ **No App Passwords needed**
- ✅ **No 2-Step Verification required**
- ✅ **Just sign up and get API key**
- ✅ **Works immediately**

## Quick Setup (3 minutes)

### Step 1: Sign Up for Mailgun

1. Go to: https://www.mailgun.com
2. Click "Sign Up" (top right)
3. Enter your email and create account
4. **Verify your email** (check inbox)

### Step 2: Get SMTP Credentials

1. After login, go to **Sending** → **Domain Settings**
2. You'll see a **sandbox domain** (like `sandbox12345.mailgun.org`)
3. Click on it, then go to **SMTP credentials** tab
4. You'll see:
   - **SMTP Hostname:** `smtp.mailgun.org`
   - **Port:** `587`
   - **Username:** `postmaster@sandbox12345.mailgun.org` (your sandbox domain)
   - **Password:** (click "Reset Password" to generate one)

### Step 3: Update Railway Variables

Go to Railway → Your Service → Variables tab

**Delete old SendGrid/Gmail variables:**
- SMTP_HOST
- SMTP_PORT
- SMTP_USERNAME
- SMTP_PASSWORD

**Add these Mailgun variables:**
```
SMTP_HOST = smtp.mailgun.org
SMTP_PORT = 587
SMTP_USERNAME = postmaster@sandbox12345.mailgun.org (your actual sandbox domain)
SMTP_PASSWORD = your-mailgun-smtp-password (from Step 2)
SMTP_FROM_EMAIL = noreply@nrlc.ai
SMTP_FROM_NAME = NRLC.ai
```

**Important:**
- Replace `sandbox12345.mailgun.org` with YOUR actual sandbox domain
- Use the password from Mailgun dashboard (not your account password)

### Step 4: Test

1. Railway will redeploy automatically
2. Wait 1-2 minutes
3. Test booking form
4. ✅ Emails should work!

---

## Mailgun Free Tier Limits

- **5,000 emails/month** (plenty for booking forms!)
- **First 3 months:** 5,000 emails/month
- **After 3 months:** Still free, but may have some limits

---

## If You Need More Emails Later

Mailgun paid plans start at $35/month for 50,000 emails, but the free tier should be more than enough for booking forms.

---

## Why This Works Better Than Gmail

- ❌ No App Passwords (Gmail's App Passwords page is broken)
- ❌ No 2-Step Verification setup
- ✅ Just sign up, get credentials, done
- ✅ More reliable for transactional emails
- ✅ Better delivery rates
