#!/bin/bash

# WordPress Migration Toolkit - Site Analysis Script
# This script analyzes an existing HTML website for migration preparation

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to show usage
usage() {
    echo "Usage: $0 SITE_PATH [OUTPUT_DIR]"
    echo ""
    echo "Arguments:"
    echo "  SITE_PATH    Path to the original HTML website"
    echo "  OUTPUT_DIR   Directory to save analysis results (optional)"
    echo ""
    echo "Example:"
    echo "  $0 examples/my-site/"
    echo "  $0 /path/to/site analysis-results/"
}

# Check arguments
if [ $# -lt 1 ]; then
    print_error "Site path is required"
    usage
    exit 1
fi

SITE_PATH="$1"
OUTPUT_DIR="${2:-analysis-$(date +%Y%m%d_%H%M%S)}"

# Check if site path exists
if [ ! -d "$SITE_PATH" ]; then
    print_error "Site path does not exist: $SITE_PATH"
    exit 1
fi

print_status "Analyzing website at: $SITE_PATH"
print_status "Output directory: $OUTPUT_DIR"

# Create output directory
mkdir -p "$OUTPUT_DIR"

# Analysis functions
analyze_html_files() {
    print_status "Analyzing HTML files..."
    find "$SITE_PATH" -name "*.html" -o -name "*.htm" > "$OUTPUT_DIR/html-files.txt"
    HTML_COUNT=$(wc -l < "$OUTPUT_DIR/html-files.txt")
    print_success "Found $HTML_COUNT HTML files"
    
    # Find main index file
    if [ -f "$SITE_PATH/index.html" ]; then
        echo "$SITE_PATH/index.html" > "$OUTPUT_DIR/main-page.txt"
        print_success "Main page found: index.html"
    elif [ -f "$SITE_PATH/index.htm" ]; then
        echo "$SITE_PATH/index.htm" > "$OUTPUT_DIR/main-page.txt"
        print_success "Main page found: index.htm"
    else
        print_warning "No index.html or index.htm found"
        # Try to find the largest HTML file
        if [ $HTML_COUNT -gt 0 ]; then
            find "$SITE_PATH" -name "*.html" -exec wc -l {} + | sort -nr | head -1 | awk '{print $2}' > "$OUTPUT_DIR/main-page.txt"
            MAIN_PAGE=$(cat "$OUTPUT_DIR/main-page.txt")
            print_warning "Using largest HTML file as main page: $(basename "$MAIN_PAGE")"
        fi
    fi
}

analyze_css_files() {
    print_status "Analyzing CSS files..."
    find "$SITE_PATH" -name "*.css" > "$OUTPUT_DIR/css-files.txt"
    CSS_COUNT=$(wc -l < "$OUTPUT_DIR/css-files.txt")
    print_success "Found $CSS_COUNT CSS files"
    
    # Extract CSS variables and color palette
    if [ $CSS_COUNT -gt 0 ]; then
        print_status "Extracting design system..."
        grep -r ":root\|--.*:" "$SITE_PATH" 2>/dev/null | head -50 > "$OUTPUT_DIR/css-variables.txt" || touch "$OUTPUT_DIR/css-variables.txt"
        grep -r "color:\|background:" "$SITE_PATH" 2>/dev/null | head -50 > "$OUTPUT_DIR/color-palette.txt" || touch "$OUTPUT_DIR/color-palette.txt"
    fi
}

analyze_js_files() {
    print_status "Analyzing JavaScript files..."
    find "$SITE_PATH" -name "*.js" > "$OUTPUT_DIR/js-files.txt"
    JS_COUNT=$(wc -l < "$OUTPUT_DIR/js-files.txt")
    print_success "Found $JS_COUNT JavaScript files"
}

analyze_media_files() {
    print_status "Analyzing media files..."
    find "$SITE_PATH" \( -name "*.jpg" -o -name "*.jpeg" -o -name "*.png" -o -name "*.gif" -o -name "*.svg" -o -name "*.webp" \) > "$OUTPUT_DIR/image-files.txt"
    find "$SITE_PATH" \( -name "*.mp4" -o -name "*.avi" -o -name "*.mov" -o -name "*.webm" \) > "$OUTPUT_DIR/video-files.txt"
    find "$SITE_PATH" \( -name "*.mp3" -o -name "*.wav" -o -name "*.ogg" \) > "$OUTPUT_DIR/audio-files.txt"
    
    IMAGE_COUNT=$(wc -l < "$OUTPUT_DIR/image-files.txt")
    VIDEO_COUNT=$(wc -l < "$OUTPUT_DIR/video-files.txt")
    AUDIO_COUNT=$(wc -l < "$OUTPUT_DIR/audio-files.txt")
    
    print_success "Found $IMAGE_COUNT images, $VIDEO_COUNT videos, $AUDIO_COUNT audio files"
}

analyze_external_dependencies() {
    print_status "Analyzing external dependencies..."
    
    # Find external CSS/JS libraries
    grep -r "https\?://.*\.css\|https\?://.*\.js" "$SITE_PATH" 2>/dev/null | \
        grep -o "https\?://[^\"']*\.\(css\|js\)" | \
        sort | uniq > "$OUTPUT_DIR/external-dependencies.txt" || touch "$OUTPUT_DIR/external-dependencies.txt"
    
    DEPS_COUNT=$(wc -l < "$OUTPUT_DIR/external-dependencies.txt")
    print_success "Found $DEPS_COUNT external dependencies"
    
    # Common libraries detection
    if grep -q "font-awesome" "$OUTPUT_DIR/external-dependencies.txt"; then
        echo "Font Awesome" >> "$OUTPUT_DIR/detected-libraries.txt"
    fi
    if grep -q "bootstrap" "$OUTPUT_DIR/external-dependencies.txt"; then
        echo "Bootstrap" >> "$OUTPUT_DIR/detected-libraries.txt"
    fi
    if grep -q "jquery" "$OUTPUT_DIR/external-dependencies.txt"; then
        echo "jQuery" >> "$OUTPUT_DIR/detected-libraries.txt"
    fi
    if grep -q "googleapis.com/css.*fonts" "$OUTPUT_DIR/external-dependencies.txt"; then
        echo "Google Fonts" >> "$OUTPUT_DIR/detected-libraries.txt"
    fi
}

calculate_complexity() {
    print_status "Calculating migration complexity..."
    
    COMPLEXITY_SCORE=0
    
    # Base score from file counts
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + HTML_COUNT * 10))
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + CSS_COUNT * 15))
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + JS_COUNT * 20))
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + IMAGE_COUNT * 2))
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + VIDEO_COUNT * 5))
    
    # Add complexity for external dependencies
    COMPLEXITY_SCORE=$((COMPLEXITY_SCORE + DEPS_COUNT * 5))
    
    # Determine complexity level
    if [ $COMPLEXITY_SCORE -lt 100 ]; then
        COMPLEXITY_LEVEL="Simple"
        ESTIMATED_TIME="60-90 minutes"
    elif [ $COMPLEXITY_SCORE -lt 300 ]; then
        COMPLEXITY_LEVEL="Medium"
        ESTIMATED_TIME="2-3 hours"
    else
        COMPLEXITY_LEVEL="Complex"
        ESTIMATED_TIME="3-6 hours"
    fi
    
    echo "Complexity Score: $COMPLEXITY_SCORE" > "$OUTPUT_DIR/complexity-assessment.txt"
    echo "Complexity Level: $COMPLEXITY_LEVEL" >> "$OUTPUT_DIR/complexity-assessment.txt"
    echo "Estimated Migration Time: $ESTIMATED_TIME" >> "$OUTPUT_DIR/complexity-assessment.txt"
    
    print_success "Complexity Level: $COMPLEXITY_LEVEL (Score: $COMPLEXITY_SCORE)"
    print_success "Estimated Migration Time: $ESTIMATED_TIME"
}

