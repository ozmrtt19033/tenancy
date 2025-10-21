@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">👥 Kullanıcılar</h4>
                        <span class="badge badge-primary badge-pill">{{ $users->count() }} kullanıcı</span>
                    </div>
                    <div class="card-body">
                        @if($users->isEmpty())
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p class="mb-0">Henüz kullanıcı bulunmuyor.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>İsim</th>
                                        <th>Email</th>
                                        <th>Email Doğrulama</th>
                                        <th>Kayıt Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->id === Auth::id())
                                                    <span class="badge badge-success ml-2">Siz</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Doğrulandı
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Bekliyor
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" title="Düzenle">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if($user->id !== Auth::id())
                                                    <button class="btn btn-sm btn-outline-danger" title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Geri Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
