<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">

        <ul class="nav flex-column">
            {{-- Meni Item --}}
            @component('layouts.partials.menu_item',
            [
                'link' => route('dashboard.index'),
                'label' => 'Dashboard',
                'active' => request()->is('dashboard/index'),
                'permission' => checkPermission('role-list'),
            ])
            @endcomponent
            {{-- Meni Item --}}
            @component('layouts.partials.menu_item',
            [
                'link' => route('dashboard.users.index'),
                'label' => 'Users',
                'active' => request()->is('dashboard/users*'),
                'permission' => checkPermission('user-edit'),
            ])
            @endcomponent
            {{-- Meni Item --}}
            @component('layouts.partials.menu_item',
            [
                'link' => route('dashboard.schedules.index'),
                'label' => 'Schedules',
                'active' => request()->is('dashboard/schedules*'),
                'permission' => checkPermission('schedule-edit'),
            ])
            @endcomponent
        </ul>
    </div>
</nav>
