(function(){
  'use strict';
  
  // Create progress indicator element
  const progressIndicator = document.createElement('div');
  progressIndicator.className = 'progress-indicator';
  progressIndicator.innerHTML = '<div class="progress-bar"></div>';
  document.body.appendChild(progressIndicator);
  
  const progressBar = progressIndicator.querySelector('.progress-bar');
  
  // Progress simulation based on resource loading
  let progress = 0;
  let isComplete = false;
  
  function updateProgress(value) {
    progress = Math.min(100, Math.max(0, value));
    progressBar.style.width = progress + '%';
    
    if (progress >= 100 && !isComplete) {
      isComplete = true;
      setTimeout(() => {
        progressIndicator.classList.remove('show');
        setTimeout(() => {
          progressIndicator.style.display = 'none';
        }, 300);
      }, 200);
    }
  }
  
  function showProgress() {
    progressIndicator.classList.add('show');
    progressIndicator.style.display = 'block';
    progress = 0;
    isComplete = false;
    updateProgress(0);
  }
  
  // Simulate progress based on DOM events
  function simulateProgress() {
    showProgress();
    
    // Initial progress
    updateProgress(10);
    
    // DOM content loaded
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => {
        updateProgress(30);
      });
    } else {
      updateProgress(30);
    }
    
    // Images loaded
    const images = document.querySelectorAll('img');
    let loadedImages = 0;
    
    if (images.length > 0) {
      images.forEach(img => {
        if (img.complete) {
          loadedImages++;
        } else {
          img.addEventListener('load', () => {
            loadedImages++;
            updateProgress(30 + (loadedImages / images.length) * 40);
          });
          img.addEventListener('error', () => {
            loadedImages++;
            updateProgress(30 + (loadedImages / images.length) * 40);
          });
        }
      });
      
      if (loadedImages === images.length) {
        updateProgress(70);
      }
    } else {
      updateProgress(70);
    }
    
    // CSS and JS loaded
    setTimeout(() => {
      updateProgress(85);
    }, 100);
    
    // Final completion
    setTimeout(() => {
      updateProgress(100);
    }, 300);
  }
  
  // Start progress on page load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', simulateProgress);
  } else {
    simulateProgress();
  }
  
  // Handle navigation (for SPA-like behavior)
  let lastUrl = location.href;
  new MutationObserver(() => {
    const url = location.href;
    if (url !== lastUrl) {
      lastUrl = url;
      simulateProgress();
    }
  }).observe(document, { subtree: true, childList: true });
  
  // Expose API for manual control
  window.ProgressIndicator = {
    show: showProgress,
    update: updateProgress,
    complete: () => updateProgress(100),
    segmented: (enable) => {
      if (enable) {
        progressIndicator.classList.add('segmented');
      } else {
        progressIndicator.classList.remove('segmented');
      }
    }
  };
})();
