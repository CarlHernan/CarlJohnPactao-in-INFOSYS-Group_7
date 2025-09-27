<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
<script src="{{ asset('dist/js/waves.js') }}"></script>
<script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('dist/js/custom.min.js') }}"></script>

@if(request()->routeIs('dashboard'))
<!-- Dashboard-specific scripts -->
<script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/libs/chart.js/dist/Chart.min.js') }}"></script>
<!-- jVectorMap for world map -->
<script src="{{ asset('assets/libs/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>
@endif

<!-- Responsive Sidebar Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    // Check if sidebar should be open on page load (from localStorage)
    const isSidebarOpen = localStorage.getItem('sidebar-open') === 'true';
    if (isSidebarOpen && window.innerWidth < 1024) {
        openSidebar();
    }
    
    // Toggle sidebar
    function toggleSidebar() {
        if (sidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }
    
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarBackdrop.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        localStorage.setItem('sidebar-open', 'true');
    }
    
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarBackdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        localStorage.setItem('sidebar-open', 'false');
    }
    
    // Event listeners
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }
    
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar when clicking on menu links (mobile only)
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            // Desktop: always show sidebar, remove backdrop
            sidebar.classList.remove('-translate-x-full');
            sidebarBackdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        } else {
            // Mobile: check localStorage for sidebar state
            const isOpen = localStorage.getItem('sidebar-open') === 'true';
            if (isOpen) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth < 1024) {
            closeSidebar();
        }
    });
});
</script>

@stack('scripts')
