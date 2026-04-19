@if($reportMode === 'umum')
    @include('laporan.partials.pdf-umum')
@else
    @include('laporan.partials.pdf-detail')
@endif
