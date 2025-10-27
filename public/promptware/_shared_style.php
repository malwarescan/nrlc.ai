<?php
/**
 * Shared styles for all Promptware pages
 * Include this at the top of each page for consistent styling
 */
?>
<style>
/* Base container styling */
main.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1rem;
}

/* Section spacing */
section {
  margin-bottom: 3rem;
}

header {
  margin-bottom: 3rem;
}

/* Typography - consistent font sizes */
h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
}

p {
  line-height: 1.6;
  margin-bottom: 1rem;
}

ul, ol {
  margin-left: 1.5rem;
  margin-bottom: 1rem;
}

li {
  margin-bottom: 0.5rem;
}

/* Code blocks */
pre {
  padding: 1rem;
  background: var(--background-color, #fff);
  border: 1px solid var(--border-color, #ddd);
  overflow-x: auto;
  word-wrap: break-word;
  white-space: pre-wrap;
  margin-bottom: 1rem;
}

code {
  word-wrap: break-word;
  white-space: pre-wrap;
}

/* Tables */
table {
  width: 100%;
  margin-top: 1rem;
  border-collapse: collapse;
}

th, td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid var(--border-color, #ddd);
}

th {
  font-weight: bold;
  background: var(--background-color, #f5f5f5);
}

/* Navigation breadcrumbs */
nav[aria-label="breadcrumb"] {
  font-size: 0.875rem;
  margin-bottom: 1rem;
}

/* FAQ/Details styling */
details {
  padding: 1rem;
  border: 1px solid var(--border-color, #ddd);
  margin-bottom: 0.5rem;
}

summary {
  font-weight: bold;
  cursor: pointer;
}

details p {
  margin-top: 0.75rem;
}

/* Footer */
footer {
  margin-top: 4rem;
  padding-top: 2rem;
  border-top: 1px solid var(--border-color, #ddd);
}

/* Mobile responsive styles */
@media (max-width: 768px) {
  main.container {
    padding: 1rem 0.5rem !important;
  }
  
  h1 {
    font-size: 1.5rem !important;
  }
  
  h2 {
    font-size: 1.25rem !important;
  }
  
  p, li {
    font-size: 0.875rem !important;
  }
  
  pre {
    font-size: 0.75rem !important;
    padding: 0.75rem !important;
  }
  
  nav ul li {
    font-size: 0.875rem !important;
    margin-bottom: 1rem !important;
  }
  
  nav[aria-label="breadcrumb"] {
    font-size: 0.75rem !important;
  }
  
  table {
    font-size: 0.875rem !important;
    display: block !important;
    overflow-x: auto !important;
  }
  
  thead, tbody, tr {
    display: block !important;
  }
  
  td, th {
    display: block !important;
    text-align: left !important;
    padding: 0.5rem !important;
  }
  
  th {
    border-bottom: 2px solid var(--border-color, #ddd);
    font-weight: bold;
  }
  
  td {
    border-bottom: 1px solid var(--border-color, #ddd);
  }
  
  td:before {
    content: attr(data-label) ": ";
    font-weight: bold;
  }
  
  details {
    padding: 0.75rem !important;
  }
  
  details summary {
    font-size: 0.875rem !important;
  }
}

/* Force light theme on Promptware pages regardless of system preference */
main.container,
main.container * {
  background-color: white !important;
  color: #000000 !important;
}

main.container h1,
main.container h2,
main.container h3,
main.container h4,
main.container h5,
main.container h6 {
  color: #000000 !important;
}

main.container p,
main.container li,
main.container span,
main.container div {
  color: #000000 !important;
}

main.container a {
  color: #0066cc !important;
}

main.container a:hover {
  color: #ff6600 !important;
}

main.container pre {
  background: #fff !important;
  border-color: #ddd !important;
}

main.container code {
  color: #000000 !important;
}

main.container details {
  background: white !important;
  border-color: #ddd !important;
}

main.container details summary {
  color: #000000 !important;
}

main.container table {
  background: white !important;
}

main.container th {
  background: #f5f5f5 !important;
  color: #000000 !important;
}

main.container td {
  background: white !important;
  color: #000000 !important;
}
</style>

