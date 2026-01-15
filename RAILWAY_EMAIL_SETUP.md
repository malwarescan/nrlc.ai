# Quick Email Setup for Railway

**The booking form emails won't work until you configure SMTP in Railway.**

## ✅ Yes, You Can Use Gmail!

**Important:** You can use ANY Gmail account to send emails. Gmail is just the sending service - you can send emails TO any email address (like `info@neuralcommand.com`), even if that address isn't on Google.

**Example:**
- Use Gmail account: `hirejoelm@gmail.com` (or any Gmail)
- Send emails TO: `info@neuralcommand.com` ✅ (works fine!)
- Send emails TO: Any email address ✅ (works fine!)

## ⚡ Quick Setup (5 minutes)

### Step 1: Get Gmail App Password

1. Go to: https://myaccount.google.com/apppasswords
2. Sign in with **any Gmail account** (yours, company Gmail, etc.)
3. Select "Mail" and "Other (Custom name)"
4. Enter: "NRLC Booking Form"
5. Click "Generate"
6. **Copy the 16-character password** (you'll need this)

### Step 2: Add Environment Variables in Railway

1. Go to your Railway project dashboard
2. Click on your service
3. Go to the **Variables** tab
4. Click **+ New Variable** for each of these:

```
SMTP_HOST = smtp.gmail.com
SMTP_PORT = 587
SMTP_USERNAME = your-email@gmail.com
SMTP_PASSWORD = xxxx xxxx xxxx xxxx (the 16-char app password)
SMTP_FROM_EMAIL = noreply@nrlc.ai
SMTP_FROM_NAME = NRLC.ai
```

**Example Configuration:**
```
SMTP_HOST = smtp.gmail.com
SMTP_PORT = 587
SMTP_USERNAME = neuralcommand@gmail.com
SMTP_PASSWORD = xxxx xxxx xxxx xxxx (the 16-char app password)
SMTP_FROM_EMAIL = noreply@nrlc.ai
SMTP_FROM_NAME = NRLC.ai
```

**Important:** 
- You can use **any Gmail address** (like `neuralcommand@gmail.com`, `hirejoelm@gmail.com`, etc.)
- Replace `xxxx xxxx xxxx xxxx` with the 16-character app password from that Gmail account
- The Gmail account is just for sending - emails will go TO `info@neuralcommand.com` (or any address)

### Step 3: Redeploy

Railway will automatically redeploy when you add variables. Wait 1-2 minutes.

### Step 4: Test

Submit a test booking form. Emails should now send to:
- **Team**: info@neuralcommandllc.com
- **User**: The email they entered in the form

---

## 🔍 Troubleshooting

**Emails still not sending?**

1. **Check Railway logs:**
   - Go to Railway → Your Service → Deployments → Latest → View Logs
   - Look for SMTP errors

2. **Verify variables are set:**
   - Railway → Variables tab
   - Make sure all 6 variables are there
   - No typos in variable names

3. **Test SMTP connection:**
   - Run: `php scripts/test_email.php` (if you have SSH access)
   - Or check Railway logs for connection errors

4. **Common issues:**
   - ❌ Using regular Gmail password instead of App Password
   - ❌ Wrong SMTP_HOST (should be `smtp.gmail.com`)
   - ❌ Wrong SMTP_PORT (should be `587`)
   - ❌ Variables not saved (check Railway Variables tab)

---

## 📧 Alternative: Use SendGrid (More Reliable)

If Gmail doesn't work, SendGrid is more reliable for production:

1. Sign up at https://sendgrid.com (free tier: 100 emails/day)
2. Create API key in SendGrid dashboard
3. Set Railway variables:
   ```
   SMTP_HOST = smtp.sendgrid.net
   SMTP_PORT = 587
   SMTP_USERNAME = apikey
   SMTP_PASSWORD = your-sendgrid-api-key
   SMTP_FROM_EMAIL = noreply@nrlc.ai
   SMTP_FROM_NAME = NRLC.ai
   ```

---

## ✅ Success Indicators

When it's working, you'll see:
- ✅ Email notification to team: ✓ Sent
- ✅ Confirmation email to you: ✓ Sent

And you'll receive emails at:
- info@neuralcommandllc.com (team notification)
- The email address submitted in the form (confirmation)
