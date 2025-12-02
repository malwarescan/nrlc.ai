/**
 * NRLC.ai Cognition Architecture Animation
 * Purpose-driven motion: Data → Reasoning → Domains → Central Intelligence
 * Isometric 3D visualization of NRLC's vertical intelligence stack
 */

(function() {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isMobile = window.innerWidth < 769;
  
  const easings = {
    smooth: isMobile ? 'sine.inOut' : 'cubic-bezier(0.4, 0, 0.2, 1)',
    premium: isMobile ? 'sine.inOut' : 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
  };

  let mouseX = 0.5;
  let targetMouseX = 0.5;
  let mouseY = 0.5;
  let targetMouseY = 0.5;
  
  function updateMousePosition(e) {
    const rect = document.querySelector('.hero-isometric')?.getBoundingClientRect();
    if (!rect) return;
    targetMouseX = (e.clientX - rect.left) / rect.width;
    targetMouseY = (e.clientY - rect.top) / rect.height;
  }
  
  function smoothMouseUpdate() {
    mouseX += (targetMouseX - mouseX) * 0.05;
    mouseY += (targetMouseY - mouseY) * 0.05;
    requestAnimationFrame(smoothMouseUpdate);
  }
  
  if (!prefersReducedMotion && !isMobile) {
    document.addEventListener('mousemove', updateMousePosition);
    smoothMouseUpdate();
  }

  let scrollY = 0;
  function updateScroll() {
    scrollY = window.scrollY;
  }
  window.addEventListener('scroll', updateScroll, { passive: true });

  function initHeroAnimation() {
    if (prefersReducedMotion) return;
    if (typeof gsap === 'undefined') {
      setTimeout(initHeroAnimation, 200);
      return;
    }

    const hero = document.querySelector('.hero-isometric');
    if (!hero) return;

    const animationDuration = 18; // 14-20s range
    const nodeCount = 3; // Minimal: 3 data sources only

    // ============================================================================
    // LAYER A — Base Grid (Static - No Animation)
    // ============================================================================
    // Grid layer is now static - no animation applied

    // ============================================================================
    // LAYER B — Cognition Architecture (Purpose-Driven Motion)
    // ============================================================================
    
    // A. Data Sources - Minimal: 3 nodes, sequential pulses
    const dataNodes = Array.from(hero.querySelectorAll('.cognition-node[data-product="croutons"]'));
    dataNodes.forEach((node, index) => {
      const baseDelay = index * 0.5;
      const pulseDuration = 2.5;
      
      gsap.set(node, { 
        scale: 1, 
        opacity: 0.9,
        z: 60
      });
      
      // Sequential pulse - data generation
      gsap.to(node, {
        scale: 1.2,
        opacity: 1,
        z: 70,
        duration: pulseDuration * 0.4,
        delay: baseDelay,
        ease: 'sine.inOut',
        repeat: -1,
        repeatDelay: (nodeCount * 0.5) - pulseDuration,
        yoyo: true
      });
    });

    // B. Reasoning Paths - Flailing lines that expand into grid at nodes
    const edges = hero.querySelectorAll('.cognition-edge--flail-1, .cognition-edge--flail-2, .cognition-edge--flail-3');
    const nodeGrids = hero.querySelectorAll('.node-grid');
    const shadows = hero.querySelectorAll('.shadow-shadow-1, .shadow-shadow-2, .shadow-shadow-3');
    
    edges.forEach((edge, index) => {
      const pathLength = edge.getTotalLength();
      const travelDuration = 1.5;
      const node = dataNodes[index];
      const nodeRect = node?.getBoundingClientRect();
      const containerRect = hero.querySelector('.cognition-container')?.getBoundingClientRect();
      
      gsap.set(edge, {
        strokeDasharray: pathLength,
        strokeDashoffset: pathLength,
        strokeOpacity: 0.4
      });
      
      // Flailing motion - lines move dynamically
      if (nodeRect && containerRect) {
        const baseX = (nodeRect.left + nodeRect.width / 2 - containerRect.left) / containerRect.width * 1000;
        const baseY = (nodeRect.top + nodeRect.height / 2 - containerRect.top) / containerRect.height * 600;
        const hubX = 500;
        const hubY = 450;
        
        const flailTL = gsap.timeline({ repeat: -1, delay: index * 0.3 });
        
        // Flailing path variations
        flailTL
          .to(edge, {
            attr: { d: `M ${baseX} ${baseY} Q ${baseX + 50} ${baseY + 100} ${hubX} ${hubY}` },
            strokeOpacity: 0.7,
            duration: travelDuration * 0.5,
            ease: 'sine.inOut'
          })
          .to(edge, {
            attr: { d: `M ${baseX} ${baseY} Q ${baseX - 30} ${baseY + 120} ${hubX} ${hubY}` },
            strokeOpacity: 0.5,
            duration: travelDuration * 0.5,
            ease: 'sine.inOut'
          })
          .to(edge, {
            attr: { d: `M ${baseX} ${baseY} L ${hubX} ${hubY}` },
            strokeOpacity: 0.6,
            duration: travelDuration * 0.5,
            ease: 'sine.inOut'
          });
      }
      
      // Pulse travels along flailing line
      gsap.to(edge, {
        strokeDashoffset: 0,
        strokeOpacity: 0.8,
        duration: travelDuration,
        delay: index * 0.3,
        ease: 'sine.inOut',
        repeat: -1,
        repeatDelay: 2,
        yoyo: false
      });
      
      // Grid expands from node position - natural flowing expansion
      const grid = nodeGrids[index];
      if (grid) {
        const expandTL = gsap.timeline({ repeat: -1, delay: index * 0.5 });
        expandTL
          .to(grid, {
            opacity: 0,
            scale: 0,
            duration: 0
          })
          .to(grid, {
            opacity: 0.3,
            scale: 0.5,
            duration: 2,
            ease: 'power1.out' // Smooth, natural flow
          })
          .to(grid, {
            opacity: 0.5,
            scale: 0.8,
            duration: 2,
            ease: 'sine.inOut'
          })
          .to(grid, {
            opacity: 0.4,
            scale: 1,
            duration: 2,
            ease: 'power1.inOut'
          })
          .to(grid, {
            opacity: 0.2,
            scale: 1.1,
            duration: 2,
            ease: 'power1.in'
          })
          .to({}, { duration: 1 }); // Pause before repeat
      }
    });
    
    // Flowing shadows - natural expansion beneath objects
    shadows.forEach((shadow, index) => {
      const shadowTL = gsap.timeline({ repeat: -1, delay: index * 0.5 });
      shadowTL
        .to(shadow, {
          opacity: 0.2,
          duration: 2,
          ease: 'power1.inOut'
        })
        .to(shadow, {
          opacity: 0.4,
          duration: 2.5,
          ease: 'sine.inOut'
        })
        .to(shadow, {
          opacity: 0.5,
          duration: 2,
          ease: 'power1.inOut'
        })
        .to(shadow, {
          opacity: 0.2,
          duration: 2.5,
          ease: 'sine.inOut'
        });
    });

    // C. Central Intelligence Hub - Minimal: Receiving pulse only
    const commandNode = hero.querySelector('.cognition-command');
    if (commandNode) {
      // Minimal parallax drift
      gsap.to(commandNode, {
        x: 1,
        y: 1,
        duration: animationDuration,
        ease: 'sine.inOut',
        repeat: -1,
        yoyo: true
      });
      
      // Receiving pulse - shows convergence
      gsap.to(commandNode, {
        scale: 1.15,
        opacity: 1,
        z: 110,
        duration: 3,
        ease: 'sine.inOut',
        repeat: -1,
        yoyo: true
      });
    }

    // Mouse-responsive (desktop only)
    if (!isMobile) {
      const cognitionContainer = hero.querySelector('.cognition-container');
      const edges = hero.querySelectorAll('.cognition-edge');
      
      // Update edge paths to connect to actual node positions
      function updateEdgePaths() {
        dataNodes.forEach((node, index) => {
          const nodeRect = node.getBoundingClientRect();
          const containerRect = cognitionContainer?.getBoundingClientRect();
          const commandRect = commandNode?.getBoundingClientRect();
          
          if (containerRect && commandRect && edges[index]) {
            const svg = edges[index].ownerSVGElement;
            if (!svg) return;
            
            const svgRect = svg.getBoundingClientRect();
            const startX = ((nodeRect.left + nodeRect.width / 2) - svgRect.left) / svgRect.width * 1000;
            const startY = ((nodeRect.top + nodeRect.height / 2) - svgRect.top) / svgRect.height * 600;
            const endX = ((commandRect.left + commandRect.width / 2) - svgRect.left) / svgRect.width * 1000;
            const endY = ((commandRect.top + commandRect.height / 2) - svgRect.top) / svgRect.height * 600;
            
            edges[index].setAttribute('d', `M ${startX} ${startY} L ${endX} ${endY}`);
          }
        });
      }
      
      // Update paths on resize and animation
      window.addEventListener('resize', updateEdgePaths);
      gsap.ticker.add(updateEdgePaths);
      updateEdgePaths();
    }
  }

  function waitForReady() {
    if (document.readyState === 'complete') {
      setTimeout(() => {
        if (typeof gsap !== 'undefined') {
          initHeroAnimation();
        }
      }, 300);
    } else {
      window.addEventListener('load', () => {
        setTimeout(() => {
          if (typeof gsap !== 'undefined') {
            initHeroAnimation();
          }
        }, 300);
      });
    }
  }
  
  waitForReady();

})();
