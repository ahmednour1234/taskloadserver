<nav
class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
id="layout-navbar">
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
  <a class="nav-item nav-link px-0 me-xl-4" id="sidebarToggle1" href="javascript:void(0)">
    <i class="ti ti-menu-2 ti-sm"></i>
  </a>
</div>


<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


  <ul class="navbar-nav flex-row align-items-center ms-auto">


    <!-- User -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
<img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="h-auto rounded-circle" />
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="pages-account-settings-account.html">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-online">
<img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="h-auto rounded-circle" />
                </div>
              </div>
              <div class="flex-grow-1">
                <small class="text-muted">Admin</small>
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>



        <li>
            <form method="post" action="{{ route('invoices.logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="ti ti-logout me-2 ti-sm"></i>
                    <span class="align-middle">logout</span>
                  </button>
            </form>
        </li>
      </ul>
    </li>
    <!--/ User -->
  </ul>
</div>

<!-- Search Small Screens -->
<div class="navbar-search-wrapper search-input-wrapper d-none">
  <input
    type="text"
    class="form-control search-input container-xxl border-0"
    placeholder="Search..."
    aria-label="Search..." />
  <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
</div>
</nav>

