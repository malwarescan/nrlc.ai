#!/bin/bash
# QA Script for All Service Pages from Performance CSV
# Tests H1, CTA, and Meta alignment for intent taxonomy

BASE_URL="http://localhost:8000"
FAILED=0
PASSED=0
TOTAL=0

echo "=== Service Intent Taxonomy QA ==="
echo ""

# Extract URLs from CSV (skip header, get first column)
while IFS=',' read -r url rest; do
  # Skip header and empty lines
  [[ "$url" == "Top pages" ]] && continue
  [[ -z "$url" ]] && continue
  
  # Remove quotes if present
  url=$(echo "$url" | tr -d '"')
  
  # Only test /services/ pages
  if [[ "$url" != *"/services/"* ]]; then
    continue
  fi
  
  TOTAL=$((TOTAL + 1))
  
  # Extract path from full URL
  path=$(echo "$url" | sed 's|https://nrlc.ai||')
  
  echo "Testing: $path"
  
  # Fetch page
  HTML=$(curl -s -L "${BASE_URL}${path}" 2>&1)
  
  if [ $? -ne 0 ]; then
    echo "  ❌ FAIL: Could not fetch page"
    FAILED=$((FAILED + 1))
    continue
  fi
  
  # Extract H1
  H1=$(echo "$HTML" | grep -oP '<h1[^>]*>.*?</h1>' | head -1 | sed 's/<[^>]*>//g' | xargs)
  
  # Extract CTA button text
  CTA=$(echo "$HTML" | grep -oP 'onclick="openContactSheet\([^)]+\)"[^>]*>.*?</button>' | sed 's/.*>\(.*\)<\/button>/\1/' | head -1 | xargs)
  
  # Extract meta title
  TITLE=$(echo "$HTML" | grep -oP '<title>.*?</title>' | sed 's/<[^>]*>//g' | xargs)
  
  # Extract meta description
  DESC=$(echo "$HTML" | grep -oP '<meta name="description" content="[^"]*"' | sed 's/.*content="\([^"]*\)".*/\1/' | head -1)
  
  # Check 1: H1 exists and is not empty
  if [ -z "$H1" ]; then
    echo "  ❌ FAIL: No H1 found"
    FAILED=$((FAILED + 1))
    continue
  fi
  
  # Check 2: CTA exists and names service (not generic)
  if [ -z "$CTA" ]; then
    echo "  ❌ FAIL: No CTA found"
    FAILED=$((FAILED + 1))
    continue
  fi
  
  # Check 3: CTA is not generic
  GENERIC_CTAS=("Contact us" "Learn more" "Get in touch" "Book a call")
  IS_GENERIC=0
  for generic in "${GENERIC_CTAS[@]}"; do
    if echo "$CTA" | grep -qi "$generic"; then
      IS_GENERIC=1
      break
    fi
  done
  
  if [ $IS_GENERIC -eq 1 ]; then
    echo "  ❌ FAIL: Generic CTA detected: '$CTA'"
    FAILED=$((FAILED + 1))
    continue
  fi
  
  # Check 4: Meta title follows formula (for geo pages)
  if [[ "$path" == *"/services/"*"/"*"/" ]]; then
    # Geo service page - should have "in {Location}"
    if ! echo "$TITLE" | grep -qi " in "; then
      echo "  ⚠️  WARN: Meta title may not follow geo formula: '$TITLE'"
    fi
  fi
  
  # Check 5: Meta description references service
  if [ -z "$DESC" ]; then
    echo "  ⚠️  WARN: No meta description found"
  fi
  
  echo "  ✅ PASS"
  echo "     H1: $H1"
  echo "     CTA: $CTA"
  echo "     Title: $TITLE"
  echo ""
  
  PASSED=$((PASSED + 1))
  
done < /Users/malware/Downloads/nrlc.ai-Performance-on-Search-2025-12-27/Pages.csv

echo "=== Summary ==="
echo "Total tested: $TOTAL"
echo "Passed: $PASSED"
echo "Failed: $FAILED"

if [ $FAILED -eq 0 ]; then
  echo "✅ All pages passed QA"
  exit 0
else
  echo "❌ Some pages failed QA"
  exit 1
fi

