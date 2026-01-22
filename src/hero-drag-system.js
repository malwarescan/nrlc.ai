// Premium Drag + Snap System with Parallax
class HeroDragSystem {
  constructor() {
    this.GRID_SIZE = 32;
    this.SNAP_THRESHOLD = 12;
    this.DRAG_THRESHOLD = 6; // pixels before drag starts
    this.STORAGE_VERSION = 'layout_v1';
    this.PARALLAX_MAX = {
      grid: 14,
      stars: 10,
      fog: 6
    };
    
    this.isDragging = false;
    this.currentElement = null;
    this.startX = 0;
    this.startY = 0;
    this.elementStartX = 0;
    this.elementStartY = 0;
    this.hasMoved = false;
    this.parallaxEnabled = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    this.isMobile = window.innerWidth < 1024;
    
    this.init();
  }

  init() {
    if (this.isMobile) return;
    
    this.setupDragHandles();
    this.setupParallax();
    this.loadLayout();
    this.setupResetButton();
    this.setupResizeHandler();
  }

  setupDragHandles() {
    const handles = document.querySelectorAll('.drag-handle');
    console.log('Found drag handles:', handles.length);
    
    handles.forEach((handle, index) => {
      console.log('Setting up handle', index, handle.dataset.draggable);
      
      // Add grip icon to handles
      const gripIcon = document.createElement('span');
      gripIcon.className = 'grip-icon text-[#00C2FF]/40 text-xs mr-2 select-none pointer-events-none';
      gripIcon.textContent = '⋮⋮';
      gripIcon.style.cssText = 'font-size: 10px; letter-spacing: -2px;';
      handle.insertBefore(gripIcon, handle.firstChild);
      
      handle.addEventListener('mousedown', (e) => {
        console.log('Mouse down on handle', handle.dataset.draggable);
        this.startDrag(e, handle);
      });
      handle.addEventListener('touchstart', (e) => this.startDrag(e, handle));
    });
  }

  startDrag(e, handle) {
    e.preventDefault();
    
    const draggableId = handle.dataset.draggable;
    console.log('Starting drag for:', draggableId);
    const element = document.getElementById(draggableId);
    
    if (!element) {
      console.log('Element not found:', draggableId);
      return;
    }

    console.log('Element found, starting drag');
    this.isDragging = true;
    this.currentElement = element;
    this.hasMoved = true;
    
    // Store initial positions
    this.startX = e.clientX || e.touches[0].clientX;
    this.startY = e.clientY || e.touches[0].clientY;
    
    const rect = element.getBoundingClientRect();
    const parentRect = element.parentElement.getBoundingClientRect();
    
    this.elementStartX = rect.left - parentRect.left;
    this.elementStartY = rect.top - parentRect.top;

    console.log('Initial position:', this.elementStartX, this.elementStartY);

    // Apply drag state
    element.style.position = 'absolute';
    element.style.zIndex = '1000';
    element.style.transform = `translate3d(${this.elementStartX}px, ${this.elementStartY}px, 0) scale(1.01)`;
    element.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.5)';
    element.style.transition = 'none';

    // Show grid overlay
    const gridOverlay = document.getElementById('grid-overlay');
    gridOverlay.style.transition = 'opacity 120ms ease-in';
    gridOverlay.style.opacity = '1';

    // Capture pointer
    element.setPointerCapture?.(e.pointerId);

    // Add global listeners
    document.addEventListener('mousemove', this.handleDrag);
    document.addEventListener('mouseup', this.endDrag);
    document.addEventListener('touchmove', this.handleDrag);
    document.addEventListener('touchend', this.endDrag);
    
