@extends('layout')

@section('title', 'About')
@section('subtitle', 'Informasi aplikasi dan pengembang')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('letters.index') }}">Home</a></li>
    <li class="breadcrumb-item active">About</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-info-circle me-2"></i>Tentang Aplikasi
            </h5>
        </div>

        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <!-- Profile Photo with modern styling -->
                    <div class="position-relative d-inline-block">
                        <div class="rounded-4 shadow-sm overflow-hidden" style="width: 200px; height: 200px;">
                            <img src="{{ asset('storage/profile.jpg') }}" alt="Profile Photo"
                                class="img-fluid w-100 h-100 object-fit-cover"
                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=MochNad&background=0D6EFD&color=fff&size=200';">
                        </div>
                        <div class="position-absolute bottom-0 end-0">
                            <span class="badge rounded-pill bg-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-person-badge me-2"></i>Informasi Pengembang
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 120px;">
                                                <span class="text-muted">
                                                    <i class="bi bi-person me-2"></i>Nama
                                                </span>
                                            </td>
                                            <td>:</td>
                                            <td class="fw-medium">Moch. Nadi Rafli Maulana</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="bi bi-mortarboard me-2"></i>Prodi
                                                </span>
                                            </td>
                                            <td>:</td>
                                            <td class="fw-medium">D4 Teknik Informatika</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="bi bi-credit-card me-2"></i>NIM
                                                </span>
                                            </td>
                                            <td>:</td>
                                            <td class="fw-medium">2141720188</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="bi bi-calendar me-2"></i>Tanggal
                                                </span>
                                            </td>
                                            <td>:</td>
                                            <td class="fw-medium">20 September 2025</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-primary d-flex align-items-center mt-4 mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Aplikasi ini dikembangkan untuk mengelola arsip surat secara digital.
                            Dengan fitur pencarian, kategorisasi, dan preview PDF yang memudahkan pengguna.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
