(function(){
  const holder=document.createElement('div');
  holder.className='win98-grid-bg';
  const canvas=document.createElement('canvas');
  holder.appendChild(canvas);
  document.body.prepend(holder);
  const ctx=canvas.getContext('2d');
  const dpr=Math.min(window.devicePixelRatio||1,2);
  
  function resize(){
    canvas.width=innerWidth*dpr;
    canvas.height=innerHeight*dpr;
  }
  resize();
  window.addEventListener('resize',resize,{passive:true});
  
  let time=0;
  const cell=parseFloat(getComputedStyle(document.documentElement)
    .getPropertyValue('--grid-cell-size'))||24;
  
  let lastFrameTime = 0;
  const targetFPS = 30; // Limit to 30 FPS for better performance
  const frameInterval = 1000 / targetFPS;
  
  function draw(currentTime){
    // Frame rate limiting
    if (currentTime - lastFrameTime < frameInterval) {
      requestAnimationFrame(draw);
      return;
    }
    lastFrameTime = currentTime;
    
    time += 0.008; // Moderate animation speed
    
    const w=canvas.width,h=canvas.height;
    const bg=getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-bg-color').trim();
    const line=getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-line-color').trim();
    const opacity=parseFloat(getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-opacity'))||0.3;
    
    // Clear canvas with gradient background
    const gradient = ctx.createLinearGradient(0, 0, w, h);
    gradient.addColorStop(0, '#d0d0d0');
    gradient.addColorStop(0.3, '#c0c0c0');
    gradient.addColorStop(0.7, '#b0b0b0');
    gradient.addColorStop(1, '#a0a0a0');
    ctx.fillStyle = gradient;
    ctx.fillRect(0,0,w,h);
    
    // Optimized crawling dither pattern
    const crawlStep = 6 * dpr; // Larger steps for better performance
    for(let x=0;x<w;x+=crawlStep){
      for(let y=0;y<h;y+=crawlStep){
        // Simplified crawling effect
        const crawlOffset = Math.sin(time * 0.5 + (x + y) * 0.005) * 15;
        const crawlX = x + crawlOffset;
        const crawlY = y + Math.cos(time * 0.3 + (x - y) * 0.003) * 10;
        
        // Only draw if within bounds
        if(crawlX >= 0 && crawlX < w && crawlY >= 0 && crawlY < h){
          // Simplified gradient intensity
          const gradientIntensity = (crawlX/w + crawlY/h) * 0.3 + 0.1;
          const finalIntensity = gradientIntensity * 0.4;
          
          ctx.fillStyle = `rgba(128,128,128,${finalIntensity})`;
          ctx.fillRect(crawlX, crawlY, 2*dpr, 2*dpr);
        }
      }
    }
    
    // Grid with gradient effect
    ctx.globalAlpha=opacity;
    ctx.lineWidth=1;
    
    // Vertical lines with gradient and subtle warp
    for(let x=0;x<w+cell*dpr;x+=cell*dpr){
      const warp = Math.sin((x/w) * Math.PI + time * 0.5) * 2;
      const gradientIntensity = (x/w) * 0.5 + 0.5;
      ctx.strokeStyle = `rgba(128,128,128,${opacity * gradientIntensity})`;
      ctx.beginPath();
      ctx.moveTo(x + warp, 0);
      ctx.lineTo(x + warp, h);
      ctx.stroke();
    }
    
    // Horizontal lines with gradient and subtle warp
    for(let y=0;y<h+cell*dpr;y+=cell*dpr){
      const warp = Math.cos((y/h) * Math.PI + time * 0.3) * 2;
      const gradientIntensity = (y/h) * 0.5 + 0.5;
      ctx.strokeStyle = `rgba(128,128,128,${opacity * gradientIntensity})`;
      ctx.beginPath();
      ctx.moveTo(0, y + warp);
      ctx.lineTo(w, y + warp);
      ctx.stroke();
    }
    ctx.globalAlpha=1;
    
    requestAnimationFrame(draw);
  }
  
  if(!window.matchMedia('(prefers-reduced-motion:reduce)').matches)
    requestAnimationFrame(draw);
})();