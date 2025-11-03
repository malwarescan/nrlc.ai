(function(){
  const reduced = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // Create and inject background layer
  const bg = document.createElement("div");
  bg.className = "enhance-bg";
  document.body.prepend(bg);

  // Set background hue
  const setBg = (h, overlay) => {
    document.documentElement.style.setProperty("--bg-h", String(h));
    document.documentElement.style.setProperty("--bg-overlay", String(overlay));
  };

  // Intersection observer for reveals
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) e.target.classList.add("is-inview");
    });
  }, { rootMargin: "0px 0px -10% 0px", threshold: 0.12 });

  // Apply reveal classes to content elements without changing DOM structure
  document.querySelectorAll("h1, h2, h3, p, li, figure, img, .btn, .box-padding").forEach(n => {
    n.classList.add("enhance-reveal");
    io.observe(n);
  });

  if (reduced) {
    setBg(220, 0);
    return;
  }

  // Get sections by their stable selectors
  const getSections = () => {
    const windows = Array.from(document.querySelectorAll(".window"));
    return {
      hero: windows[0] || null, // First hero window
      goldmine: windows[1] || null, // Goldmine window
      services: windows[2] || null, // Core Services window
      geo16: windows[3] || null, // GEO-16 window
      insights: windows[4] || null, // Latest Insights window
      opensource: windows[5] || null, // Open-Source window
      faq: windows[6] || null, // FAQ window
      cta: document.querySelector(".center.margin-top-20.box-padding") || null
    };
  };

  const sections = getSections();

  // Scroll handler for background animation
  const onScroll = () => {
    const hero = sections.hero;
    if (hero) {
      const r = hero.getBoundingClientRect();
      const vh = window.innerHeight || 1;
      const t = Math.min(1, Math.max(0, (vh - r.top) / (vh + Math.max(r.height, vh*0.4))));
      setBg(220 + 40*t, 0.2*t);
    }

    // Simple stagger reveals for other sections
    Object.values(sections).forEach((section, i) => {
      if (!section) return;
      const r = section.getBoundingClientRect();
      if (r.top < window.innerHeight * 0.8 && r.bottom > 0) {
        // Add slight delay based on section index
        setTimeout(() => {
          section.classList.add("is-inview");
        }, i * 100);
      }
    });
  };

  // Initial call and scroll listener
  onScroll();
  document.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("resize", onScroll);
})();
