<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arsip Surat')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // Configure PDF.js worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
        }

        .preview-pdf {
            height: 500px;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
            background-color: #f8f9fa;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2c3345;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item {
            font-size: 0.875rem;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            font-size: 1.1rem;
            line-height: 1;
            vertical-align: -2px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            margin: 0 0.125rem;
        }

        .search-input:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        footer {
            padding: 1rem 0;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            margin-top: auto;
        }
    </style>
</head>

<body class="min-vh-100 bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100 g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 border-end bg-white shadow-sm p-0">
                <div class="sticky-top">
                    <div class="p-3 border-bottom bg-white">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-archive me-2"></i>Arsip Surat
                        </h5>
                    </div>
                    <div class="p-2">
                        <nav class="nav flex-column">
                            <a class="nav-link rounded py-2 {{ request()->routeIs('letters.*') ? 'active bg-primary text-white' : 'text-body' }}"
                                href="{{ route('letters.index') }}">
                                <i class="bi bi-file-earmark-text me-2"></i>Arsip Surat
                            </a>
                            <a class="nav-link rounded py-2 {{ request()->routeIs('categories.*') ? 'active bg-primary text-white' : 'text-body' }}"
                                href="{{ route('categories.index') }}">
                                <i class="bi bi-tags me-2"></i>Kategori
                            </a>
                            <a class="nav-link rounded py-2 {{ request()->routeIs('about') ? 'active bg-primary text-white' : 'text-body' }}"
                                href="{{ route('about') }}">
                                <i class="bi bi-info-circle me-2"></i>About
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 bg-light d-flex flex-column min-vh-100">
                <main class="flex-grow-1 p-4">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>

                    <!-- Page Title & Subtitle -->
                    @hasSection('title')
                        <h1 class="page-title">@yield('title')</h1>
                        @hasSection('subtitle')
                            <p class="page-subtitle mb-4">@yield('subtitle')</p>
                        @endif
                    @endif

                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show mb-4"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mb-4"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mb-4"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <footer class="py-3 bg-white border-top mt-auto">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-12 text-center">
                                <p class="text-muted mb-0">
                                    <i class="bi bi-archive me-1"></i>
                                    Sistem Arsip Surat © {{ date('Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-exclamation-triangle text-warning display-4 mb-3 d-block"></i>
                    <h5 class="mb-3">Konfirmasi Hapus</h5>
                    <p class="mb-0 text-muted">Apakah Anda yakin ingin menghapus arsip surat ini?<br>Tindakan ini tidak
                        dapat dibatalkan.</p>
                </div>
                <div class="modal-footer border-top-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDelete">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // PDF Preview Function
        function loadPdfPreview(url, containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;

            // Show loading state
            container.innerHTML = `
                <div class="d-flex flex-column justify-content-center align-items-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-muted">Memuat dokumen PDF...</div>
                </div>
            `;

            // Load the PDF
            pdfjsLib.getDocument(url).promise
                .then(function(pdf) {
                    return pdf.getPage(1);
                })
                .then(function(page) {
                    const viewport = page.getViewport({
                        scale: 1.5
                    });
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Make canvas responsive
                    canvas.style.width = '100%';
                    canvas.style.height = 'auto';

                    container.innerHTML = '';
                    container.appendChild(canvas);

                    return page.render({
                        canvasContext: context,
                        viewport: viewport
                    }).promise;
                })
                .catch(function(error) {
                    console.error('Error loading PDF:', error);
                    container.innerHTML = `
                        <div class="alert alert-danger m-3 d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                Error saat memuat PDF. Silakan coba unduh file secara langsung.
                            </div>
                        </div>
                    `;
                });
        }

        // Delete confirmation
        let deleteForm = null;
        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteBtn = document.getElementById('confirmDelete');

        function showDeleteModal(form) {
            deleteForm = form;
            const modal = new bootstrap.Modal(deleteModal);
            modal.show();
        }

        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
