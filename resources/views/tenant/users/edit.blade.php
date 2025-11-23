@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0 d-inline-flex align-items-center">
                            <i class="fas fa-user-edit me-2 text-primary"></i>
                            Kullanıcı Düzenle
                        </h4>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i> İsim
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i> Yeni Şifre <small class="text-muted">(Değiştirmek istemiyorsanız boş bırakın)</small>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimum 8 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i> Şifre Tekrar
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       minlength="8">
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="email_verified" 
                                           name="email_verified" 
                                           {{ $user->email_verified_at ? 'checked' : '' }}
                                           disabled>
                                    <label class="form-check-label" for="email_verified">
                                        Email Doğrulandı
                                        @if($user->email_verified_at)
                                            <small class="text-success">({{ $user->email_verified_at->format('d.m.Y H:i') }})</small>
                                        @else
                                            <small class="text-warning">(Bekliyor)</small>
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> İptal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

