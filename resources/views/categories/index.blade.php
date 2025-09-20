@extends('layout')

@section('title', 'Kategori Surat')
@section('subtitle', 'Kelola kategori surat untuk pengorganisasian arsip yang lebih baik')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Kategori Surat</li>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Search and Actions -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('categories.index') }}" class="row g-3 align-items-center">
                        <div class="col">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari kategori berdasarkan nama..." value="{{ request('search') }}"
                                    autocomplete="off">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">
                                <i class="bi bi-tag me-2"></i>Daftar Kategori
                                @if (request('search'))
                                    <small class="text-muted ms-2">
                                        Hasil pencarian: "{{ request('search') }}"
                                    </small>
                                @endif
                            </h6>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-light text-dark border">
                                Total: {{ $categories->count() }} kategori
                            </span>
                        </div>
                    </div>
                </div>

                @if ($categories->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-center" style="width: 80px">ID</th>
                                    <th class="border-0" style="width: 30%">Nama Kategori</th>
                                    <th class="border-0">Keterangan</th>
                                    <th class="border-0 text-center" style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center">
                                            <span class="text-muted small">#{{ $category->id }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $category->nama_kategori }}</span>
                                        </td>
                                        <td class="text-secondary">
                                            {{ $category->keterangan ?: 'Tidak ada keterangan' }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('categories.edit', $category) }}"
                                                    class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                    title="Edit Kategori">
                                                    <i class="bi bi-pencil text-primary"></i>
                                                </a>
                                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                                    class="d-inline"
                                                    onsubmit="event.preventDefault(); showDeleteModal(this);">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light"
                                                        data-bs-toggle="tooltip" title="Hapus Kategori">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($categories->hasPages())
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="small text-muted">
                                    Menampilkan {{ $categories->firstItem() }} hingga {{ $categories->lastItem() }}
                                    dari total {{ $categories->total() }} kategori
                                </div>
                                {{ $categories->links('vendor.pagination.simple-bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-tag-x display-6 d-block mb-3"></i>
                            @if (request('search'))
                                Tidak ditemukan kategori yang sesuai dengan pencarian "{{ request('search') }}"
                                <div class="mt-3">
                                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light">
                                        <i class="bi bi-arrow-left me-1"></i>Tampilkan Semua Kategori
                                    </a>
                                </div>
                            @else
                                Belum ada kategori yang ditambahkan
                                <div class="mt-3">
                                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori Baru
                                    </a>
                                </div>
                            @endif
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
            })
        </script>
    @endpush
@endsection
