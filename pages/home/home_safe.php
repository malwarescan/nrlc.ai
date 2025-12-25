<?php
/**
 * SAFE FALLBACK HOMEPAGE
 * 
 * This file MUST ALWAYS return HTTP 200.
 * Contains static HTML only - no helpers, no AI logic, no optional dependencies.
 * Used as fallback when main homepage fails.
 */

// Force 200 status
http_response_code(200);
header('Content-Type: text/html; charset=UTF-8');

// Determine canonical URL safely
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'nrlc.ai';
$canonicalUrl = "$protocol://$host";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI SEO & AI Visibility Services | NRLC.ai</title>
    <meta name="description" content="Professional AI SEO and AI visibility services. We help businesses improve search rankings and AI-generated answer eligibility across Google AI Overviews and ChatGPT.">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <link rel="stylesheet" href="/assets/css/w3c-functional.css">
</head>
<body>
    <main role="main" style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <header>
            <h1>AI SEO & AI Visibility Services</h1>
            <p style="font-size: 1.2rem; margin-top: 1rem;">We help brands turn search authority into AI citations across Google AI Overviews, ChatGPT, and emerging answer engines.</p>
        </header>
        
        <section style="margin-top: 3rem;">
            <h2>Professional AI SEO Services</h2>
            <p>Neural Command provides AI SEO and AI visibility services for businesses that need real improvements in search rankings and AI-generated answer eligibility.</p>
            <p>Led by Joel Maldonado - 20+ years in search, structured data, and algorithmic visibility.</p>
            <p>Serving companies across the United States and United Kingdom.</p>
        </section>
        
        <section style="margin-top: 3rem;">
            <h2>Contact</h2>
            <p>Email: hirejoelm@gmail.com</p>
            <p>Phone: +1-844-568-4624</p>
        </section>
        
        <footer style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #ddd;">
            <p>&copy; <?= date('Y') ?> Neural Command LLC. All rights reserved.</p>
        </footer>
    </main>
</body>
</html>

