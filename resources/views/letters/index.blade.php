@extends('layout')

@section('title', 'Arsip Surat')
@section('subtitle',
    'Berikut ini adalah surat-surat yang telah terbit dan diarsipkan. Klik "Lihat" pada kolom aksi
    untuk menampilkan surat.')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('letters.index') }}" class="text-decoration-none">Arsip Surat</a>
    </li>
    <li class="breadcrumb-item active">Daftar Surat</li>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Search and Actions -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('letters.index') }}" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="search" id="searchInput" class="form-control search-input"
                                    placeholder="Cari surat berdasarkan nomor atau judul..." value="{{ request('search') }}"
                                    autocomplete="off">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('letters.create') }}" class="btn btn-primary w-100 w-md-auto">
                                <i class="bi bi-plus-circle me-1"></i>Arsipkan Surat
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Letters List -->
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">
                                <i class="bi bi-archive me-2"></i>Daftar Arsip Surat
                                @if (request('search'))
                                    <small class="text-muted ms-2">
                                        Hasil pencarian: "{{ request('search') }}"
                                    </small>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Nomor Surat</th>
                                <th class="border-0">Kategori</th>
                                <th class="border-0">Judul</th>
                                <th class="border-0">Waktu Pengarsipan</th>
                                <th class="border-0 text-center" style="width: 200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($letters as $letter)
                                <tr>
                                    <td class="align-middle">
                                        <div class="text-body-secondary">{{ $letter->nomor_surat }}</div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="badge bg-light text-dark border">
                                            {{ $letter->category->nama_kategori }}
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="fw-medium text-wrap">{{ $letter->judul }}</div>
                                    </td>
                                    <td class="align-middle text-nowrap">
                                        <i class="bi bi-calendar2 me-1 text-muted"></i>
                                        {{ $letter->formatted_created_at }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('letters.show', $letter) }}" class="btn btn-sm btn-light"
                                                data-bs-toggle="tooltip" title="Lihat Detail & Preview">
                                                <i class="bi bi-file-earmark-text text-primary"></i>
                                            </a>
                                            <a href="{{ route('letters.download', $letter) }}" class="btn btn-sm btn-light"
                                                data-bs-toggle="tooltip" title="Unduh PDF">
                                                <i class="bi bi-download text-success"></i>
                                            </a>
                                            <form method="POST" action="{{ route('letters.destroy', $letter) }}"
                                                class="d-inline" onsubmit="event.preventDefault(); showDeleteModal(this);">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                    title="Hapus Surat">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <div class="text-muted">
                                            <i class="bi bi-file-earmark-x display-6 d-block mb-3"></i>
                                            @if (request('search'))
                                                Tidak ditemukan surat yang sesuai dengan pencarian
                                                "{{ request('search') }}"
                                                <div class="mt-2">
                                                    <a href="{{ route('letters.index') }}" class="btn btn-sm btn-light">
                                                        <i class="bi bi-arrow-left me-1"></i>Kembali ke semua surat
                                                    </a>
                                                </div>
                                            @else
                                                Belum ada surat yang diarsipkan
                                                <div class="mt-2">
                                                    <a href="{{ route('letters.create') }}" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-plus-circle me-1"></i>Arsipkan Surat Baru
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($letters->hasPages() || $letters->count() > 0)
                    <div class="card-footer bg-light border-top py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="small text-muted">
                                Menampilkan {{ $letters->firstItem() ?? 0 }} hingga {{ $letters->lastItem() ?? 0 }}
                                dari total {{ $letters->total() ?? 0 }} surat
                            </div>
                            {{ $letters->links('vendor.pagination.simple-bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                })
            });

            // Live Search functionality
            const searchInput = document.getElementById('searchInput');
            let searchTimer;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimer);

                const searchTerm = this.value;
                const form = this.closest('form');

                // Add loading indicator
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'spinner-border spinner-border-sm text-primary position-absolute';
                loadingIndicator.style.right = '10px';
                loadingIndicator.style.top = '50%';
                loadingIndicator.style.transform = 'translateY(-50%)';

                // Show loading indicator after 300ms of typing
                searchTimer = setTimeout(() => {
                    if (searchTerm.length > 0) {
                        this.parentNode.appendChild(loadingIndicator);
                    }
                    form.submit();
                }, 300);
            });
        </script>
    @endpush
@endsection
