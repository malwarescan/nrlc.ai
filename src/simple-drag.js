// SNAP SFX + PARTICLES + FLASH
let __audioCtx;
function getAudioCtx() {
  if (__audioCtx && __audioCtx.state !== "closed") return __audioCtx;
  __audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  return __audioCtx;
}

function playSnapSound({ volume = 0.08, dur = 0.12 } = {}) {
  try {
    const ctx = getAudioCtx();
    if (ctx.state === "suspended") ctx.resume();

    const now = ctx.currentTime;

    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    const filter = ctx.createBiquadFilter();

    filter.type = "lowpass";
    filter.frequency.setValueAtTime(1600, now);
    filter.frequency.exponentialRampToValueAtTime(600, now + dur);

    osc.type = "sine";
    osc.frequency.setValueAtTime(880, now);
    osc.frequency.exponentialRampToValueAtTime(420, now + dur);

    gain.gain.setValueAtTime(0.0001, now);
    gain.gain.exponentialRampToValueAtTime(volume, now + 0.01);
    gain.gain.exponentialRampToValueAtTime(0.0001, now + dur);

    osc.connect(filter);
    filter.connect(gain);
    gain.connect(ctx.destination);

    osc.start(now);
    osc.stop(now + dur + 0.02);
  } catch {}
}

// ---- Visual flash on snap ----
function snapFlash(cardEl) {
  if (!cardEl) return;
  cardEl.classList.add("snap-flash");
  window.setTimeout(() => cardEl.classList.remove("snap-flash"), 220);
}

// Inject CSS once (no build step)
(function injectSnapStylesOnce() {
  if (document.getElementById("snap-effects-css")) return;
  const css = document.createElement("style");
  css.id = "snap-effects-css";
  css.textContent = `
    .snap-flash {
      outline: 1px solid rgba(64, 255, 255, 0.35);
      box-shadow: 0 0 0 1px rgba(64,255,255,0.15), 0 0 36px rgba(64,255,255,0.12);
      transition: outline 220ms ease, box-shadow 220ms ease;
    }
    .snap-particle {
      position: absolute;
      width: 3px;
      height: 3px;
      border-radius: 999px;
      background: rgba(120, 255, 255, 0.95);
      pointer-events: none;
      will-change: transform, opacity;
      z-index: 9999;
      filter: drop-shadow(0 0 6px rgba(120,255,255,0.45));
    }
  `;
  document.head.appendChild(css);
})();

// ---- Particles (corner burst in card-local space) ----
function spawnSnapParticles(cardEl, { perCorner = 6, lifetime = 600 } = {}) {
  if (!cardEl) return;

  // Ensure we can position particles relative to the card
  const prevPos = getComputedStyle(cardEl).position;
  if (prevPos === "static") cardEl.style.position = "relative";

  const w = cardEl.offsetWidth;
  const h = cardEl.offsetHeight;

  const corners = [
    { x: 10, y: 10 },
    { x: w - 10, y: 10 },
    { x: 10, y: h - 10 },
    { x: w - 10, y: h - 10 }
  ];

  const created = [];

  corners.forEach((c) => {
    for (let i = 0; i < perCorner; i++) {
      const p = document.createElement("div");
      p.className = "snap-particle";
      p.style.left = `${c.x}px`;
      p.style.top = `${c.y}px`;
      p.style.opacity = "1";
      cardEl.appendChild(p);
      created.push(p);

      // Burst vector: mostly upward, slightly outward
      const angle = (-Math.PI / 2) + (Math.random() - 0.5) * 1.0; // around up
      const speed = 40 + Math.random() * 70; // px
      const dx = Math.cos(angle) * speed + (c.x < w / 2 ? -10 : 10);
      const dy = Math.sin(angle) * speed;

      // Animate with WAAPI if available
      if (p.animate) {
        p.animate(
          [
            { transform: "translate3d(0,0,0) scale(1)", opacity: 1 },
            { transform: `translate3d(${dx}px, ${dy}px, 0) scale(0.8)`, opacity: 0 }
          ],
          { duration: lifetime, easing: "cubic-bezier(.2,.8,.2,1)", fill: "forwards" }
        );
      } else {
        // Fallback: simple timeout removal
        p.style.transform = `translate3d(${dx}px, ${dy}px, 0) scale(0.8)`;
        p.style.opacity = "0";
      }
    }
  });

  window.setTimeout(() => {
    created.forEach((el) => el.remove());
    // Restore position style only if we changed it
    if (prevPos === "static") cardEl.style.position = "";
  }, lifetime + 40);
}

