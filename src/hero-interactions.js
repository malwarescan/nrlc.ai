// Hero Interactions: Drag + Snap + Accordion
class HeroInteractions {
  constructor() {
    this.currentLayout = localStorage.getItem('heroLayout') || 'dock-left';
    this.isDragging = false;
    this.currentElement = null;
    this.startX = 0;
    this.startY = 0;
    this.expandedRow = null;
    
    this.init();
  }

  init() {
    this.setupDraggable();
    this.setupAccordion();
    this.applyLayout();
    this.setupResetButton();
  }

  setupDraggable() {
    // Only enable on desktop
    if (window.innerWidth < 1024) return;

    const leftBlock = document.getElementById('hero-left-block');
    const rightPanel = document.getElementById('hero-right-panel');

    [leftBlock, rightPanel].forEach(element => {
      if (!element) return;

      // Add drag handle
      const handle = document.createElement('div');
      handle.className = 'drag-handle absolute top-2 right-2 w-4 h-4 cursor-move opacity-0 hover:opacity-60 transition-opacity';
      handle.innerHTML = '⋮⋮';
      handle.style.cssText = 'font-size: 12px; color: #00C2FF; user-select: none;';
      element.appendChild(handle);

      element.addEventListener('mousedown', (e) => this.startDrag(e, element));
      element.addEventListener('touchstart', (e) => this.startDrag(e, element));
    });
  }

  startDrag(e, element) {
    // Don't start drag if clicking on buttons/links
    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;

    this.isDragging = true;
    this.currentElement = element;
    this.startX = e.clientX || e.touches[0].clientX;
    this.startY = e.clientY || e.touches[0].clientY;

    element.style.opacity = '0.8';
    element.style.transition = 'none';
    element.style.zIndex = '1000';

    document.addEventListener('mousemove', this.handleDrag);
    document.addEventListener('mouseup', this.endDrag);
    document.addEventListener('touchmove', this.handleDrag);
    document.addEventListener('touchend', this.endDrag);
  }

  handleDrag = (e) => {
    if (!this.isDragging) return;

    const currentX = e.clientX || e.touches[0].clientX;
    const currentY = e.clientY || e.touches[0].clientY;

    const deltaX = currentX - this.startX;
    const deltaY = currentY - this.startY;

    this.currentElement.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
  }

  endDrag = () => {
    if (!this.isDragging) return;

    this.isDragging = false;
    const element = this.currentElement;

    element.style.opacity = '1';
    element.style.transition = 'all 0.3s ease';

    // Check for snap zones
    this.checkSnapZones(element);

    document.removeEventListener('mousemove', this.handleDrag);
    document.removeEventListener('mouseup', this.endDrag);
    document.removeEventListener('touchmove', this.handleDrag);
    document.removeEventListener('touchend', this.endDrag);
  }

  checkSnapZones(element) {
    const rect = element.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;

    // Define snap zones (40px tolerance)
    const snapZones = {
      'dock-left': { x: window.innerWidth * 0.3, y: window.innerHeight * 0.5 },
      'dock-right': { x: window.innerWidth * 0.7, y: window.innerHeight * 0.5 },
      'center-stack': { x: window.innerWidth * 0.5, y: window.innerHeight * 0.6 }
    };

    let closestZone = null;
    let minDistance = Infinity;

    for (const [name, zone] of Object.entries(snapZones)) {
      const distance = Math.sqrt(Math.pow(centerX - zone.x, 2) + Math.pow(centerY - zone.y, 2));
      if (distance < minDistance && distance < 40) {
        minDistance = distance;
        closestZone = name;
      }
    }

    if (closestZone) {
      this.snapToZone(element, closestZone);
    } else {
      // Return to last position if no snap
      element.style.transform = '';
    }
  }

  snapToZone(element, zone) {
    const snapZones = {
      'dock-left': {
        left: 'col-span-12 lg:col-span-7',
        right: 'col-span-12 lg:col-span-5',
        transform: ''
      },
      'dock-right': {
        left: 'col-span-12 lg:col-span-5',
        right: 'col-span-12 lg:col-span-7',
        transform: ''
      },
      'center-stack': {
        left: 'col-span-12 lg:col-span-7 mx-auto',
        right: 'col-span-12 lg:col-span-5 mx-auto mt-8',
        transform: ''
      }
    };

    const layout = snapZones[zone];
    const leftBlock = document.getElementById('hero-left-block');
    const rightPanel = document.getElementById('hero-right-panel');

    // Apply snap classes
    leftBlock.className = leftBlock.className.replace(/col-span-\d+ lg:col-span-\d+/g, layout.left);
    rightPanel.className = rightPanel.className.replace(/col-span-\d+ lg:col-span-\d+/g, layout.right);

    // Add centering for stack layout
    if (zone === 'center-stack') {
      leftBlock.classList.add('text-center');
      rightPanel.classList.add('text-center');
    }

    // Clear transform
    element.style.transform = layout.transform;

    // Save layout
    this.currentLayout = zone;
    localStorage.setItem('heroLayout', zone);
  }

  applyLayout() {
    this.snapToZone(null, this.currentLayout);
  }

  setupAccordion() {
    const rows = document.querySelectorAll('.mechanism-row');
    
    rows.forEach((row, index) => {
      const header = row.querySelector('.mechanism-header');
      const content = row.querySelector('.mechanism-content');
      const caret = row.querySelector('.text-[#00C2FF]');
      
      if (!header || !content || !caret) return;

      header.addEventListener('click', () => this.toggleRow(index, caret));
      header.style.cursor = 'pointer';
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.mechanism-row')) {
        this.collapseAll();
      }
    });
  }

  toggleRow(index, caret) {
    const rows = document.querySelectorAll('.mechanism-row');
    const row = rows[index];
    const content = row.querySelector('.mechanism-content');

    if (this.expandedRow === index) {
      // Collapse
      content.style.maxHeight = '0';
      content.style.opacity = '0';
      caret.style.transform = 'rotate(0deg)';
      caret.textContent = '›';
      this.expandedRow = null;
    } else {
      // Collapse others first
      this.collapseAll();
      
      // Expand this one
      content.style.maxHeight = '100px';
      content.style.opacity = '1';
      caret.style.transform = 'rotate(90deg)';
      caret.textContent = '›';
      this.expandedRow = index;
    }
  }

  collapseAll() {
    const rows = document.querySelectorAll('.mechanism-row');
    rows.forEach((row, index) => {
      const content = row.querySelector('.mechanism-content');
      const caret = row.querySelector('.text-[#00C2FF]');
      
      content.style.maxHeight = '0';
      content.style.opacity = '0';
      caret.style.transform = 'rotate(0deg)';
      caret.textContent = '›';
    });
    this.expandedRow = null;
  }

  setupResetButton() {
    const resetBtn = document.createElement('button');
    resetBtn.className = 'reset-layout absolute top-4 right-4 text-xs font-mono text-[#00C2FF]/60 hover:text-[#00C2FF] transition-colors lg:block hidden';
    resetBtn.textContent = 'Reset Layout';
    resetBtn.addEventListener('click', () => {
      this.currentLayout = 'dock-left';
      localStorage.setItem('heroLayout', 'dock-left');
      this.applyLayout();
    });

    const heroSection = document.querySelector('section');
    heroSection.appendChild(resetBtn);
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new HeroInteractions();
});
