#!/bin/bash
# Quick script to check GSC crawler status

echo "=== GSC Crawler Status Check ==="
echo ""

# Check if process is running
PID=$(pgrep -f "gsc_crawl_validator.php" | head -1)

if [ -z "$PID" ]; then
    echo "❌ Script is NOT running"
    echo ""
    echo "Checking for output files..."
    if [ -f "gsc_validation_report.csv" ]; then
        echo "✅ Output CSV exists: $(wc -l < gsc_validation_report.csv) lines"
        echo "Last processed URL:"
        tail -2 gsc_validation_report.csv | head -1 | cut -d',' -f1
    else
        echo "❌ No output CSV found"
    fi
    exit 1
fi

echo "✅ Script IS running (PID: $PID)"
echo ""

# Show process details
echo "Process Details:"
ps -p $PID -o pid,etime,pcpu,pmem,command 2>/dev/null | tail -1
echo ""

# Estimate progress (if we can count processed URLs)
if [ -f "gsc_validation_report.csv" ]; then
    PROCESSED=$(wc -l < gsc_validation_report.csv)
    TOTAL=712  # 711 URLs + 1 header
    if [ $PROCESSED -gt 1 ]; then
        PROGRESS=$(( ($PROCESSED - 1) * 100 / 711 ))
        echo "📊 Progress: $PROGRESS% ($(($PROCESSED - 1))/711 URLs)"
        echo "Last processed:"
        tail -2 gsc_validation_report.csv | head -1 | cut -d',' -f1
    fi
else
    echo "⏳ Output CSV not created yet (will be created at the end)"
    echo "   Script is still processing URLs..."
fi

echo ""
echo "To monitor in real-time, run:"
echo "  watch -n 2 'ps aux | grep gsc_crawl_validator | grep -v grep'"
echo ""
echo "To see when it finishes, run:"
echo "  while ps -p $PID > /dev/null; do sleep 5; done; echo 'Script completed!'"

