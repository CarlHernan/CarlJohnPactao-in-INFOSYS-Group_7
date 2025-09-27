<!-- Mobile backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gray-800 text-gray-200 flex-shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full overflow-y-auto">
        <!-- Mobile close button -->
        <div class="lg:hidden flex justify-end p-4">
            <button id="sidebar-close" class="text-gray-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <li class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Personal
                </li>

                <li>
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-link flex items-center p-2 rounded-md hover:bg-gray-700">
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
                       class="sidebar-link flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <circle cx="12" cy="12" r="10"/>
                             <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span>Manage Menus</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.categories') }}"
                       class="sidebar-link flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Categories</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.orders') }}"
                       class="sidebar-link flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Orders</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dashboard.payments') }}"
                       class="sidebar-link flex items-center p-2 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Payments</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
