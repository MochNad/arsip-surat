@extends('layout')

@section('title', 'Edit Kategori')
@section('subtitle', 'Perbarui informasi kategori surat')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori Surat</a></li>
    <li class="breadcrumb-item active">Edit {{ $category->nama_kategori }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">
                                <i class="bi bi-pencil-square me-2"></i>Edit Kategori
                            </h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('categories.index') }}" class="btn btn-link text-secondary p-0">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-3 mb-4" role="alert">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-1">Mode Edit</h6>
                                <p class="mb-0 small">
                                    Anda sedang mengedit kategori ini. Perubahan akan diterapkan setelah menekan tombol
                                    Simpan.
                                    Field yang ditandai dengan <span class="text-danger">*</span> wajib diisi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label small text-muted d-flex align-items-center">
                                <i class="bi bi-key me-2"></i>ID Kategori
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    #
                                </span>
                                <input type="text" class="form-control bg-light border-start-0"
                                    value="{{ $category->id }}" disabled>
                            </div>
                            <div class="form-text">
                                ID tidak dapat diubah
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted d-flex align-items-center">
                                <i class="bi bi-tag me-2"></i>Nama Kategori
                                <span class="text-danger ms-1">*</span>
                            </label>
                            <input type="text" name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $category->nama_kategori) }}" required autofocus
                                placeholder="Masukkan nama kategori">
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Nama kategori akan digunakan untuk mengklasifikasikan surat
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted d-flex align-items-center">
                                <i class="bi bi-card-text me-2"></i>Keterangan
                                <span class="text-muted ms-1">(Opsional)</span>
                            </label>
                            <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Tambahkan deskripsi atau informasi tambahan tentang kategori ini">{{ old('keterangan', $category->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Berikan penjelasan singkat tentang kategori ini
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-light px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
