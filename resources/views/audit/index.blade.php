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
                    @foreach ($paginatedData as $index => $item)
                        <tr>
                            <td class="text-center align-middle font-weight-bold">
                                {{ $item['urut'] }}
                            </td>
                            <td class="align-middle">{{ $item['kriteria'] }}</td>

                            <!-- KOLOM PENILAIAN DENGAN IKON -->
                            <td class="text-center align-middle">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <!-- Ikon CENTANG (Sesuai) -->
                                    <label class="btn btn-sm btn-outline-success py-1 px-2 active"
                                        onclick="togglePenilaian(this, 'ya')" style="border-radius:  0;">
                                        <i class="fas fa-check"></i>
                                    </label>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                @if (!empty(trim($item['acuan'])) && !empty($item['link']) && $item['link'] !== '#')
                                    <a href="{{ $item['link'] }}" target="_blank" class="text-primary font-weight-bold"
                                        style="text-decoration: underline;">
                                        {{ $item['acuan'] }}
                                        <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted">{{ $item['acuan'] ?: '-' }}</span>
                                @endif
                            </td>
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
