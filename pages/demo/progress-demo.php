<?php
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';

$GLOBALS['__page_slug'] = 'demo/progress-demo';
?>

<main role="main">
<section class="container">
  
  <!-- Demo Window -->
  <div class="window" style="margin-bottom: 2rem;">
    <div class="title-bar">
      <div class="title-bar-text">Windows 98 Progress Indicator Demo</div>
    </div>
    <div class="window-body">
      <h1 style="margin: 0 0 1rem 0; font-size: 2rem; color: #000080;">Progress Indicator Controls</h1>
      <p class="lead" style="font-size: 1.2rem; margin-bottom: 2rem;">
        Demonstration of Windows 98-style progress indicators as specified in Microsoft Windows User Experience guidelines.
      </p>
      
      <h2 style="color: #000080;">Solid Progress Bar (Default)</h2>
      <p>The solid version is the default progress bar control.</p>
      
      <div style="margin: 1rem 0;">
        <div class="progress-indicator" style="position: relative; display: block; height: 20px;">
          <div class="progress-bar" style="width: 45%; height: 100%;"></div>
        </div>
        <p class="small">45% Complete</p>
      </div>
      
      <div style="margin: 1rem 0;">
        <div class="progress-indicator" style="position: relative; display: block; height: 20px;">
          <div class="progress-bar" style="width: 75%; height: 100%;"></div>
        </div>
        <p class="small">75% Complete</p>
      </div>
      
      <h2 style="color: #000080;">Segmented Progress Bar</h2>
      <p>To declare a segmented bar, use the segmented class.</p>
      
      <div style="margin: 1rem 0;">
        <div class="progress-indicator segmented" style="position: relative; display: block; height: 20px;">
          <div class="progress-bar" style="width: 60%; height: 100%;"></div>
        </div>
        <p class="small">60% Complete (Segmented)</p>
      </div>
      
      <div style="margin: 1rem 0;">
        <div class="progress-indicator segmented" style="position: relative; display: block; height: 20px;">
          <div class="progress-bar" style="width: 90%; height: 100%;"></div>
        </div>
        <p class="small">90% Complete (Segmented)</p>
      </div>
      
      <h2 style="color: #000080;">Interactive Demo</h2>
      <p>Test the progress indicator functionality:</p>
      
      <div style="margin: 1rem 0;">
        <button class="btn" onclick="testProgress()" data-ripple>Test Page Loading Progress</button>
        <button class="btn" onclick="testSegmentedProgress()" data-ripple>Test Segmented Progress</button>
        <button class="btn" onclick="testSlowProgress()" data-ripple>Test Slow Operation</button>
      </div>
      
      <div id="demo-progress" style="margin: 1rem 0; display: none;">
        <div class="progress-indicator" style="position: relative; display: block; height: 20px;">
          <div class="progress-bar" id="demo-progress-bar" style="width: 0%; height: 100%;"></div>
        </div>
        <p class="small" id="demo-progress-text">0% Complete</p>
      </div>
      
      <h2 style="color: #000080;">Implementation Notes</h2>
      <ul>
        <li>Progress indicators show percentage of completion for lengthy operations</li>
        <li>Solid version is the default (as per Microsoft guidelines)</li>
        <li>Segmented version uses the "segmented" class</li>
        <li>Automatically appears during page loading</li>
        <li>Respects prefers-reduced-motion settings</li>
        <li>Includes dark mode support</li>
      </ul>
      
    </div>
  </div>
  
</section>
</main>

<script>
function testProgress() {
  const demo = document.getElementById('demo-progress');
  const bar = document.getElementById('demo-progress-bar');
  const text = document.getElementById('demo-progress-text');
  
  demo.style.display = 'block';
  bar.style.width = '0%';
  text.textContent = '0% Complete';
  
  let progress = 0;
  const interval = setInterval(() => {
    progress += 10;
    bar.style.width = progress + '%';
    text.textContent = progress + '% Complete';
    
    if (progress >= 100) {
      clearInterval(interval);
      setTimeout(() => {
        demo.style.display = 'none';
      }, 1000);
    }
  }, 200);
}

function testSegmentedProgress() {
  const demo = document.getElementById('demo-progress');
  const bar = document.getElementById('demo-progress-bar');
  const text = document.getElementById('demo-progress-text');
  const container = demo.querySelector('.progress-indicator');
  
  demo.style.display = 'block';
  container.classList.add('segmented');
  bar.style.width = '0%';
  text.textContent = '0% Complete (Segmented)';
  
  let progress = 0;
  const interval = setInterval(() => {
    progress += 15;
    bar.style.width = progress + '%';
    text.textContent = progress + '% Complete (Segmented)';
    
    if (progress >= 100) {
      clearInterval(interval);
      setTimeout(() => {
        demo.style.display = 'none';
        container.classList.remove('segmented');
      }, 1000);
    }
  }, 300);
}

function testSlowProgress() {
  const demo = document.getElementById('demo-progress');
  const bar = document.getElementById('demo-progress-bar');
  const text = document.getElementById('demo-progress-text');
  
  demo.style.display = 'block';
  bar.style.width = '0%';
  text.textContent = '0% Complete';
  
  let progress = 0;
  const interval = setInterval(() => {
    progress += Math.random() * 5;
    bar.style.width = Math.min(100, progress) + '%';
    text.textContent = Math.min(100, Math.round(progress)) + '% Complete';
    
    if (progress >= 100) {
      clearInterval(interval);
      setTimeout(() => {
        demo.style.display = 'none';
      }, 1000);
    }
  }, 500);
}
</script>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
