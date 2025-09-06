<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">Placeholder - no orders implemented yet.</p>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                            <th class="py-2 pr-4">ID</th>
                            <th class="py-2 pr-4">Customer</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4">Total</th>
                            <th class="py-2 pr-4">Created</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 dark:text-gray-400">No orders yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

