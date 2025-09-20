@extends('layout')

@section('title', $letter->judul)
@section('subtitle', 'Nomor Surat: ' . $letter->nomor_surat)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Arsip Surat</a></li>
    <li class="breadcrumb-item active">{{ $letter->nomor_surat }}</li>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Header -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('letters.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="mb-0">Detail Surat</h5>
                </div>
                <div class="btn-group">
                    <a href="{{ route('letters.edit', $letter) }}" class="btn btn-primary" data-bs-toggle="tooltip"
                        title="Edit Surat">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('letters.download', $letter) }}" class="btn btn-outline-primary"
                        data-bs-toggle="tooltip" title="Unduh PDF">
                        <i class="bi bi-download"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Letter Info -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informasi Surat
                    </h6>
                </div>
                <div class="card-body">
                    <dl class="row g-3">
                        <dt class="col-sm-4 text-muted">
                            <i class="bi bi-123 me-1"></i>Nomor
                        </dt>
                        <dd class="col-sm-8 mb-0">
                            <span class="fw-medium">{{ $letter->nomor_surat }}</span>
                        </dd>

                        <dt class="col-sm-4 text-muted">
                            <i class="bi bi-tag me-1"></i>Kategori
                        </dt>
                        <dd class="col-sm-8 mb-0">
                            <span class="badge bg-light text-dark border">
                                {{ $letter->category->nama_kategori }}
                            </span>
                        </dd>

                        <dt class="col-sm-4 text-muted">
                            <i class="bi bi-card-heading me-1"></i>Judul
                        </dt>
                        <dd class="col-sm-8 mb-0 fw-medium">
                            {{ $letter->judul }}
                        </dd>

                        <dt class="col-sm-4 text-muted">
                            <i class="bi bi-calendar2 me-1"></i>Diarsipkan
                        </dt>
                        <dd class="col-sm-8 mb-0 text-body-secondary">
                            {{ $letter->formatted_created_at }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- PDF Preview -->
        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Preview Dokumen
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="pdfViewer" class="preview-pdf overflow-auto">
                        <div class="d-flex flex-column justify-content-center align-items-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Memuat dokumen PDF...</p>
                        </div>
                    </div>
                </div>
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

            // PDF Preview
            let pdfDoc = null;
            let currentPdfUrl = null;
            const pdfScale = 1.25; // Fixed scale for all pages

            function renderPdfPages(pdf) {
                const container = document.getElementById('pdfViewer');
                const pagesContainer = document.querySelector('.pdf-pages') || document.createElement('div');
                pagesContainer.className = 'pdf-pages';

                if (!container.contains(pagesContainer)) {
                    container.innerHTML = '';
                    container.appendChild(pagesContainer);
                }

                const numPages = pdf.numPages;

                // Render each page
                for (let i = 1; i <= numPages; i++) {
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

            function loadPdfPreview(url, forceReload = false) {
                const container = document.getElementById('pdfViewer');

                // If we already have this PDF loaded and don't need to reload
                if (pdfDoc && url === currentPdfUrl && !forceReload) {
                    renderPdfPages(pdfDoc, pdfScale);
                    return;
                }

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
                    currentPdfUrl = url;
                    renderPdfPages(pdf, pdfScale);
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

            // No zoom controls - using fixed scale

            // Load initial PDF preview
            document.addEventListener('DOMContentLoaded', function() {
                loadPdfPreview('{{ route('letters.download', $letter) }}');
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
