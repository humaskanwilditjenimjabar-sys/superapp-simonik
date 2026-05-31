<x-app-layout title="{{ isset($id) ? 'Edit Izin Tinggal' : 'Input Izin Tinggal' }}">
    @livewire(\App\Livewire\Operator\Doklan\InputLayananIzinTinggal::class, ['id' => $id ?? null])
</x-app-layout>
