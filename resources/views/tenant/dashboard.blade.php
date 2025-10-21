@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Hoş Geldin Kartı -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ strtoupper(tenant('id')) }} Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h5>Hoş geldin, {{ Auth::user()->name }}! 👋</h5>
                        <p class="text-muted">{{ strtoupper(tenant('id')) }} tenant'ının kontrol paneline hoş geldiniz.</p>
                    </div>
                </div>

                <!-- Bilgi Kartları -->
                <div class="row mb-4">
                    <!-- Tenant Bilgisi -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-building fa-3x text-primary"></i>
                                </div>
                                <h6 class="text-muted">Tenant ID</h6>
                                <h4>{{ tenant('id') }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Domain Bilgisi -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-globe fa-3x text-success"></i>
                                </div>
                                <h6 class="text-muted">Domain</h6>
                                <h5>{{ tenant()->domains->first()->domain }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Kullanıcı Sayısı -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-users fa-3x text-info"></i>
                                </div>
                                <h6 class="text-muted">Toplam Kullanıcı</h6>
                                <h4>{{ \App\Models\User::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hızlı Erişim -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Hızlı Erişim</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-block py-3">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <div>Kullanıcılar</div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('reports') }}" class="btn btn-outline-success btn-block py-3">
                                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                    <div>Raporlar</div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('settings') }}" class="btn btn-outline-warning btn-block py-3">
                                    <i class="fas fa-cog fa-2x mb-2"></i>
                                    <div>Ayarlar</div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-info btn-block py-3">
                                    <i class="fas fa-user fa-2x mb-2"></i>
                                    <div>Profil</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Bilgisi -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Database Bilgisi</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded">
                            <code>
                                <strong>Database:</strong> {{ tenant()->tenancy_db_name }}<br>
                                <strong>Oluşturulma:</strong> {{ tenant()->created_at->format('d.m.Y H:i') }}<br>
                                <strong>Son Güncelleme:</strong> {{ tenant()->updated_at->format('d.m.Y H:i') }}
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-block {
            display: block;
            width: 100%;
        }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
@endpush
