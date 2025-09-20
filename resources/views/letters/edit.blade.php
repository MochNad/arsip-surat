@extends('layout')

@section('title', 'Edit Surat')
@section('subtitle', 'Perbarui informasi surat yang telah diarsipkan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Arsip Surat</a></li>
    <li class="breadcrumb-item active">Edit {{ $letter->judul }}</li>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Header -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('letters.show', $letter) }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="mb-0">Edit Surat</h5>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-12">
            <form action="{{ route('letters.update', $letter) }}" method="POST" enctype="multipart/form-data"
                id="editForm">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Form Fields -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-transparent">
                                <h6 class="mb-0">
                                    <i class="bi bi-pencil me-2"></i>Informasi Surat
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <label class="form-label text-muted">
                                            Nomor Surat <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-123"></i>
                                            </span>
                                            <input type="text" name="nomor_surat"
                                                class="form-control border-start-0 @error('nomor_surat') is-invalid @enderror"
                                                value="{{ old('nomor_surat', $letter->nomor_surat) }}" required
                                                placeholder="Masukkan nomor surat">
                                            @error('nomor_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label text-muted">
                                            Kategori <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-tag"></i>
                                            </span>
                                            <select name="category_id"
                                                class="form-select border-start-0 @error('category_id') is-invalid @enderror"
                                                required>
                                                <option value="">Pilih kategori...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $letter->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label text-muted">
                                            Judul Surat <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-card-heading"></i>
                                            </span>
                                            <input type="text" name="judul"
                                                class="form-control border-start-0 @error('judul') is-invalid @enderror"
                                                value="{{ old('judul', $letter->judul) }}" required
                                                placeholder="Masukkan judul surat">
                                            @error('judul')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label text-muted">File Surat (PDF)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </span>
                                            <input type="file" name="file"
                                                class="form-control border-start-0 @error('file') is-invalid @enderror"
                                                accept=".pdf" id="pdfFile">
                                            @error('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-text d-flex align-items-center gap-2 mt-2">
                                            <i class="bi bi-info-circle text-primary"></i>
                                            <span>
                                                File saat ini: <strong>{{ $letter->file_name }}</strong>
                                                <br>
                                                Kosongkan jika tidak ingin mengganti file
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('letters.show', $letter) }}" class="btn btn-light">
                                        <i class="bi bi-x-lg me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Preview -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent">
                                <h6 class="mb-0">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Preview Dokumen
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div id="pdfPreview" class="preview-pdf overflow-auto">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 text-muted">Memuat dokumen...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

            // PDF Preview
            let pdfDoc = null;
            const pdfScale = 1.25; // Fixed scale for all pages

            function renderPdfPages(pdf) {
                const container = document.getElementById('pdfPreview');
                const pagesContainer = document.createElement('div');
                pagesContainer.className = 'pdf-pages';
                container.innerHTML = '';
                container.appendChild(pagesContainer);

                // Render each page
                for (let i = 1; i <= pdf.numPages; i++) {
                    const pageContainer = document.createElement('div');
                    pageContainer.className = 'pdf-page mb-3';
                    pageContainer.id = `page-container-${i}`;
                    pagesContainer.appendChild(pageContainer);

                    const canvas = document.createElement('canvas');
                    canvas.id = `page-${i}`;
                    pageContainer.appendChild(canvas);

                    pdf.getPage(i).then(function(page) {
                        const viewport = page.getViewport({
                            scale: pdfScale
                        });
                        const ctx = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        page.render({
                            canvasContext: ctx,
                            viewport: viewport
                        });
                    });
                }
            }

            function loadPdfPreview(url) {
                const container = document.getElementById('pdfPreview');
                container.innerHTML = `
                    <div class="d-flex flex-column justify-content-center align-items-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat dokumen PDF...</p>
                    </div>
                `;

                pdfjsLib.getDocument(url).promise.then(function(pdf) {
                    pdfDoc = pdf;
                    renderPdfPages(pdf);
                }).catch(function(error) {
                    container.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-circle text-danger display-1"></i>
                            <p class="mt-3 text-danger">Gagal memuat dokumen PDF</p>
                            <small class="text-muted">Error: ${error.message}</small>
                        </div>
                    `;
                });
            }

            // Handle file input change
            document.getElementById('pdfFile').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        loadPdfPreview(e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    const container = document.getElementById('pdfPreview');
                    container.innerHTML = `
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-file-earmark-x display-4"></i>
                            <p class="mt-2">Silakan pilih file PDF yang valid</p>
                        </div>
                    `;
                }
            });

            // Load initial PDF preview
            function refreshPdfPreview() {
                const fileInput = document.getElementById('pdfFile');
                if (fileInput.files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        loadPdfPreview(e.target.result);
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                } else {
                    loadPdfPreview('{{ route('letters.download', $letter) }}');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                refreshPdfPreview();
            });
        </script>

        <style>
            .preview-pdf {
                height: calc(100vh - 250px);
                min-height: 500px;
                background: #f8f9fa;
            }

            .pdf-pages {
                padding: 1rem;
            }

            .pdf-page {
                display: flex;
                justify-content: center;
                background: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .pdf-page:not(:last-child) {
                margin-bottom: 1rem;
            }

            .pdf-page canvas {
                max-width: 100%;
                height: auto !important;
            }
        </style>
    @endpush
@endsection
