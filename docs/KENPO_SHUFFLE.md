# Kaizen Kenpo Tabbed Interface Guide

## Overview
The Kaizen Kenpo section now features a modern tabbed interface with two tabs:
- **About Kenpo**: Static logo and information
- **Photo Gallery**: Image shuffle with training photos

## How to Add New Images with Captions

### Step 1: Add Your Images
1. Place your new images in the `/assets/images/kenpo/shuffle/` folder
2. Use web-optimized formats (webp, jpg, png)
3. Recommended dimensions: 700px width minimum for best quality

### Step 2: Add the Image to the Gallery Tab

Open `index.php` and find the "Photo Gallery Tab" section (inside `#gallery-content`). Add a new slide div before the navigation dots:

```html
<!-- Image 3: Your New Photo -->
<div class="shuffle-slide" data-caption="Your custom caption here">
  <img src="assets/images/kenpo/shuffle/YOUR_IMAGE.webp" 
       alt="Descriptive alt text">
</div>
```

### Step 3: Add a Navigation Dot

In the same gallery section, add a new dot to the navigation:

```html
<span class="shuffle-dot" onclick="currentSlide(3)" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); cursor: pointer; transition: all 0.3s ease;"></span>
```

*Note: Update the number (3) to match your slide position*

### Current Tabs & Content:

#### **About Kenpo Tab**:
- Kaizen Kenpo logo (static)
- Program description and information
- "Visit Kaizen Kenpo Website" button

#### **Photo Gallery Tab**:
1. **IMG_5336.webp**: "Advanced Kenpo training techniques in action"
2. **IMG_0126.webp**: "Students practicing traditional Chinese Kenpo forms"

### Caption Guidelines:

- Keep captions concise (under 60 characters)
- Describe what's happening in the image
- Use present tense
- Maintain professional tone
- Examples:
  - "Students demonstrating defensive techniques"
  - "Master instructor teaching traditional forms"
  - "Advanced sparring practice session"
  - "Belt testing ceremony in progress"

### Features Included:

✅ **Auto-Advance**: Changes slides every 5 seconds
✅ **Pause on Hover**: Stops auto-advance when hovering
✅ **Manual Navigation**: Click arrows or dots to navigate
✅ **Smooth Transitions**: Fade-in animation between slides
✅ **Responsive Design**: Adapts to mobile devices
✅ **Captions**: Each image displays custom caption text

### Programmatic Adding (JavaScript):

You can also add images programmatically using JavaScript:

```javascript
addShuffleImage(
    'assets/images/kenpo/shuffle/new-image.webp',
    'Your caption text here',
    'Alt text for accessibility'
);
```

### File Structure:
```
assets/images/kenpo/shuffle/
├── IMG_5336.webp
├── IMG_0126.webp
└── [your new images here]
```

### Testing:
1. Load the website
2. Navigate to the Kaizen Kenpo section
3. Verify images load correctly
4. Check captions display properly
5. Test navigation (arrows, dots, auto-advance)
6. Test on mobile devices 