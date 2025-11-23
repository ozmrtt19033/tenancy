@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h4 class="mb-0 d-inline-flex align-items-center">
                                <i class="fas fa-users me-2 text-primary"></i>
                                Kullanıcılar
                            </h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $users->count() }} kullanıcı
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($users->isEmpty())
                            <div class="alert alert-info text-center m-4">
                                <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                                <h5>Henüz kullanıcı bulunmuyor</h5>
                                <p class="mb-0 text-muted">Sistemde kayıtlı kullanıcı yok.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>İsim</th>
                                        <th>Email</th>
                                        <th>Email Doğrulama</th>
                                        <th>Kayıt Tarihi</th>
                                        <th style="width: 120px;" class="text-center">İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $index => $user)
                                        <tr>
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary text-white me-2" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->id === Auth::id())
                                                            <span class="badge bg-success ms-2">Siz</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Doğrulandı
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock"></i> Bekliyor
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                <small>
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $user->created_at->format('d.m.Y') }}
                                                    <br>
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $user->created_at->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary action-btn" title="Düzenle" data-bs-toggle="tooltip" style="min-width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($user->id !== Auth::id())
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Sil" data-bs-toggle="tooltip" style="min-width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="badge bg-secondary d-inline-flex align-items-center justify-content-center" title="Kendi hesabınızı silemezsiniz" data-bs-toggle="tooltip" style="min-width: 35px; height: 35px;">
                                                            <i class="fas fa-lock"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Geri Dön
                        </a>
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Toplam {{ $users->count() }} kullanıcı listeleniyor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .avatar-circle {
            flex-shrink: 0;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .card-header {
            border-bottom: 2px solid #f0f0f0;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-width: 1px;
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .action-btn i {
            font-size: 14px;
        }
        .table td {
            vertical-align: middle;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Bootstrap tooltip'leri aktif et
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @endpush
@endsection
