@extends('layouts.app')

@section('title', 'REGINDE · Iniciar sesión')

@push('styles')
<style>
  .login-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center}
  .login-card{
    background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
    padding:34px 32px;max-width:360px;width:100%;box-shadow:0 10px 30px rgba(0,0,0,.06);
  }
  .login-crest{width:64px;height:64px;border-radius:50%;overflow:hidden;margin:0 auto 16px;border:2px solid var(--line)}
  .login-crest img{width:100%;height:100%;object-fit:cover}
  .login-card h1{margin:0 0 4px;font-size:18px;text-align:center;color:var(--brand-dark)}
  .login-card p.sub{margin:0 0 22px;font-size:12.5px;color:var(--muted);text-align:center}
  .login-card .field{margin-bottom:14px}
  .login-card .error{color:var(--danger);font-size:12.5px;margin:-8px 0 14px}
  .login-card button{width:100%;padding:12px;margin-top:6px}
</style>
@endpush

@section('content')
  <div class="login-wrap">
    <div class="login-card">
      <div class="login-crest"><img src="{{ asset('images/reginde_logo.png') }}" alt="REGINDE"></div>
      <h1>REGINDE</h1>
      <p class="sub">Ingresa para administrar el registro de inventario</p>

      @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
          <label>Usuario</label>
          <input name="username" value="{{ old('username') }}" autofocus autocomplete="username">
        </div>
        <div class="field">
          <label>Contraseña</label>
          <input type="password" name="password" autocomplete="current-password">
        </div>
        <button type="submit" class="btn-primary">Ingresar</button>
      </form>
    </div>
  </div>
@endsection
