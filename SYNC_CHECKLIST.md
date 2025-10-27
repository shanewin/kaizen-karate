# Index.php ↔ Testing.php Sync Checklist

## When to Sync
- After making CSS/styling changes to index.php
- After adding new JavaScript functionality
- After modifying HTML structure (outside of CMS content)

## What Needs Syncing
- All `<style>` blocks
- JavaScript functions (outside of CMS-driven content)  
- HTML structure changes
- Media queries and responsive design updates

## How to Sync

### Option 1: Use the Sync Script
```bash
php sync-files.php
```
Or visit: `yoursite.com/sync-files.php` (requires admin login)

### Option 2: Manual Copy
1. Copy the `<style>` section from index.php
2. Replace the `<style>` section in testing.php
3. Test both files to ensure they look identical

### Option 3: Use Shared CSS File
Include `includes/shared-styles.css` in both files instead of inline styles.

## Recent Changes That Need Syncing
- ✅ Kaizen Kenpo navigation tabs/dropdown (completed)
- [ ] Service Areas styling
- [ ] Instructor image positioning  
- [ ] Accordion title sizing

## Verification
After syncing, check:
- [ ] Both sites look identical
- [ ] All responsive breakpoints work the same
- [ ] Interactive elements function properly
- [ ] No broken styling or layout issues