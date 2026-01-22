<!-- Navigation Menu -->
<div class="fixed top-4 left-4 z-50">
  <!-- Plus Icon Button -->
  <button id="nav-toggle" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-[#0A0A0A] hover:bg-[#F8F8F8] transition-colors duration-200 group" aria-label="Toggle menu">
    <svg id="plus-icon" class="w-5 h-5 text-[#0A0A0A] transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    <svg id="close-icon" class="w-5 h-5 text-[#0A0A0A] transition-transform duration-200 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
  </button>

  <!-- Navigation Menu Overlay -->
  <div id="nav-menu" class="absolute top-12 left-0 bg-white border-2 border-[#0A0A0A] shadow-lg hidden w-48">
    <nav class="p-4 space-y-2">
      <a href="index.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
        Home
      </a>
      <?php
      // Check if user is authenticated
      $isAuth = false;
      $user = null;
      if (file_exists(__DIR__ . '/../lib/auth.php')) {
        require_once __DIR__ . '/../lib/auth.php';
        if (initSecureSession() && isAuthenticated()) {
          $isAuth = true;
          $user = getCurrentUser();
        }
      }
      ?>
      <?php if ($isAuth): ?>
        <a href="dashboard.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
          Dashboard
        </a>
        <?php if ($user && $user['role'] === 'admin'): ?>
          <a href="admin.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
            Admin
          </a>
        <?php endif; ?>
        <a href="logout.php" class="block px-4 py-2 text-red-600 font-medium hover:bg-red-50 transition-colors duration-200">
          Logout
        </a>
      <?php else: ?>
        <a href="login.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
          Login
        </a>
      <?php endif; ?>
      <a href="understand.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
        Understand
      </a>
      <a href="get-started.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
        Get Started
      </a>
      <a href="docs.php" class="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200">
        Documentation
      </a>
    </nav>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const toggleButton = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  const plusIcon = document.getElementById('plus-icon');
  const closeIcon = document.getElementById('close-icon');

  toggleButton.addEventListener('click', function() {
    const isOpen = !navMenu.classList.contains('hidden');
    
    if (isOpen) {
      // Close menu
      navMenu.classList.add('hidden');
      plusIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    } else {
      // Open menu
      navMenu.classList.remove('hidden');
      plusIcon.classList.add('hidden');
      closeIcon.classList.remove('hidden');
    }
  });

  // Close menu when clicking outside
  document.addEventListener('click', function(event) {
    const isClickInside = toggleButton.contains(event.target) || navMenu.contains(event.target);
    if (!isClickInside && !navMenu.classList.contains('hidden')) {
      navMenu.classList.add('hidden');
      plusIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });
});
</script>

