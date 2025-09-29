<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class SettingsController extends Controller
{
    /**
     * Display system settings page
     */
    public function index()
    {
        return view('admin.dashboard.settings');
    }

    /**
     * Update payment methods settings
     */
    public function updatePaymentMethods(Request $request)
    {
        $request->validate([
            'gcash_enabled' => 'boolean',
            'cod_enabled' => 'boolean',
        ]);

        // Store payment method settings in config or database
        // For now, we'll use a simple config file approach
        $settings = [
            'gcash_enabled' => $request->has('gcash_enabled'),
            'cod_enabled' => $request->has('cod_enabled'),
        ];

        // Save to config file (you might want to use database instead)
        file_put_contents(
            config_path('payment_methods.php'),
            '<?php return ' . var_export($settings, true) . ';'
        );

        return redirect()->route('admin.dashboard.settings')
            ->with('success', 'Payment methods updated successfully!');
    }

    /**
     * Get storage usage statistics
     */
    public function getStorageStats()
    {
        $menuImagesPath = storage_path('app/public/menu-images');
        $totalFiles = 0;
        $totalSize = 0;
        $usedFiles = 0;
        $usedSize = 0;

        if (File::exists($menuImagesPath)) {
            $allFiles = File::allFiles($menuImagesPath);
            $usedImagePaths = Product::pluck('image_path')->filter()->toArray();

            foreach ($allFiles as $file) {
                $relativePath = 'menu-images/' . $file->getFilename();
                $fileSize = $file->getSize();
                
                $totalFiles++;
                $totalSize += $fileSize;

                if (in_array($relativePath, $usedImagePaths)) {
                    $usedFiles++;
                    $usedSize += $fileSize;
                }
            }
        }

        return response()->json([
            'total_files' => $totalFiles,
            'total_size' => $totalSize,
            'used_files' => $usedFiles,
            'used_size' => $usedSize,
            'orphaned_files' => $totalFiles - $usedFiles,
            'orphaned_size' => $totalSize - $usedSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2),
            'used_size_mb' => round($usedSize / 1024 / 1024, 2),
            'orphaned_size_mb' => round(($totalSize - $usedSize) / 1024 / 1024, 2)
        ]);
    }

    /**
     * Clean up orphaned images from storage
     */
    public function cleanupOrphanedImages()
    {
        $menuImagesPath = storage_path('app/public/menu-images');
        
        if (!File::exists($menuImagesPath)) {
            return response()->json([
                'message' => 'Menu images directory does not exist',
                'deleted' => 0
            ]);
        }

        // Get all image files in storage
        $storedImages = File::allFiles($menuImagesPath);
        $deletedCount = 0;
        $errors = [];

        // Get all image paths currently referenced in database
        $usedImagePaths = Product::pluck('image_path')->filter()->toArray();

        foreach ($storedImages as $imageFile) {
            $relativePath = 'menu-images/' . $imageFile->getFilename();
            
            // If image is not referenced in database, delete it
            if (!in_array($relativePath, $usedImagePaths)) {
                try {
                    File::delete($imageFile->getPathname());
                    $deletedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to delete {$relativePath}: " . $e->getMessage();
                }
            }
        }

        $result = [
            'message' => "Cleanup completed. Deleted {$deletedCount} orphaned images.",
            'deleted' => $deletedCount,
            'errors' => $errors
        ];

        if (!empty($errors)) {
            \Log::warning('Image cleanup errors:', $errors);
        }

        return response()->json($result);
    }

    /**
     * Get current payment method settings
     */
    public function getPaymentSettings()
    {
        $configPath = config_path('payment_methods.php');
        
        if (file_exists($configPath)) {
            $settings = include $configPath;
        } else {
            // Default settings
            $settings = [
                'gcash_enabled' => true,
                'cod_enabled' => true,
            ];
        }

        return response()->json($settings);
    }
}