    console.log('Drag setup complete');
  }

  handleDrag = (e) => {
    if (!this.isDragging) return;

    e.preventDefault();
    
    const currentX = e.clientX || e.touches[0].clientX;
    const currentY = e.clientY || e.touches[0].clientY;

    const deltaX = currentX - this.startX;
    const deltaY = currentY - this.startY;

    const newX = this.elementStartX + deltaX;
    const newY = this.elementStartY + deltaY;

    // Apply transform with GPU acceleration
    this.currentElement.style.transform = `translate3d(${newX}px, ${newY}px, 0) scale(1.01)`;
  }

  endDrag = (e) => {
    if (!this.isDragging) return;

    e.preventDefault();
    
    const element = this.currentElement;
    
    // Reset drag state
    element.style.zIndex = '';
    element.style.boxShadow = '';
    element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';

    // Hide grid overlay
    const gridOverlay = document.getElementById('grid-overlay');
    gridOverlay.style.transition = 'opacity 300ms ease-out';
    gridOverlay.style.opacity = '0';

    // Snap to grid
    this.snapToGrid(element);

    this.cleanup();
    
    // Save layout
    this.saveLayout();
  }

  cleanup() {
    if (this.currentElement) {
      this.currentElement.releasePointerCapture?.(event.pointerId);
    }

    // Remove all listeners
    document.removeEventListener('mousemove', this.handleDrag);
    document.removeEventListener('mouseup', this.endDrag);
    document.removeEventListener('touchmove', this.handleDrag);
    document.removeEventListener('touchend', this.endDrag);

    this.isDragging = false;
    this.currentElement = null;
    this.hasMoved = false;
  }

  snapToGrid(element) {
    const rect = element.getBoundingClientRect();
    const parentRect = element.parentElement.getBoundingClientRect();
    
    let relativeX = rect.left - parentRect.left;
    let relativeY = rect.top - parentRect.top;

    // Snap to nearest grid cell
    const gridX = Math.round(relativeX / this.GRID_SIZE) * this.GRID_SIZE;
    const gridY = Math.round(relativeY / this.GRID_SIZE) * this.GRID_SIZE;

    // Check bounds and prevent overlap
    const finalPosition = this.getValidPosition(element, gridX, gridY);
    
    element.style.transform = `translate3d(${finalPosition.x}px, ${finalPosition.y}px, 0) scale(1)`;
  }

  getValidPosition(element, x, y) {
    const elementRect = element.getBoundingClientRect();
    const parentRect = element.parentElement.getBoundingClientRect();
    const elementWidth = elementRect.width;
    const elementHeight = elementRect.height;

    // Hero container bounds (accounting for padding)
    const heroContainer = document.querySelector('.max-w-6xl');
    const containerRect = heroContainer.getBoundingClientRect();
    const heroSection = document.querySelector('section');
    const heroRect = heroSection.getBoundingClientRect();
    
    const paddingX = containerRect.left - heroRect.left;
    const paddingY = containerRect.top - heroRect.top;
    
    const maxX = heroRect.width - elementWidth - paddingX * 2;
    const maxY = heroRect.height - elementHeight - paddingY * 2;
    
    x = Math.max(paddingX, Math.min(x, maxX));
    y = Math.max(paddingY, Math.min(y, maxY));

    // Check for overlap with other cards
    const otherCards = document.querySelectorAll('[id$="-card"]:not(#' + element.id + ')');
    
    for (const otherCard of otherCards) {
      const otherRect = otherCard.getBoundingClientRect();
      const otherRelativeX = otherRect.left - parentRect.left;
      const otherRelativeY = otherRect.top - parentRect.top;
      
      // Simple AABB collision detection
      if (x < otherRelativeX + otherRect.width &&
          x + elementWidth > otherRelativeX &&
          y < otherRelativeY + otherRect.height &&
          y + elementHeight > otherRelativeY) {
        
        // Deterministic collision resolution: right, down, left, up
        const positions = [
          { x: otherRelativeX + otherRect.width + this.GRID_SIZE, y: y }, // right
          { x: x, y: otherRelativeY + otherRect.height + this.GRID_SIZE }, // down
          { x: Math.max(paddingX, otherRelativeX - elementWidth - this.GRID_SIZE), y: y }, // left
          { x: x, y: Math.max(paddingY, otherRelativeY - elementHeight - this.GRID_SIZE) } // up
        ];
        
        for (const pos of positions) {
          if (pos.x >= paddingX && pos.x <= maxX && 
              pos.y >= paddingY && pos.y <= maxY) {
            return pos;
          }
        }
        
        // No valid position found, revert to last position
        return { x: this.elementStartX, y: this.elementStartY };
      }
    }

    return { x, y };
  }

  setupParallax() {
    if (!this.parallaxEnabled) return;

    const gridPoints = document.querySelector('.grid-points');
    const starsLayer = document.querySelector('.stars-layer');
    const fogLayer = document.querySelector('.fog-layer');

    let mouseX = 0;
    let mouseY = 0;
    let currentX = 0;
    let currentY = 0;

    document.addEventListener('mousemove', (e) => {
      if (!this.isDragging) {
        mouseX = e.clientX;
        mouseY = e.clientY;
      }
    });

    const animate = () => {
      if (this.parallaxEnabled) {
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
          const moveX = Math.max(-this.PARALLAX_MAX.grid, Math.min(this.PARALLAX_MAX.grid, currentX * this.PARALLAX_MAX.grid));
          const moveY = Math.max(-this.PARALLAX_MAX.grid, Math.min(this.PARALLAX_MAX.grid, currentY * this.PARALLAX_MAX.grid));
          gridPoints.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
        
        if (starsLayer) {
          const moveX = Math.max(-this.PARALLAX_MAX.stars, Math.min(this.PARALLAX_MAX.stars, currentX * this.PARALLAX_MAX.stars));
          const moveY = Math.max(-this.PARALLAX_MAX.stars, Math.min(this.PARALLAX_MAX.stars, currentY * this.PARALLAX_MAX.stars));
          starsLayer.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
        
        if (fogLayer) {
          const moveX = Math.max(-this.PARALLAX_MAX.fog, Math.min(this.PARALLAX_MAX.fog, currentX * this.PARALLAX_MAX.fog));
          const moveY = Math.max(-this.PARALLAX_MAX.fog, Math.min(this.PARALLAX_MAX.fog, currentY * this.PARALLAX_MAX.fog));
          fogLayer.style.transform = `translate(${moveX}px, ${moveY}px)`;
        }
      }

      requestAnimationFrame(animate);
    };

    animate();
  }

  saveLayout() {
    const leftCard = document.getElementById('left-card');
    const rightCard = document.getElementById('right-card');
    
    const leftRect = leftCard.getBoundingClientRect();
    const rightRect = rightCard.getBoundingClientRect();
    const parentRect = leftCard.parentElement.getBoundingClientRect();
    
    const layout = {
      version: this.STORAGE_VERSION,
      left: {
        col: Math.round((leftRect.left - parentRect.left) / this.GRID_SIZE),
        row: Math.round((leftRect.top - parentRect.top) / this.GRID_SIZE)
      },
      right: {
        col: Math.round((rightRect.left - parentRect.left) / this.GRID_SIZE),
        row: Math.round((rightRect.top - parentRect.top) / this.GRID_SIZE)
      }
    };
    
    localStorage.setItem('heroGridLayout', JSON.stringify(layout));
  }

  loadLayout() {
    const savedLayout = localStorage.getItem('heroGridLayout');
    
    if (savedLayout) {
      try {
        const layout = JSON.parse(savedLayout);
        
        // Check version
        if (layout.version !== this.STORAGE_VERSION) {
          this.applyDefaultLayout();
          return;
        }
        
        this.applyLayout(layout);
      } catch (e) {
        this.applyDefaultLayout();
      }
    } else {
      this.applyDefaultLayout();
    }
  }

  applyLayout(layout) {
    const leftCard = document.getElementById('left-card');
    const rightCard = document.getElementById('right-card');
    
    // Set absolute positioning
    [leftCard, rightCard].forEach(card => {
      card.style.position = 'absolute';
      card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
    });

    // Apply positions from grid units
    if (layout.left) {
      const x = layout.left.col * this.GRID_SIZE;
      const y = layout.left.row * this.GRID_SIZE;
      leftCard.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    }
    
    if (layout.right) {
      const x = layout.right.col * this.GRID_SIZE;
      const y = layout.right.row * this.GRID_SIZE;
      rightCard.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    }

    // Remove transitions after animation
    setTimeout(() => {
      [leftCard, rightCard].forEach(card => {
        card.style.transition = '';
      });
    }, 600);
  }

  applyDefaultLayout() {
    // Compute right card position based on container
    const heroContainer = document.querySelector('.max-w-6xl');
    const containerWidth = heroContainer.offsetWidth;
    const leftCardWidth = document.getElementById('left-card').offsetWidth;
    
    // Right card starts after left card + gap
    const rightCol = Math.ceil((leftCardWidth + 24) / this.GRID_SIZE); // 24px gap
    
    const defaultLayout = {
      version: this.STORAGE_VERSION,
      left: { col: 0, row: 0 },
      right: { col: rightCol, row: 0 }
    };
    this.applyLayout(defaultLayout);
  }

  setupResizeHandler() {
    let resizeTimeout;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        // Reclamp positions on resize
        const leftCard = document.getElementById('left-card');
        const rightCard = document.getElementById('right-card');
        
        [leftCard, rightCard].forEach(card => {
          const rect = card.getBoundingClientRect();
          const parentRect = card.parentElement.getBoundingClientRect();
          
          let x = rect.left - parentRect.left;
          let y = rect.top - parentRect.top;
          
          // Clamp to bounds
          const maxX = parentRect.width - card.offsetWidth;
          const maxY = parentRect.height - card.offsetHeight;
          
          x = Math.max(0, Math.min(x, maxX));
          y = Math.max(0, Math.min(y, maxY));
          
          card.style.transform = `translate3d(${x}px, ${y}px, 0)`;
        });
        
        this.saveLayout();
      }, 250);
    });
  }

  setupResetButton() {
    // Remove existing reset button if any
    const existingReset = document.querySelector('.reset-layout');
    if (existingReset) existingReset.remove();

    const resetBtn = document.createElement('button');
    resetBtn.className = 'reset-layout absolute top-4 right-4 text-xs font-mono text-[#00C2FF]/60 hover:text-[#00C2FF] transition-colors';
    resetBtn.textContent = 'Reset layout';
    resetBtn.addEventListener('click', () => {
      localStorage.removeItem('heroGridLayout');
      
      // Animate back to defaults
      const leftCard = document.getElementById('left-card');
      const rightCard = document.getElementById('right-card');
      
      [leftCard, rightCard].forEach(card => {
        card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
      });
      
      this.applyDefaultLayout();
    });

    const heroSection = document.querySelector('section');
    heroSection.appendChild(resetBtn);
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new HeroDragSystem();
});