// ---- One call for all snap effects ----
function triggerSnapEffects(cardEl) {
  playSnapSound();
  snapFlash(cardEl);
  spawnSnapParticles(cardEl);
}

// iOS audio context resume
window.addEventListener("pointerdown", () => { try { getAudioCtx().resume(); } catch {} }, { once: true });

// Premium Drag + Snap System with 12 Polish Items
document.addEventListener('DOMContentLoaded', () => {
  const leftCard = document.getElementById('left-card');
  const rightCard = document.getElementById('right-card');
  
  if (!leftCard || !rightCard) {
    console.log('Cards not found');
    return;
  }
  
  console.log('Cards found, setting up premium drag');
  
  // CONFIGURATION
  const GRID_SIZE = 32;
  const STORAGE_VERSION = 'layout_v1';
  const PARALLAX_MAX = {
    grid: 14,
    stars: 10,
    fog: 6
  };
  
  let isDragging = false;
  let currentCard = null;
  let startX = 0;
  let startY = 0;
  let cardStartX = 0;
  let cardStartY = 0;
  let hasMoved = false;
  let parallaxEnabled = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  
  // HELPER FUNCTIONS
  function isMobileViewport() {
    return window.innerWidth < 1024;
  }
  
  function snapToGrid(value) {
    return Math.round(value / GRID_SIZE) * GRID_SIZE;
  }
  
  function clampCardToContainer(x, y, card, containerRect, padding) {
    const maxX = containerRect.width - card.offsetWidth - padding * 2;
    const maxY = containerRect.height - card.offsetHeight - padding * 2;
    
    return {
      x: Math.max(padding, Math.min(x, maxX)),
      y: Math.max(padding, Math.min(y, maxY))
    };
  }
  
  // CARD STATE
  const cardsState = {
    left: { x: 0, y: 0, el: leftCard },
    right: { x: 0, y: 0, el: rightCard }
  };
  
  // CONTAINER
  const container = document.querySelector('.max-w-6xl') || document.querySelector('.w-full');
  
  // DEFAULT POSITIONS (RANDOM NEAR TOP)
function computeDefaultPositions(cardEls, containerEl) {
  const rect = containerEl.getBoundingClientRect();
  const mobile = isMobileViewport();

  const gap = mobile ? 24 : 32;
  const pad = mobile ? 16 : 32;
  const topZoneRatio = 0.3; // Spawn in top 30% of container

  // Read sizes once
  const sizes = cardEls.map((el) => ({
    el,
    w: el.offsetWidth,
    h: el.offsetHeight,
  }));

  const positions = {};

  // Maximum Y position (top 30% of container)
  const maxY = Math.floor((rect.height * topZoneRatio) - pad);
  const maxX = rect.width - pad;

  sizes.forEach((s, index) => {
    let attempts = 0;
    let validPosition = false;
    let x, y;

    // Try to find non-overlapping position
    while (!validPosition && attempts < 50) {
      x = Math.floor(Math.random() * (maxX - s.w)) + pad;
      y = Math.floor(Math.random() * (maxY - s.h)) + pad;

      validPosition = true;

      // Check overlap with already positioned cards
      for (const existingId of Object.keys(positions)) {
        const existing = positions[existingId];
        const overlap = 
          x < existing.x + existing.w &&
          x + s.w > existing.x &&
          y < existing.y + existing.h &&
          y + s.h > existing.y;

        if (overlap) {
          validPosition = false;
          break;
        }
      }

      attempts++;
    }

    // If no valid position found, just place it randomly
    if (!validPosition) {
      x = Math.floor(Math.random() * (maxX - s.w)) + pad;
      y = Math.floor(Math.random() * (maxY - s.h)) + pad;
    }

    positions[s.el.dataset.cardId] = {
      x: snapToGrid(x),
      y: snapToGrid(y),
    };
  });

  return positions;
}

// APPLY ON INIT / RESET
function initPositions(cardsState, cardEls, containerEl) {
  const saved = loadLayout(containerEl);

  if (saved) {
    // Apply saved but clamp just in case
    const rect = containerEl.getBoundingClientRect();
    cardEls.forEach((el) => {
      const id = el.dataset.cardId;
      if (!id || !saved[id]) return;

      const clamped = clampCardToContainer(saved[id].x, saved[id].y, el, rect, 16);
      cardsState[id].x = snapToGrid(clamped.x);
      cardsState[id].y = snapToGrid(clamped.y);
    });
    return;
  }

  const defaults = computeDefaultPositions(cardEls, containerEl);
  Object.keys(defaults).forEach((id) => {
    if (!cardsState[id]) return;
    cardsState[id].x = defaults[id].x;
    cardsState[id].y = defaults[id].y;
  });

  // Save immediately so refresh stays correct
  saveLayout();
}

// INITIALIZE POSITIONS
  console.log('Initializing positions for cards...');
  initPositions(cardsState, [leftCard, rightCard], container);
  
  // APPLY POSITIONS TO CARDS
  function applyPositions() {
    console.log('Applying positions to cards...');
    Object.keys(cardsState).forEach(id => {
      const card = cardsState[id];
      console.log(`Setting position for ${id}: x=${card.x}, y=${card.y}`);
      card.el.style.position = 'absolute';
      card.el.style.transform = `translate3d(${card.x}px, ${card.y}px, 0)`;
      
      // Make logo card (left) prominent with higher z-index
      if (id === 'left') {
        card.el.style.zIndex = '10';
      } else {
        card.el.style.zIndex = '5';
      }
    });
  }
  
  applyPositions();
  
  // INITIALIZE DRAG SYSTEM
  makeDraggable(leftCard);
  makeDraggable(rightCard);
  
  function applyGridLayout(layout) {
    if (!layout) {
      layout = computeDefaultPositions([leftCard, rightCard], container);
    }
    
    // Convert grid units to pixels or apply direct positions
    if (layout.left && layout.right) {
      const leftX = layout.left.col * 32;
      const leftY = layout.left.row * 32;
      const rightX = layout.right.col * 32;
      const rightY = layout.right.row * 32;
      
      // Apply positions with animation
      leftCard.style.position = 'absolute';
      leftCard.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      leftCard.style.transform = `translate3d(${leftX}px, ${leftY}px, 0)`;
      
      rightCard.style.position = 'absolute';
      rightCard.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      rightCard.style.transform = `translate3d(${rightX}px, ${rightY}px, 0)`;
      
      // Remove transitions after animation
      setTimeout(() => {
        leftCard.style.transition = '';
        rightCard.style.transition = '';
      }, 600);
    }
  }
  
  // HERO CONTAINER BOUNDS (with soft boundaries)
  function clampToHeroBounds(x, y, card) {
    const gridContainer = document.querySelector('.max-w-6xl');
    const gridRect = gridContainer.getBoundingClientRect();
    const cardWidth = card.offsetWidth;
    const cardHeight = card.offsetHeight;
    
    // Allow cards to go partially off-screen but not completely
    const maxOffscreen = cardWidth * 0.8; // Allow 80% off-screen
    
    let finalX = x;
    let finalY = y;
    
    // Soft left boundary - allow partial off-screen
    if (x < -maxOffscreen) {
      finalX = -maxOffscreen; // Don't let it go completely off
    }
    // Soft right boundary - allow partial off-screen  
    else if (x + cardWidth > gridRect.width + maxOffscreen) {
      finalX = gridRect.width + maxOffscreen - cardWidth;
    }
    
    // Soft top boundary - allow partial off-screen
    if (y < -maxOffscreen) {
      finalY = -maxOffscreen;
    }
    // Soft bottom boundary - allow partial off-screen
    else if (y + cardHeight > gridRect.height + maxOffscreen) {
      finalY = gridRect.height + maxOffscreen - cardHeight;
    }
    
    return { x: finalX, y: finalY };
  }
  
  // AESTHETIC COLLISION RESOLUTION
  function resolveCollision(card, x, y) {
    const otherCard = card === leftCard ? rightCard : leftCard;
    const otherRect = otherCard.getBoundingClientRect();
    const cardRect = card.getBoundingClientRect();
    
    // Allow aesthetic overlap - only prevent complete covering
    const buffer = 20; // 20px buffer for aesthetic overlap
    const isOverlappingTooMuch = 
      x < otherRect.right - otherRect.width + buffer &&
      x + cardRect.width > otherRect.left - buffer &&
      y < otherRect.bottom - otherRect.height + buffer &&
      y + cardRect.height > otherRect.top - buffer;
    
    if (!isOverlappingTooMuch) {
      // Allow aesthetic overlap - keep snapped position
      return { x, y };
    }
    
    // Only move if completely covering other card
    // Search in consistent order: right, down, left, up
    const positions = [
      { x: otherRect.right + buffer/2, y: y }, // right with small gap
      { x: x, y: otherRect.bottom + buffer/2 }, // down with small gap
      { x: otherRect.left - cardRect.width - buffer/2, y: y }, // left with small gap (allow negative)
      { x: x, y: otherRect.top - cardRect.height - buffer/2 } // up with small gap (allow negative)
    ];
    
    for (const pos of positions) {
      const bounced = clampToHeroBounds(pos.x, pos.y, card);
      return bounced; // Return first valid position
    }
    
    // Keep original position if no valid spot
    return { x, y };
  }
  
  // VERSIONED STORAGE
  function saveLayout() {
    const gridContainer = document.querySelector('.max-w-6xl');
    
    // Get ACTUAL current positions from both cards
    const leftRect = leftCard.getBoundingClientRect();
    const rightRect = rightCard.getBoundingClientRect();
    const parentRect = leftCard.parentElement.getBoundingClientRect();
    
    const leftX = leftRect.left - parentRect.left;
    const leftY = leftRect.top - parentRect.top;
    const rightX = rightRect.left - parentRect.left;
    const rightY = rightRect.top - parentRect.top;
    
    const layout = {
      version: STORAGE_VERSION,
      left: {
        col: Math.round(leftX / 32),
        row: Math.round(leftY / 32)
      },
      right: {
        col: Math.round(rightX / 32),
        row: Math.round(rightY / 32)
      }
    };
    
    localStorage.setItem('heroGridLayout', JSON.stringify(layout));
  }
  
  function loadLayout() {
    const savedLayout = localStorage.getItem('heroGridLayout');
    
    if (savedLayout) {
      try {
        const layout = JSON.parse(savedLayout);
        
        // Check version
        if (layout.version !== STORAGE_VERSION) {
          return null;
        }
        
        return layout;
      } catch (e) {
        return null;
      }
    }
    
    return null;
  }
  
  // PARALLAX WITH CAPS AND LERP
  function setupParallax() {
    if (!parallaxEnabled) return;

    const gridPoints = document.querySelector('.grid-points');
    const starsLayer = document.querySelector('.stars-layer');
    const fogLayer = document.querySelector('.fog-layer');

    let mouseX = 0;
    let mouseY = 0;
    let currentX = 0;
    let currentY = 0;

    document.addEventListener('mousemove', (e) => {
      if (!isDragging) {
        mouseX = e.clientX;
        mouseY = e.clientY;
      }
    });

    const animate = () => {
      if (parallaxEnabled) {
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;
        
        const deltaX = (mouseX - centerX) / centerX;
        const deltaY = (mouseY - centerY) / centerY;

        // Lerp for smooth lag
        const lerp = 0.08;
        currentX += (deltaX - currentX) * lerp;
        currentY += (deltaY - currentY) * lerp;

        // Clamp movement to small ranges
        if (gridPoints) {
          const moveX = Math.max(-PARALLAX_MAX.grid, Math.min(PARALLAX_MAX.grid, currentX * PARALLAX_MAX.grid));
          const moveY = Math.max(-PARALLAX_MAX.grid, Math.min(PARALLAX_MAX.grid, currentY * PARALLAX_MAX.grid));
          gridPoints.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
        
        if (starsLayer) {
          const moveX = Math.max(-PARALLAX_MAX.stars, Math.min(PARALLAX_MAX.stars, currentX * PARALLAX_MAX.stars));
          const moveY = Math.max(-PARALLAX_MAX.stars, Math.min(PARALLAX_MAX.stars, currentY * PARALLAX_MAX.stars));
          starsLayer.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
        
        if (fogLayer) {
          const moveX = Math.max(-PARALLAX_MAX.fog, Math.min(PARALLAX_MAX.fog, currentX * PARALLAX_MAX.fog));
          const moveY = Math.max(-PARALLAX_MAX.fog, Math.min(PARALLAX_MAX.fog, currentY * PARALLAX_MAX.fog));
          fogLayer.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
      }

      requestAnimationFrame(animate);
    };

    animate();
  }
  
  // CLICK VS DRAG THRESHOLD
  function makeDraggable(card) {
    const handle = card.querySelector('.drag-handle');
    if (!handle) {
      console.log('No handle found for card', card.id);
      return;
    }
    
    console.log('Setting up drag for card:', card.id, 'handle:', handle);
    
    handle.addEventListener('mousedown', (e) => {
      console.log('Mouse down on handle for card:', card.id);
      e.preventDefault();
      e.stopPropagation();
      
      isDragging = false;
      hasMoved = false;
      currentCard = card;
      
      startX = e.clientX;
      startY = e.clientY;
      
      const rect = card.getBoundingClientRect();
      const parentRect = card.parentElement.getBoundingClientRect();
      
      cardStartX = rect.left - parentRect.left;
      cardStartY = rect.top - parentRect.top;
      
      // Add drag state
      card.style.position = 'absolute';
      card.style.zIndex = '1000';
      card.style.transition = 'none';
      card.style.boxShadow = '0 0 30px rgba(0, 194, 255, 0.6), 0 0 60px rgba(0, 194, 255, 0.3), 0 25px 50px -12px rgba(0, 0, 0, 0.5)';
      card.style.border = '2px solid rgba(0, 194, 255, 0.8)';
      card.style.transform = `translate3d(${cardStartX}px, ${cardStartY}px, 0) scale(1.02)`;
      
      // Show grid overlay with fast fade
      const gridOverlay = document.getElementById('grid-overlay');
      if (gridOverlay) {
        gridOverlay.style.transition = 'opacity 120ms ease-in';
        gridOverlay.style.opacity = '1';
      }
      
      document.addEventListener('mousemove', onMouseMove);
      document.addEventListener('mouseup', onMouseUp);
      
      // PREVENT SCROLLING ON MOBILE
      document.body.style.overflow = 'hidden';
      document.body.style.touchAction = 'none';
    });
    
    // ADD TOUCH EVENTS FOR MOBILE
    handle.addEventListener('touchstart', (e) => {
      e.preventDefault();
      e.stopPropagation();
      
      isDragging = false;
      hasMoved = false;
      currentCard = card;
      
      const touch = e.touches[0];
      startX = touch.clientX;
      startY = touch.clientY;
      
      const rect = card.getBoundingClientRect();
      const parentRect = card.parentElement.getBoundingClientRect();
      
      cardStartX = rect.left - parentRect.left;
      cardStartY = rect.top - parentRect.top;
      
      // Add drag state
      card.style.position = 'absolute';
      card.style.zIndex = '1000';
      card.style.transition = 'none';
      card.style.boxShadow = '0 0 30px rgba(0, 194, 255, 0.6), 0 0 60px rgba(0, 194, 255, 0.3), 0 25px 50px -12px rgba(0, 0, 0, 0.5)';
      card.style.border = '2px solid rgba(0, 194, 255, 0.8)';
      card.style.transform = `translate3d(${cardStartX}px, ${cardStartY}px, 0) scale(1.02)`;
      
      // Show grid overlay with fast fade
      const gridOverlay = document.getElementById('grid-overlay');
      if (gridOverlay) {
        gridOverlay.style.transition = 'opacity 120ms ease-in';
        gridOverlay.style.opacity = '1';
      }
      
      document.addEventListener('touchmove', onTouchMove, { passive: false });
      document.addEventListener('touchend', onTouchEnd);
      
      // PREVENT SCROLLING ON MOBILE
      document.body.style.overflow = 'hidden';
      document.body.style.touchAction = 'none';
    });
  }
  
  function onTouchMove(e) {
    if (!isDragging && !hasMoved) {
      // Check threshold (4-6px)
      const touch = e.touches[0];
      const deltaX = Math.abs(touch.clientX - startX);
      const deltaY = Math.abs(touch.clientY - startY);
      
      if (deltaX > 5 || deltaY > 5) {
        isDragging = true;
        hasMoved = true;
      }
    }
    
    if (!isDragging) return;
    
    e.preventDefault(); // PREVENT SCROLLING
    
    const touch = e.touches[0];
    const deltaX = touch.clientX - startX;
    const deltaY = touch.clientY - startY;
    
    const newX = cardStartX + deltaX;
    const newY = cardStartY + deltaY;
    
    currentCard.style.transform = `translate3d(${newX}px, ${newY}px, 0) scale(1.02)`;
  }
  
  function onTouchEnd(e) {
    // ALWAYS stop dragging on touch end
    isDragging = false;
    
    if (!hasMoved) {
      // Normal tap, no drag
      cleanup();
      return;
    }
    
    // Remove drag state
    currentCard.style.zIndex = '';
    currentCard.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)'; // Smooth elastic snap
    currentCard.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.5)';
    currentCard.style.border = '';
    
    // Hide grid overlay with slower fade
    const gridOverlay = document.getElementById('grid-overlay');
    if (gridOverlay) {
      gridOverlay.style.transition = 'opacity 300ms ease-out';
      gridOverlay.style.opacity = '0';
    }
    
    // GET CURRENT POSITION
    const rect = currentCard.getBoundingClientRect();
    const parentRect = currentCard.parentElement.getBoundingClientRect();
    
    let x = rect.left - parentRect.left;
    let y = rect.top - parentRect.top;
    
    // SNAP TO GRID
    const snappedX = Math.round(x / GRID_SIZE) * GRID_SIZE;
    const snappedY = Math.round(y / GRID_SIZE) * GRID_SIZE;
    
    // Check if actually snapped
    const didSnap = Math.abs(x - snappedX) > 2 || Math.abs(y - snappedY) > 2;
    
    // ONLY resolve collisions if cards are actually overlapping
    const finalPos = resolveCollision(currentCard, snappedX, snappedY);
    
    // Apply final position and KEEP IT
    currentCard.style.transform = `translate3d(${finalPos.x}px, ${finalPos.y}px, 0) scale(1)`;
    
    // Update card state
    const cardId = currentCard.dataset.cardId;
    if (cardId && cardsState[cardId]) {
      cardsState[cardId].x = finalPos.x;
      cardsState[cardId].y = finalPos.y;
    }
    
    // Save layout IMMEDIATELY
    saveLayout();
    
    // TRIGGER SNAP EFFECTS
    triggerSnapEffects(currentCard);
  }
  
  function onMouseMove(e) {
    if (!isDragging && !hasMoved) {
      // Check threshold (4-6px)
      const deltaX = Math.abs(e.clientX - startX);
      const deltaY = Math.abs(e.clientY - startY);
      
      if (deltaX > 5 || deltaY > 5) {
        isDragging = true;
        hasMoved = true;
      }
    }
    
    if (!isDragging) return;
    
    e.preventDefault();
    
    const deltaX = e.clientX - startX;
    const deltaY = e.clientY - startY;
    
    const newX = cardStartX + deltaX;
    const newY = cardStartY + deltaY;
    
    currentCard.style.transform = `translate3d(${newX}px, ${newY}px, 0) scale(1.02)`;
  }
  
  function onMouseUp(e) {
    // ALWAYS stop dragging on mouse up
    isDragging = false;
    
    if (!hasMoved) {
      // Normal click, no drag
      cleanup();
      return;
    }
    
    // Remove drag state
    currentCard.style.zIndex = '';
    currentCard.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)'; // Smooth elastic snap
    currentCard.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.5)';
    currentCard.style.border = '';
    
    // Hide grid overlay with slower fade
    const gridOverlay = document.getElementById('grid-overlay');
    if (gridOverlay) {
      gridOverlay.style.transition = 'opacity 300ms ease-out';
      gridOverlay.style.opacity = '0';
    }
    
    // GET CURRENT POSITION
    const rect = currentCard.getBoundingClientRect();
    const parentRect = currentCard.parentElement.getBoundingClientRect();
    
    let x = rect.left - parentRect.left;
    let y = rect.top - parentRect.top;
    
    // SNAP TO GRID
    const snappedX = Math.round(x / GRID_SIZE) * GRID_SIZE;
    const snappedY = Math.round(y / GRID_SIZE) * GRID_SIZE;
    
    // Check if actually snapped
    const didSnap = Math.abs(x - snappedX) > 2 || Math.abs(y - snappedY) > 2;
    
    // ONLY resolve collisions if cards are actually overlapping
    const finalPos = resolveCollision(currentCard, snappedX, snappedY);
    
    // Apply final position and KEEP IT
    currentCard.style.transform = `translate3d(${finalPos.x}px, ${finalPos.y}px, 0) scale(1)`;
    
    // Update start positions for persistence IMMEDIATELY
    cardStartX = finalPos.x;
    cardStartY = finalPos.y;
    
    // Update card state
    const cardId = currentCard.dataset.cardId;
    if (cardId && cardsState[cardId]) {
      cardsState[cardId].x = finalPos.x;
      cardsState[cardId].y = finalPos.y;
    }
    
    // Save layout IMMEDIATELY
    saveLayout();
    
    // TRIGGER SNAP EFFECTS
    triggerSnapEffects(currentCard);
    
    // CLEANUP TO STOP ALL MOUSE TRACKING
    cleanup();
  }
  
  function cleanup() {
    // PROPERLY remove all event listeners
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);
    document.removeEventListener('touchmove', onTouchMove);
    document.removeEventListener('touchend', onTouchEnd);
    
    if (currentCard) {
      currentCard.releasePointerCapture?.(event.pointerId);
    }
    
    // RESET ALL STATE
    isDragging = false;
    currentCard = null;
    hasMoved = false;
    startX = 0;
    startY = 0;
    
    // RESTORE SCROLLING ON MOBILE
    document.body.style.overflow = '';
    document.body.style.touchAction = '';
  }
  
  // RESIZE BEHAVIOR
  function setupResizeHandler() {
    let resizeTimeout;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        // Recompute and clamp positions
        const leftRect = leftCard.getBoundingClientRect();
        const rightRect = rightCard.getBoundingClientRect();
        const parentRect = leftCard.parentElement.getBoundingClientRect();
        
        let leftX = leftRect.left - parentRect.left;
        let leftY = leftRect.top - parentRect.top;
        let rightX = rightRect.left - parentRect.left;
        let rightY = rightRect.top - parentRect.top;
        
        // Clamp to bounds
        const leftClamped = clampToHeroBounds(leftX, leftY, leftCard);
        const rightClamped = clampToHeroBounds(rightX, rightY, rightCard);
        
        // Apply clamped positions
        leftCard.style.transition = 'all 0.2s ease';
        rightCard.style.transition = 'all 0.2s ease';
        
        leftCard.style.transform = `translate3d(${leftClamped.x}px, ${leftClamped.y}px, 0)`;
        rightCard.style.transform = `translate3d(${rightClamped.x}px, ${rightClamped.y}px, 0)`;
        
        setTimeout(() => {
          leftCard.style.transition = '';
          rightCard.style.transition = '';
        }, 200);
        
        saveLayout();
      }, 250);
    });
  }
  
  // RESET BUTTON (PRODUCT FEEL)
  function setupResetButton() {
    const existingReset = document.querySelector('.reset-layout');
    if (existingReset) existingReset.remove();

    const resetBtn = document.createElement('button');
    resetBtn.className = 'reset-layout absolute top-4 right-4 text-xs font-mono text-[#00C2FF]/60 hover:text-[#00C2FF] transition-colors';
    resetBtn.textContent = 'Reset layout';
    resetBtn.addEventListener('click', () => {
      localStorage.removeItem('heroGridLayout');
      
      // Quick fade/slide back to defaults
      leftCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
      rightCard.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
      
      applyGridLayout(null);
    });

    const heroSection = document.querySelector('section');
    heroSection.appendChild(resetBtn);
  }
  
  // PARTICLE AND SOUND EFFECTS
  function createSnapParticles(card) {
    try {
      const particlesContainer = card.querySelector('.snap-particles');
      if (!particlesContainer) {
        console.log('No particles container found');
        return;
      }
      
      // Prevent double spawns
      if (particlesContainer.dataset.animating === 'true') {
        return;
      }
      particlesContainer.dataset.animating = 'true';
      
      // Clear existing particles
      particlesContainer.innerHTML = '';
      
      // Get card bounds for coordinate conversion (if needed)
      const cardRect = card.getBoundingClientRect();
      
      // Create particles at corners in CARD SPACE
      // NOTE: corner.x/corner.y are CARD-LOCAL coordinates (relative to card's top-left)
      // This is correct because we use card.offsetWidth/offsetHeight which are card-local
      const corners = [
        { x: 10, y: 10 },
        { x: card.offsetWidth - 10, y: 10 },
        { x: 10, y: card.offsetHeight - 10 },
        { x: card.offsetWidth - 10, y: card.offsetHeight - 10 }
      ];
      
      corners.forEach((corner, index) => {
        setTimeout(() => {
          for (let i = 0; i < 6; i++) {
            const particle = document.createElement('div');
            particle.className = 'absolute w-1 h-1 bg-[#00C2FF] rounded-full';
            particle.style.boxShadow = '0 0 6px #00C2FF';
            particle.style.transition = 'all 0.6s ease-out';
            
            // SPAWN HIGHER: subtract 15px from Y
            const spawnY = corner.y - 15;
            particle.style.left = corner.x + 'px';
            particle.style.top = spawnY + 'px';
            
            // Add to card container
            particlesContainer.appendChild(particle);
            
            // BIAS UPWARD: shift angle range to favor upward burst
            setTimeout(() => {
              // Bias angle upward: use range -π/3 to -2π/3 (120° upward range)
              const baseAngle = -Math.PI / 2; // Straight up
              const spread = Math.PI / 3; // 60° spread
              const angle = baseAngle + (Math.random() - 0.5) * spread;
              
              const distance = 20 + Math.random() * 20;
              const x = Math.cos(angle) * distance;
              const y = Math.sin(angle) * distance; // Already biased upward
              
              particle.style.transform = `translate(${x}px, ${y}px) scale(0)`;
              particle.style.opacity = '0';
            }, 10);
            
            // Remove particle after animation
            setTimeout(() => {
              if (particle.parentNode) {
                particle.remove();
              }
            }, 600);
          }
        }, index * 50);
      });
      
      // Reset animation flag
      setTimeout(() => {
        particlesContainer.dataset.animating = 'false';
      }, 1000);
      
    } catch (e) {
      console.log('Particle effect failed:', e);
    }
  }
  
  function playSnapSound() {
    try {
      // Create audio context on first use
      if (!window.audioContext) {
        window.audioContext = new (window.AudioContext || window.webkitAudioContext)();
      }
      
      const audioContext = window.audioContext;
      const oscillator = audioContext.createOscillator();
      const gainNode = audioContext.createGain();
      
      oscillator.connect(gainNode);
      gainNode.connect(audioContext.destination);
      
      oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
      oscillator.frequency.exponentialRampToValueAtTime(400, audioContext.currentTime + 0.1);
      
      gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
      gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
      
      oscillator.start(audioContext.currentTime);
      oscillator.stop(audioContext.currentTime + 0.1);
    } catch (e) {
      console.log('Audio playback failed:', e);
    }
  }
  
  // INITIALIZE
  loadLayout();
  setupParallax();
  setupResizeHandler();
  setupResetButton();
  
  // Make both cards draggable
  makeDraggable(leftCard);
  makeDraggable(rightCard);
});
