// Simple Accordion System - MAKE IT WORK
document.addEventListener('DOMContentLoaded', () => {
  const rows = document.querySelectorAll('.mechanism-row');
  
  rows.forEach((row) => {
    const header = row.querySelector('.mechanism-header');
    const content = row.querySelector('.mechanism-content');
    const caret = row.querySelector('.text-\\[\\#00C2FF\\]');
    
    if (!header || !content || !caret) return;
    
    header.addEventListener('click', (e) => {
      e.preventDefault();
      
      // Close all other rows first
      rows.forEach((otherRow) => {
        const otherContent = otherRow.querySelector('.mechanism-content');
        const otherCaret = otherRow.querySelector('.text-\\[\\#00C2FF\\]');
        
        if (otherContent !== content) {
          otherContent.style.maxHeight = '0';
          otherContent.style.opacity = '0';
          otherCaret.style.transform = 'rotate(0deg)';
        }
      });
      
      // Toggle this row
      if (content.style.maxHeight === '0px' || !content.style.maxHeight) {
        content.style.maxHeight = content.scrollHeight + 'px';
        content.style.opacity = '1';
        caret.style.transform = 'rotate(90deg)';
      } else {
        content.style.maxHeight = '0';
        content.style.opacity = '0';
        caret.style.transform = 'rotate(0deg)';
      }
    });
    
    header.style.cursor = 'pointer';
  });
});
