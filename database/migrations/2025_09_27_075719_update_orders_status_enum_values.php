<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing data to match new enum values
        DB::table('orders')->where('status', 'paid')->update(['status' => 'confirmed']);
        DB::table('orders')->where('status', 'shipped')->update(['status' => 'delivered']);
        
        // Modify the column to use the new enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::table('orders')->where('status', 'confirmed')->update(['status' => 'pending']);
        DB::table('orders')->where('status', 'preparing')->update(['status' => 'pending']);
        DB::table('orders')->where('status', 'ready')->update(['status' => 'pending']);
        
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }
};