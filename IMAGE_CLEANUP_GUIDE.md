# Image Cleanup Guide

This guide explains how to manage and clean up product images in the online karinderya system.

## Overview

The system automatically handles image cleanup in several scenarios:
- When a product image is replaced, the old image is deleted
- When a product is deleted, its associated image is deleted
- Orphaned images (not referenced in database) can be cleaned up manually

## Features

### 1. Automatic Cleanup
- **Image Replacement**: When updating a product with a new image, the old image is automatically deleted
- **Product Deletion**: When deleting a product, its image is automatically removed from storage

### 2. Manual Cleanup
- **Admin Panel**: Use the "Storage Stats" and "Cleanup Images" buttons in the Menus Management page
- **Console Command**: Run cleanup commands from the terminal

## Usage

### Admin Panel

1. **View Storage Statistics**:
   - Go to Admin Dashboard → Menus Management
   - Click "Storage Stats" button
   - View total files, used files, orphaned files, and storage sizes

2. **Clean Up Images**:
   - Go to Admin Dashboard → Menus Management
   - Click "Cleanup Images" button
   - Confirm the action in the modal
   - Orphaned images will be permanently deleted

### Console Commands

1. **Dry Run (Preview)**:
   ```bash
   php artisan images:cleanup --dry-run
   ```
   Shows what would be deleted without actually deleting files.

2. **Actual Cleanup**:
   ```bash
   php artisan images:cleanup
   ```
   Permanently deletes all orphaned images.

### Scheduled Cleanup (Optional)

To run cleanup automatically, add this to your `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Run image cleanup daily at 2 AM
    $schedule->command('images:cleanup')->dailyAt('02:00');
}
```

## Storage Statistics

The system tracks:
- **Total Files**: All image files in storage
- **Used Files**: Images referenced in the database
- **Orphaned Files**: Images not referenced in the database
- **Storage Sizes**: File sizes in MB for each category

## Safety Features

- **Dry Run Mode**: Preview what will be deleted before actual cleanup
- **Error Handling**: Failed deletions are logged and reported
- **Confirmation**: Admin panel requires confirmation before cleanup
- **Automatic Backup**: Old images are only deleted after successful new image upload

## File Structure

Images are stored in: `storage/app/public/menu-images/`
Database references: `products.image_path` field

## Troubleshooting

1. **Permission Issues**: Ensure the web server has write permissions to the storage directory
2. **Large Storage**: Use the dry-run command to see how much space can be freed
3. **Failed Deletions**: Check Laravel logs for specific error messages

## Best Practices

1. **Regular Cleanup**: Run cleanup weekly or monthly to prevent storage bloat
2. **Monitor Storage**: Check storage stats regularly to track usage
3. **Backup Important Images**: Consider backing up important product images before major cleanups
4. **Test First**: Always run dry-run before actual cleanup in production
