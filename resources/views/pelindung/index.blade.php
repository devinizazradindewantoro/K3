@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">Alat Pelindung Diri (APD) - PT HM Sampoerna Tbk</h3>
    </div>
    <div class="card-body">
        <p style="text-align: justify;" class="mb-4">
            Penggunaan Alat Pelindung Diri (APD) merupakan bagian penting dari program K3 PT HM Sampoerna Tbk. APD dirancang untuk melindungi pekerja dari bahaya yang dapat menyebabkan cedera atau penyakit akibat kerja.
        </p>

        <!-- Tab Navigation -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="btn-group btn-group-sm" role="group">
                    @foreach($tabData as $key => $tab)
                        <button type="button" class="btn btn-outline-danger tab-btn {{ $key == 1 ? 'active' : '' }}" 
                                data-tab="{{ $key }}">
                            {{ $key }}. {{ $tab['title'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content-wrapper">
            @foreach($tabData as $key => $tab)
                <div class="tab-pane {{ $key == 1 ? 'active' : '' }}" id="tab-{{ $key }}">
                    <div class="row">
                        <!-- Content Column -->
                        <div class="col-md-7">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <h5 class="text-danger mb-3">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        {{ $key }}. {{ $tab['title'] }}
                                    </h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach($tab['content'] as $item)
                                            <li class="list-group-item border-0 px-0 py-2">
                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Image Column -->
                        <div class="col-md-5">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <div class="image-container">
                                        <img src="{{ asset($tab['image']) }}" 
                                             alt="{{ $tab['title'] }}" 
                                             class="img-fluid rounded shadow-sm"
                                             style="width: 100%; height: 300px; object-fit: cover;">
                                        <div class="image-overlay">
                                            <span class="badge badge-danger">{{ $tab['title'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="prevBtn" disabled>
                        <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                    </button>
                    <div class="btn-group">
                        @for($i = 1; $i <= count($tabData); $i++)
                            <button type="button" class="btn btn-sm indicator-btn {{ $i == 1 ? 'btn-danger' : 'btn-outline-danger' }}" 
                                    data-tab="{{ $i }}">{{ $i }}</button>
                        @endfor
                    </div>
                    <button type="button" class="btn btn-outline-danger" id="nextBtn">
                        Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>

        <hr class="mt-5">
        <p class="text-muted">
            <small>
                <i class="fas fa-info-circle mr-1"></i>
                Dokumen ini bersifat ringkasan. Untuk kebijakan dan prosedur lengkap, silakan merujuk ke dokumen K3 internal PT HM Sampoerna Tbk.
            </small>
        </p>
    </div>
</div>
@endsection

@push('css')
<style>
    .tab-content-wrapper {
        min-height: 400px;
        position: relative;
    }
    
    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tab-btn.active {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .image-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    
    .indicator-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-weight: bold;
    }
    
    .btn-group .btn + .btn {
        margin-left: 5px;
    }
    
    .card-outline.card-danger {
        border-top: 3px solid #dc3545;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    let currentTab = 1;
    const totalTabs = {{ count($tabData) }};
    
    // Tab button click handler
    $('.tab-btn, .indicator-btn').click(function() {
        const targetTab = parseInt($(this).data('tab'));
        showTab(targetTab);
    });
    
    // Previous button
    $('#prevBtn').click(function() {
        if (currentTab > 1) {
            showTab(currentTab - 1);
        }
    });
    
    // Next button
    $('#nextBtn').click(function() {
        if (currentTab < totalTabs) {
            showTab(currentTab + 1);
        }
    });
    
    // Keyboard navigation
    $(document).keydown(function(e) {
        if (e.keyCode == 37 && currentTab > 1) { // Left arrow
            showTab(currentTab - 1);
        } else if (e.keyCode == 39 && currentTab < totalTabs) { // Right arrow
            showTab(currentTab + 1);
        }
    });
    
    function showTab(tabNumber) {
        // Hide all tabs
        $('.tab-pane').removeClass('active');
        $('.tab-btn, .indicator-btn').removeClass('active btn-danger').addClass('btn-outline-danger');
        
        // Show target tab
        $('#tab-' + tabNumber).addClass('active');
        $('.tab-btn[data-tab="' + tabNumber + '"], .indicator-btn[data-tab="' + tabNumber + '"]')
            .removeClass('btn-outline-danger').addClass('active btn-danger');
        
        currentTab = tabNumber;
        
        // Update navigation buttons
        $('#prevBtn').prop('disabled', currentTab === 1);
        $('#nextBtn').prop('disabled', currentTab === totalTabs);
        
        // Update next button text
        if (currentTab === totalTabs) {
            $('#nextBtn').html('<i class="fas fa-check mr-1"></i> Selesai');
        } else {
            $('#nextBtn').html('Selanjutnya <i class="fas fa-chevron-right ml-1"></i>');
        }
    }
    
    // Auto-advance feature (optional)
    let autoAdvance = false;
    if (autoAdvance) {
        setInterval(function() {
            if (currentTab < totalTabs) {
                showTab(currentTab + 1);
            } else {
                showTab(1);
            }
        }, 5000);
    }
});
</script>
@endpush