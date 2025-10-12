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
  
  // Pre-generate random noise patterns
  const noisePattern = [];
  for(let i = 0; i < 1000; i++) {
    noisePattern.push(Math.random());
  }
  
  function draw(){
    time += 0.012; // Smooth animation
    
    const w=canvas.width,h=canvas.height;
    const bg=getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-bg-color').trim();
    const line=getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-line-color').trim();
    const glow=getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-glow-color').trim();
    const dither1=getComputedStyle(document.documentElement)
      .getPropertyValue('--dither-color1').trim();
    const dither2=getComputedStyle(document.documentElement)
      .getPropertyValue('--dither-color2').trim();
    const random1=getComputedStyle(document.documentElement)
      .getPropertyValue('--random-color1').trim();
    const random2=getComputedStyle(document.documentElement)
      .getPropertyValue('--random-color2').trim();
    const opacity=parseFloat(getComputedStyle(document.documentElement)
      .getPropertyValue('--grid-opacity'))||0.7;
    
    // Clear canvas with base color
    ctx.fillStyle=bg; 
    ctx.fillRect(0,0,w,h);
    
    // Create complex dithered background with randomness
    ctx.fillStyle=dither1;
    for(let x=0;x<w;x+=2*dpr){
      for(let y=0;y<h;y+=2*dpr){
        const noiseIndex = Math.floor((x + y + time * 100) % noisePattern.length);
        const noise = noisePattern[noiseIndex];
        if(noise > 0.3){
          ctx.fillRect(x,y,1*dpr,1*dpr);
        }
      }
    }
    
    ctx.fillStyle=dither2;
    for(let x=1*dpr;x<w;x+=2*dpr){
      for(let y=1*dpr;y<h;y+=2*dpr){
        const noiseIndex = Math.floor((x + y + time * 150) % noisePattern.length);
        const noise = noisePattern[noiseIndex];
        if(noise > 0.4){
          ctx.fillRect(x,y,1*dpr,1*dpr);
        }
      }
    }
    
    // Add random color variations
    ctx.fillStyle=random1;
    for(let x=0;x<w;x+=4*dpr){
      for(let y=0;y<h;y+=4*dpr){
        const noiseIndex = Math.floor((x + y + time * 200) % noisePattern.length);
        const noise = noisePattern[noiseIndex];
        if(noise > 0.7){
          ctx.fillRect(x,y,1*dpr,1*dpr);
        }
      }
    }
    
    ctx.fillStyle=random2;
    for(let x=2*dpr;x<w;x+=4*dpr){
      for(let y=2*dpr;y<h;y+=4*dpr){
        const noiseIndex = Math.floor((x + y + time * 250) % noisePattern.length);
        const noise = noisePattern[noiseIndex];
        if(noise > 0.8){
          ctx.fillRect(x,y,1*dpr,1*dpr);
        }
      }
    }
    
    // Create highly random warp effect with multiple sine waves
    const warpX1 = Math.sin(time * 0.3) * 1.5;
    const warpX2 = Math.sin(time * 0.7) * 0.8;
    const warpX3 = Math.sin(time * 1.2) * 0.4;
    const warpX4 = Math.sin(time * 2.1) * 0.2;
    const warpY1 = Math.cos(time * 0.4) * 1.3;
    const warpY2 = Math.cos(time * 0.9) * 0.7;
    const warpY3 = Math.cos(time * 1.6) * 0.3;
    const warpY4 = Math.cos(time * 2.3) * 0.15;
    
    // Draw grid with highly random warp effect
    ctx.strokeStyle=line; 
    ctx.globalAlpha=opacity;
    ctx.lineWidth=1;
    ctx.beginPath();
    
    // Vertical lines with highly random warp
    for(let x=0;x<w+cell*dpr*4;x+=cell*dpr){
      const noiseIndex = Math.floor((x + time * 300) % noisePattern.length);
      const randomFactor = noisePattern[noiseIndex] * 0.5;
      
      const warpOffset1 = Math.sin((x/w) * Math.PI * 2 + time * 0.5) * warpX1 * cell * dpr;
      const warpOffset2 = Math.sin((x/w) * Math.PI * 5 + time * 1.1) * warpX2 * cell * dpr;
      const warpOffset3 = Math.sin((x/w) * Math.PI * 8 + time * 1.8) * warpX3 * cell * dpr;
      const warpOffset4 = Math.sin((x/w) * Math.PI * 13 + time * 2.5) * warpX4 * cell * dpr;
      const totalWarp = warpOffset1 + warpOffset2 + warpOffset3 + warpOffset4 + (randomFactor * cell * dpr);
      ctx.moveTo(x + totalWarp, 0);
      ctx.lineTo(x + totalWarp, h);
    }
    
    // Horizontal lines with highly random warp
    for(let y=0;y<h+cell*dpr*4;y+=cell*dpr){
      const noiseIndex = Math.floor((y + time * 350) % noisePattern.length);
      const randomFactor = noisePattern[noiseIndex] * 0.5;
      
      const warpOffset1 = Math.cos((y/h) * Math.PI * 1.5 + time * 0.6) * warpY1 * cell * dpr;
      const warpOffset2 = Math.cos((y/h) * Math.PI * 4 + time * 1.3) * warpY2 * cell * dpr;
      const warpOffset3 = Math.cos((y/h) * Math.PI * 7 + time * 2.0) * warpY3 * cell * dpr;
      const warpOffset4 = Math.cos((y/h) * Math.PI * 11 + time * 2.7) * warpY4 * cell * dpr;
      const totalWarp = warpOffset1 + warpOffset2 + warpOffset3 + warpOffset4 + (randomFactor * cell * dpr);
      ctx.moveTo(0, y + totalWarp);
      ctx.lineTo(w, y + totalWarp);
    }
    
    ctx.stroke();
    
    // Add subtle glow effect with random variations
    ctx.strokeStyle=glow;
    ctx.globalAlpha=opacity * 0.2;
    ctx.lineWidth=1;
    ctx.beginPath();
    
    // Glow vertical lines with same random warp
    for(let x=0;x<w+cell*dpr*4;x+=cell*dpr){
      const noiseIndex = Math.floor((x + time * 300) % noisePattern.length);
      const randomFactor = noisePattern[noiseIndex] * 0.5;
      
      const warpOffset1 = Math.sin((x/w) * Math.PI * 2 + time * 0.5) * warpX1 * cell * dpr;
      const warpOffset2 = Math.sin((x/w) * Math.PI * 5 + time * 1.1) * warpX2 * cell * dpr;
      const warpOffset3 = Math.sin((x/w) * Math.PI * 8 + time * 1.8) * warpX3 * cell * dpr;
      const warpOffset4 = Math.sin((x/w) * Math.PI * 13 + time * 2.5) * warpX4 * cell * dpr;
      const totalWarp = warpOffset1 + warpOffset2 + warpOffset3 + warpOffset4 + (randomFactor * cell * dpr);
      ctx.moveTo(x + totalWarp, 0);
      ctx.lineTo(x + totalWarp, h);
    }
    
    // Glow horizontal lines with same random warp
    for(let y=0;y<h+cell*dpr*4;y+=cell*dpr){
      const noiseIndex = Math.floor((y + time * 350) % noisePattern.length);
      const randomFactor = noisePattern[noiseIndex] * 0.5;
      
      const warpOffset1 = Math.cos((y/h) * Math.PI * 1.5 + time * 0.6) * warpY1 * cell * dpr;
      const warpOffset2 = Math.cos((y/h) * Math.PI * 4 + time * 1.3) * warpY2 * cell * dpr;
      const warpOffset3 = Math.cos((y/h) * Math.PI * 7 + time * 2.0) * warpY3 * cell * dpr;
      const warpOffset4 = Math.cos((y/h) * Math.PI * 11 + time * 2.7) * warpY4 * cell * dpr;
      const totalWarp = warpOffset1 + warpOffset2 + warpOffset3 + warpOffset4 + (randomFactor * cell * dpr);
      ctx.moveTo(0, y + totalWarp);
      ctx.lineTo(w, y + totalWarp);
    }
    
    ctx.stroke();
    ctx.globalAlpha=1;
    
    requestAnimationFrame(draw);
  }
  
  if(!window.matchMedia('(prefers-reduced-motion:reduce)').matches)
    requestAnimationFrame(draw);
})();