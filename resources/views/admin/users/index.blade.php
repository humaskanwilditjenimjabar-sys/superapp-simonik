<x-app-layout title="Manajemen User">
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => showToast("{{ session('success') }}", 'success'), 100);
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => showToast("{{ session('error') }}", 'error'), 100);
            });
        </script>
    @endif
    @livewire('admin.users.list-users')
</x-app-layout>
