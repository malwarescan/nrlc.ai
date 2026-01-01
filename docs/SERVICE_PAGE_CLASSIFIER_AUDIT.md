# Service Page Classifier Audit (Line-by-Line)

Use this audit on every `/services/*` page. If any line fails, the page is not classifiable and will underperform.

---

## A. URL + Intent Lock

- ✅ URL matches exactly one service (no blended services)
- ✅ Slug is plain and commercial (no manifesto language)
- ✅ Canonical is self-referencing and stable

**FAIL IF:** the page could rank for more than one service intent.

---

## B. `<title>` (Classification Gate)

**Required structure:**

```
{Primary Service Name} for Businesses | Neural Command LLC
```

- ✅ Contains a known service phrase
- ✅ Contains "for Businesses" or equivalent buyer qualifier
- ✅ Contains company name

**FAIL IF:** title sounds like research, philosophy, or tooling.

---

## C. Meta Description (Vendor Confirmation)

**Required content:**
- ✅ Explicit service offer
- ✅ Explicit audience
- ✅ Explicit outcome
- ✅ Neutral, factual tone

**Example pattern:**

```
Neural Command LLC provides {service} for businesses to {outcome}. Get a technical assessment and implementation plan.
```

**FAIL IF:** description reads like thought leadership.

---

## D. Above-the-Fold Block (Hard Requirement)

Must appear before any scrolling:

1. **H1** - Plain service name. No metaphors.
2. **Definition sentence (1 line)** - "Neural Command LLC provides {service} for businesses."
3. **Who it's for** - One sentence. Explicit buyer.
4. **What it fixes** - One sentence. Concrete problem.
5. **Cost of inaction** - One sentence. Loss, risk, or missed opportunity.
6. **Primary CTA button** - Service-specific. Not generic "Contact".

**FAIL IF:** a human cannot classify the business in under 3 seconds.

---

## E. Proof Block (Above Mid-Page)

Must include at least one of the following (two preferred):
- ✅ Metrics (even anonymized)
- ✅ Before/after artifacts
- ✅ Case-style breakdown (problem → action → result)

**FAIL IF:** page relies only on claims.

---

## F. Scope Definition ("What We Do")
- ✅ 6–12 bullets
- ✅ Each bullet = concrete action or deliverable
- ✅ No abstract language

**FAIL IF:** bullets describe philosophy instead of actions.

---

## G. Engagement Flow
- ✅ 3–5 steps max
- ✅ Describes what the client experiences
- ✅ Mentions inputs required from client

**FAIL IF:** process is unclear or implied.

---

## H. Pricing Context

One of the following must exist:
- ✅ Starting price
- ✅ Range bands
- ✅ Engagement model + constraints

**FAIL IF:** pricing context is entirely absent.

---

## I. CTA Closure
- ✅ One primary CTA
- ✅ CTA references the service name
- ✅ CTA repeats on page end

**FAIL IF:** multiple competing CTAs exist.

---

## J. Structured Data Verification
- ✅ Exactly one Organization entity sitewide
- ✅ Service schema present on page
- ✅ Service → provider references Organization @id
- ✅ No LocalBusiness schema

**FAIL IF:** schema introduces ambiguity.

---

## Usage

Run this audit on every service page before launch and during reviews. Any failing item must be fixed before the page goes live.


