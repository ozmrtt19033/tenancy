@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">⚙️ Ayarlar</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Bu sayfa henüz yapım aşamasında.
                        </div>
                        <p>Yakında burada sistem ayarlarınızı yapabileceksiniz.</p>
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
