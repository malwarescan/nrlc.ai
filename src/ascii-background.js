document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('ascii-background');
  if (!container) return;

  const chars = '01▣◈◇◻{}[]<>|/\\-_=+.,:;~`';
  const columns = Math.floor(window.innerWidth / 12);
  const rows = Math.floor(window.innerHeight / 16);
  const drops = Array(columns).fill(0).map(() => Math.floor(Math.random() * rows));
  const columnDivs = [];
  
  // Determine which columns will be verified facts (green streaks)
  // About 10-15% of columns will be verified facts
  const verifiedColumns = new Set();
  const numVerifiedColumns = Math.floor(columns * 0.12);
  while (verifiedColumns.size < numVerifiedColumns) {
    verifiedColumns.add(Math.floor(Math.random() * columns));
  }

  for (let i = 0; i < columns; i++) {
    const column = document.createElement('div');
    column.style.position = 'absolute';
    column.style.left = `${i * 12}px`;
    column.style.top = '0';
    column.style.width = '12px';
    column.style.height = '100%';
    column.style.fontFamily = 'monospace';
    column.style.fontSize = '12px';
    // Use verified facts color for verified columns, dark for others
    column.style.color = verifiedColumns.has(i) ? '#25D366' : '#0A0A0A';
    column.style.opacity = verifiedColumns.has(i) ? '0.35' : '0.08';
    column.style.lineHeight = '16px';
    column.style.whiteSpace = 'pre';
    column.style.overflow = 'hidden';
    container.appendChild(column);
    columnDivs.push(column);
  }

  const animate = () => {
    columnDivs.forEach((column, i) => {
      const char = chars[Math.floor(Math.random() * chars.length)];
      const maxRows = Math.floor(window.innerHeight / 16);
      if (drops[i] > maxRows && Math.random() > 0.975) {
        drops[i] = 0;
        column.textContent = '';
      }
      column.textContent = (column.textContent || '') + char + '\n';
      drops[i]++;
    });
  };

  const interval = setInterval(animate, 50);

  // Cleanup on window resize
  window.addEventListener('resize', function() {
    clearInterval(interval);
    columnDivs.forEach(div => div.remove());
    // Reinitialize if needed
    setTimeout(() => {
      location.reload();
    }, 100);
  });
});

