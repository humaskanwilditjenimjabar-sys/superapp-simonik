@php
    use App\Core\Services\PermissionService;
    $user = auth()->user();
    $currentRoute = request()->route()?->getName() ?? '';
    $modulesByBidang = PermissionService::modulesByBidang();

    // Icon SVG map — Tabler icons inline
    $icons = [
        'home' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
        'notebook' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
        'id-badge' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/>',
        'users' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>',
        'download' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>',
        'chart-bar' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
        'eye' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'shield' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
        'report' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        'mail' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>',
        'certificate' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>',
        'building-warehouse' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"/>',
        'file-plus' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
        'tags' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>',
        'book' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
        'history' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'plane-departure' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>',
        'dashboard' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>',
    ];

    $bidangLabels = [
        'doklan' => 'Doklan',
        'inteldakim' => 'Inteldakim',
        'tu' => 'Tata Usaha',
    ];
@endphp

{{-- Dashboard --}}
@php
    $dashRoute = match (true) {
        in_array($user->role, ['superadmin', 'admin_kakanwil']) => 'admin.dashboard',
        in_array($user->role, [
            'admin_kabid_doklan',
            'admin_kanwil_doklan',
            'admin_kabid_wasdakim',
            'admin_kanwil_wasdakim',
            'admin_kabag_tu',
            'admin_kanwil_tu',
        ])
            => 'kanwil.dashboard',
        $user->role === 'admin_kanim' => 'kanim.dashboard',
        default => 'operator.dashboard',
    };
@endphp
<a href="{{ route($dashRoute) }}"
    class="sk-nav-item {{ str_starts_with($currentRoute, 'admin.dashboard') || $currentRoute === 'kanwil.dashboard' || $currentRoute === 'kanim.dashboard' || $currentRoute === 'operator.dashboard' ? 'active' : '' }}">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        {!! $icons['dashboard'] !!}
    </svg>
    <span class="sk-nav-label">Dashboard</span>
</a>

{{-- Admin: User Management --}}
@if (in_array($user->role, ['superadmin', 'admin_kakanwil']))
    <div class="sk-nav-section">Administrasi</div>
    <a href="{{ route('admin.users.index') }}"
        class="sk-nav-item {{ str_starts_with($currentRoute, 'admin.users') ? 'active' : '' }}">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            {!! $icons['users'] !!}
        </svg>
        <span class="sk-nav-label">Manajemen User</span>
    </a>
@endif

{{-- Dynamic menu dari module_permissions --}}
@foreach ($modulesByBidang as $bidangCode => $modules)
    @php
        // Ambil hanya parent modules (yang tidak punya parent_code)
        $parents = $modules->whereNull('parent_code')->sortBy('urutan');
    @endphp

    @if ($parents->isNotEmpty())
        <div class="sk-nav-section">{{ $bidangLabels[$bidangCode] ?? strtoupper($bidangCode) }}</div>

        @foreach ($parents as $parent)
            @php
                $children = $modules->where('parent_code', $parent->module_code)->sortBy('urutan');
                $hasChildren = $children->isNotEmpty();
                $groupId = 'grp-' . str_replace('.', '-', $parent->module_code);

                // Cek apakah group ini aktif
                $isGroupActive = $children->contains(function ($child) use ($currentRoute) {
                    return $child->route_name && str_starts_with($currentRoute, $child->route_name);
                });
            @endphp

            @if ($hasChildren)
                {{-- Group dengan collapse --}}
                <div x-data="{ open: {{ $isGroupActive ? 'true' : 'false' }} }">
                    <button type="button" @click="open = !open" class="sk-nav-item w-full"
                        style="justify-content:space-between;">
                        <span style="display:flex;align-items:center;gap:0.5rem;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                {!! $icons[$parent->icon] ?? $icons['notebook'] !!}
                            </svg>
                            <span class="sk-nav-label">{{ $parent->nama_modul }}</span>
                        </span>
                        <svg class="sk-nav-label transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                            style="width:0.75rem;height:0.75rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        style="padding-left:0.75rem;">
                        @foreach ($children as $child)
                            @php
                                $isActive = $child->route_name && str_starts_with($currentRoute, $child->route_name);
                                $href = $child->route_name ? route($child->route_name) : '#';
                            @endphp
                            <a href="{{ $href }}" class="sk-nav-item {{ $isActive ? 'active' : '' }}"
                                style="font-size:0.75rem;padding:0.375rem 0.625rem;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    {!! $icons[$child->icon] ?? $icons['file-plus'] !!}
                                </svg>
                                <span class="sk-nav-label">{{ $child->nama_modul }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Single menu item --}}
                @php
                    $isActive = $parent->route_name && str_starts_with($currentRoute, $parent->route_name);
                    $href = $parent->route_name ? route($parent->route_name) : '#';
                @endphp
                <a href="{{ $href }}" class="sk-nav-item {{ $isActive ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        {!! $icons[$parent->icon] ?? $icons['notebook'] !!}
                    </svg>
                    <span class="sk-nav-label">{{ $parent->nama_modul }}</span>
                </a>
            @endif
        @endforeach
    @endif
@endforeach
