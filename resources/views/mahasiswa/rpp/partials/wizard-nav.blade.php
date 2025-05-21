<div class="step-wizard d-flex justify-content-between mb-4">
    @foreach([
        'Deskripsi Proyek', 'Tahapan', 'Kebutuhan Peralatan', 'Tantangan', 'Biaya', 'Estimasi'
    ] as $index => $label)
        <div class="step {{ session('active_step', 'step1') == 'step'.($index + 1) ? 'active' : '' }}"
             data-target="#step{{ $index + 1 }}">
            <div class="circle">{{ $index + 1 }}</div>
            <div class="label">{{ $label }}</div>
        </div>
    @endforeach
</div>
