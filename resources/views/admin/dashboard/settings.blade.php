@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
        <p class="mt-2 text-sm text-gray-600">Configure system-wide settings and manage storage</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Methods Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Payment Methods</h2>
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-6">Enable or disable payment methods for customer orders</p>
            
            <form id="paymentSettingsForm" method="POST" action="{{ route('admin.dashboard.settings.payment-methods') }}">
                @csrf
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="gcash_enabled" class="text-sm font-medium text-gray-900">GCash</label>
                                <p class="text-xs text-gray-500">Digital wallet payment method</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="gcash_enabled" name="gcash_enabled" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="cod_enabled" class="text-sm font-medium text-gray-900">Cash on Delivery (COD)</label>
                                <p class="text-xs text-gray-500">Pay when order is delivered</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="cod_enabled" name="cod_enabled" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Save Payment Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Storage Management -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Storage Management</h2>
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-6">Manage product images and storage usage</p>
            
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Storage Statistics</h3>
                    <div id="storageStats" class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Loading...</span>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button onclick="refreshStorageStats()" 
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Refresh Stats
                    </button>
                    <button onclick="showCleanupModal()" 
                            class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Cleanup Images
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cleanup Confirmation Modal -->
<div id="cleanupModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Cleanup Images</h3>
                <button onclick="closeCleanupModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="text-sm text-gray-600 mb-4">
                This will permanently delete all orphaned images that are no longer referenced in the database. This action cannot be undone.
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeCleanupModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
                    Cancel
                </button>
                <button onclick="confirmCleanup()" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md">
                    Cleanup Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Load payment settings on page load
document.addEventListener('DOMContentLoaded', function() {
    loadPaymentSettings();
    refreshStorageStats();
});

function loadPaymentSettings() {
    fetch('{{ route("admin.dashboard.settings.payment-settings") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('gcash_enabled').checked = data.gcash_enabled;
            document.getElementById('cod_enabled').checked = data.cod_enabled;
        })
        .catch(error => {
            console.error('Error loading payment settings:', error);
        });
}

function refreshStorageStats() {
    fetch('{{ route("admin.dashboard.settings.storage-stats") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('storageStats').innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Files:</span>
                        <span class="font-medium">${data.total_files}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Used Files:</span>
                        <span class="font-medium text-green-600">${data.used_files}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Orphaned Files:</span>
                        <span class="font-medium text-red-600">${data.orphaned_files}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Size:</span>
                        <span class="font-medium">${data.total_size_mb} MB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Used Size:</span>
                        <span class="font-medium text-green-600">${data.used_size_mb} MB</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Orphaned Size:</span>
                        <span class="font-medium text-red-600">${data.orphaned_size_mb} MB</span>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('storageStats').innerHTML = '<p class="text-red-600">Error loading storage statistics</p>';
        });
}

function showCleanupModal() {
    document.getElementById('cleanupModal').classList.remove('hidden');
}

function closeCleanupModal() {
    document.getElementById('cleanupModal').classList.add('hidden');
}

function confirmCleanup() {
    const button = event.target;
    button.disabled = true;
    button.textContent = 'Cleaning...';
    
    fetch('{{ route("admin.dashboard.settings.cleanup-images") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeCleanupModal();
        if (data.deleted > 0) {
            refreshStorageStats(); // Refresh stats after cleanup
        }
    })
    .catch(error => {
        alert('Error during cleanup: ' + error.message);
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = 'Cleanup Now';
    });
}
</script>
@endsection
