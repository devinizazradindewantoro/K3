@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">
            Checklist Penerapan SMK3 – PT HM Sampoerna Tbk
        </h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-danger text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="45%">Kriteria Audit SMK3</th>
                    <th width="15%">Penilaian</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paginatedData as $item)
                <tr>
                    <td class="text-center">{{ $item['no'] }}</td>
                    <td>{{ $item['kriteria'] }}</td>
                    <td class="text-center">
                        <input type="checkbox">
                    </td>
                    <td class="text-center">{{ $item['acuan'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between mt-3">
            <div>
                Menampilkan {{ $paginatedData->firstItem() }}
                - {{ $paginatedData->lastItem() }}
                dari {{ $paginatedData->total() }} data
            </div>
            <div>
                {{ $paginatedData->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>
</div>
@push('styles')
<style>
table th {
    vertical-align: middle;
    text-align: center;
}
textarea {
    resize: none;
}
</style>
@endpush

@endsection
