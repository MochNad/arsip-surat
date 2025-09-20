@extends('layout')

@section('title', 'Arsipkan Surat')
@section('subtitle', 'Unggah surat baru ke dalam sistem arsip')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Arsip Surat</a></li>
    <li class="breadcrumb-item active">Arsipkan Surat</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-file-earmark-arrow-up me-2"></i>Unggah Surat Baru
            </h5>
            <a href="{{ route('letters.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                <div>
                    Unggah surat yang telah terbit pada form ini untuk diarsipkan.
                    <br>
                    <strong>Catatan:</strong> Hanya file dengan format PDF yang dapat diunggah.
                </div>
            </div>

            <form action="{{ route('letters.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-123 me-1"></i>Nomor Surat
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nomor_surat"
                                class="form-control @error('nomor_surat') is-invalid @enderror"
                                value="{{ old('nomor_surat') }}" required placeholder="Masukkan nomor surat">
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-tag me-1"></i>Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                required>
                                <option value="">Pilih kategori surat...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-card-heading me-1"></i>Judul
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul') }}" required placeholder="Masukkan judul surat">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-file-earmark-pdf me-1"></i>File Surat
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="file" name="file"
                                    class="form-control @error('file') is-invalid @enderror" accept=".pdf" required
                                    id="pdfFile">
                                <label class="input-group-text" for="pdfFile">
                                    <i class="bi bi-upload"></i>
                                </label>
                            </div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format yang diperbolehkan: PDF (Maksimal 10MB)</div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="bi bi-eye me-1"></i>Preview PDF
                                </h6>
                                <div id="pdfPreview" class="mt-3 pdf-preview">
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-file-earmark-pdf display-4"></i>
                                        <p class="mt-2">PDF preview akan muncul di sini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('letters.index') }}" class="btn btn-light">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Simpan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let pdfScale = 1.5;
            const zoomStep = 0.25;
            let pdfDoc = null;

            function renderPdfPages(pdfDoc, container) {
                const numPages = pdfDoc.numPages;
                container.innerHTML = '';

                // Create a container for all pages
                const pagesContainer = document.createElement('div');
                pagesContainer.className = 'pdf-pages';
                container.appendChild(pagesContainer);

                // Render each page
                for (let i = 1; i <= numPages; i++) {
                    const pageContainer = document.createElement('div');
                    pageContainer.className = 'pdf-page mb-3';

                    const pageCanvas = document.createElement('canvas');
                    pageCanvas.id = `page-${i}`;
                    pageContainer.appendChild(pageCanvas);
                    pagesContainer.appendChild(pageContainer);

                    const currentCanvas = pageCanvas;
                    const currentCtx = currentCanvas.getContext('2d');

                    pdfDoc.getPage(i).then(function(page) {
                        const viewport = page.getViewport({
                            scale: pdfScale
                        });
                        currentCanvas.height = viewport.height;
                        currentCanvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: currentCtx,
                            viewport: viewport
                        };

                        page.render(renderContext);
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
                    renderPdfPages(pdf, container);
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

            document.getElementById('pdfFile').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        loadPdfPreview(e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('pdfPreview').innerHTML = `
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-file-earmark-x display-4"></i>
                            <p class="mt-2">Silakan pilih file PDF yang valid</p>
                        </div>
                    `;
                }
            });
        </script>

        <style>
            .pdf-preview {
                height: 500px;
                overflow-y: auto;
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
