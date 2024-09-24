<!-- Menu -->
<style>
  /* Sidebar Styling */
.layout-menu {
    background-color: #ffffff; /* Lighter background for sidebar */
    color: #2c3e50; /* Darker text color for readability */
    padding-top: 15px;
    border-right: 1px solid #e0e0e0; /* Subtle border for definition */
}

.layout-menu .menu-link {
    padding: 12px 20px;
    transition: all 0.3s ease;
    border-radius: 8px; /* Rounded menu links */
    color: #2c3e50; /* Darker text for better contrast on white */
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.layout-menu .menu-link:hover {
    background-color: #f0f4f7; /* Light grey background on hover */
    color: #1abc9c; /* Green accent color on hover */
}

.layout-menu .menu-item.active .menu-link {
    background-color: #1abc9c; /* Active item background */
    color: white; /* White text for active items */
}

.menu-inner {
    padding-top: 20px;
    padding-bottom: 20px;
}

.layout-menu .menu-icon {
    margin-right: 15px;
    color: #95a5a6; /* Lighter grey for icons */
}

.layout-menu .menu-link:hover .menu-icon,
.layout-menu .menu-item.active .menu-icon {
    color: #1abc9c; /* Green icon on hover or active state */
}

.layout-menu .submenu {
    display: none;
    padding-left: 30px;
}

.layout-menu .submenu .menu-link {
    padding: 10px 15px;
    color: #34495e; /* Submenu text color */
}

.layout-menu .submenu .menu-link:hover {
    background-color: #eafaf1; /* Light green hover effect for submenu */
    color: #1abc9c; /* Green text on submenu hover */
}

.submenu-toggle-icon {
    transition: transform 0.3s ease;
}

.rotate-icon {
    transform: rotate(180deg);
}

/* Custom scrollbar */
.layout-menu {
    scrollbar-width: thin;
    scrollbar-color: #95a5a6 #ffffff;
}

.layout-menu::-webkit-scrollbar {
    width: 8px;
}

.layout-menu::-webkit-scrollbar-track {
    background: #ffffff;
}

.layout-menu::-webkit-scrollbar-thumb {
    background-color: #95a5a6;
    border-radius: 10px;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Sidebar Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a class="d-flex align-items-center gap-3 flex-shrink-0">
            <div class="position-relative flex-shrink-0">
                <img style="width: 180px" src="{{ asset('dashboard/assets/logo.jpeg') }}" alt="Logo" class="logo-text">
            </div>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="align-middle ti ti-x"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">
        <li class="menu-item @if(Request::is('customers*')) active @endif">
            <a href="{{ route('customers.index') }}" class="menu-link">
                <i class="menu-icon fas fa-people"></i>
                <div>customer</div>
            </a>
        </li>
        <li class="menu-item @if(Request::is('invoices*')) active @endif">
            <a href="{{ route('invoices.index') }}" class="menu-link">
                <i class="menu-icon fas fa-info-circle"></i>
                <div>invoices</div>
            </a>
        </li>
        <li class="menu-item @if(Request::is('logs*')) active @endif">
            <a href="{{ route('invoices.logs.index') }}" class="menu-link">
                <i class="menu-icon fas fa-info-circle"></i>
                <div>logs</div>
            </a>
        </li>

    </li>
    </ul>

    </ul>
</aside>

<!-- jQuery for Submenu Toggle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle submenu
        $('.toggle-submenu').click(function() {
            $(this).next('.submenu').slideToggle(300);
            $(this).find('.submenu-toggle-icon').toggleClass('rotate-icon');
        });
    });
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- / Menu -->
