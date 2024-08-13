<div class="nav-header d-flex justify-content-between nav-pages">
  <div class="header-title d-flex align-items-center justify-content-center ps-3">
    {{-- <a href="{{ route('menu', ['type' => session()->get('type')]) }}" class="back-btn me-3 position-relative counter-anchor"> --}}
    <a href="{{ route('filament.admin.resources.running-times.index') }}" class="back-btn me-3 position-relative counter-anchor" onclick="showLoading()">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="title">
      {{ $title ?? 'Kembali' }}
    </div>
  </div>
</div>