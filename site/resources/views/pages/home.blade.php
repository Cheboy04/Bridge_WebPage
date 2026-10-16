@extends('layouts.base')

{{-- Placeholder home (brg-31). The real home arrives with HU-01 and HU-09. --}}
@section('content')
    <main class="grid min-h-svh place-content-center gap-4 px-4 text-center">
        <h1 class="font-serif text-h1 font-semibold text-fg">{{ __('site.name') }}</h1>
        <p class="text-muted">{{ __('site.tagline') }}</p>
    </main>
@endsection
