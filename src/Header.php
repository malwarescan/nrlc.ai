<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo (isset($pageTitle) && $pageTitle !== '') ? $pageTitle . ' - Croutons.ai' : 'Croutons.ai - The Micro-Fact Protocol'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="src/index.css">
    
<!-- PHP Test: <?php echo "PHP_WORKING"; ?> -->
    
<!-- OG Meta Tags -->
<link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES); ?>" />

<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES); ?>" />
<meta property="og:url" content="<?php echo htmlspecialchars($canonical, ENT_QUOTES); ?>" />
<meta property="og:title" content="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" />
<meta property="og:description" content="<?php echo htmlspecialchars($description, ENT_QUOTES); ?>" />
<meta property="og:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES); ?>" />
<meta property="og:image:secure_url" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES); ?>" />
<meta property="og:image:type" content="<?php echo htmlspecialchars($imageType, ENT_QUOTES); ?>" />
<meta property="og:image:width" content="<?php echo htmlspecialchars($imageWidth, ENT_QUOTES); ?>" />
<meta property="og:image:height" content="<?php echo htmlspecialchars($imageHeight, ENT_QUOTES); ?>" />
<meta property="og:image:alt" content="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" />
<meta name="twitter:description" content="<?php echo htmlspecialchars($description, ENT_QUOTES); ?>" />
<meta name="twitter:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES); ?>" />
  </head>
  <body>
    <?php include 'src/components/Navigation.php'; ?>
    
    <!-- Show Croutons Hero only on homepage -->
    <?php if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php'): ?>
      <?php include 'src/components/CroutonsHero.php'; ?>
    <?php else: ?>
      <div class="w-full min-h-screen bg-[#F8F8F8]">
    <?php endif; ?>

