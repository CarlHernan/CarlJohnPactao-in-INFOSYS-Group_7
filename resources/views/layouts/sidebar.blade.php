<div>
<aside class="w-64 bg-gray-800 text-gray-200 min-h-screen">
    <div class="h-full overflow-y-auto">
        <nav class="p-4">
            <ul class="space-y-2">
                <li class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Personal
                </li>

                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18"/>
                        </svg>
                        <span>Dashboard</span>
                        <span class="ml-auto bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">3</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.menus') }}"
                       class="flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span>Manage Menus</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
</div>