generate_report() {
    print_status "Generating analysis report..."
    
    REPORT_FILE="$OUTPUT_DIR/analysis-report.md"
    
    cat > "$REPORT_FILE" << EOF
# Website Analysis Report

**Site Path:** \`$SITE_PATH\`  
**Analysis Date:** $(date)  
**Complexity Level:** $COMPLEXITY_LEVEL  
**Estimated Migration Time:** $ESTIMATED_TIME  

## File Summary
- **HTML Files:** $HTML_COUNT
- **CSS Files:** $CSS_COUNT
- **JavaScript Files:** $JS_COUNT
- **Images:** $IMAGE_COUNT
- **Videos:** $VIDEO_COUNT
- **Audio Files:** $AUDIO_COUNT
- **External Dependencies:** $DEPS_COUNT

## Detected Libraries
EOF

    if [ -f "$OUTPUT_DIR/detected-libraries.txt" ]; then
        while read -r library; do
            echo "- $library" >> "$REPORT_FILE"
        done < "$OUTPUT_DIR/detected-libraries.txt"
    else
        echo "- None detected" >> "$REPORT_FILE"
    fi

    cat >> "$REPORT_FILE" << EOF

## Migration Checklist
- [ ] Set up WordPress environment
- [ ] Create base theme structure
- [ ] Migrate HTML structure
- [ ] Import CSS styles
- [ ] Copy media files
- [ ] Integrate JavaScript functionality
- [ ] Test responsive design
- [ ] Verify all links and forms
- [ ] Performance optimization
- [ ] Final validation

## Files for Review
- Main HTML file: $(cat "$OUTPUT_DIR/main-page.txt" 2>/dev/null || echo "Not found")
- CSS files: See \`css-files.txt\`
- External dependencies: See \`external-dependencies.txt\`

## Next Steps
1. Run: \`./scripts/init-environment.sh PROJECT_NAME\`
2. Run: \`./scripts/create-theme.sh PROJECT_NAME $SITE_PATH\`
3. Begin manual migration following the SOP documentation
EOF

    print_success "Analysis report saved to: $REPORT_FILE"
}

# Run analysis
analyze_html_files
analyze_css_files
analyze_js_files
analyze_media_files
analyze_external_dependencies
calculate_complexity
generate_report

echo ""
echo "========================="
echo "📊 ANALYSIS COMPLETE!"
echo "========================="
echo "Results saved to: $OUTPUT_DIR/"
echo ""
echo "Key findings:"
echo "- Complexity: $COMPLEXITY_LEVEL"
echo "- Estimated time: $ESTIMATED_TIME"
echo "- HTML files: $HTML_COUNT"
echo "- CSS files: $CSS_COUNT"
echo "- JavaScript files: $JS_COUNT"
echo "- Media files: $((IMAGE_COUNT + VIDEO_COUNT + AUDIO_COUNT))"
echo ""
echo "View the full report: $OUTPUT_DIR/analysis-report.md"