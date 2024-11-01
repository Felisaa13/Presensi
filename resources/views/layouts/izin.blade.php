@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Izin') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('izin') }}" autocomplete="off">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Pengajuan Izin</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="tanggal_izin">Tanggal Izin<span class="small text-danger">*</span></label>
                                            <input type="date" id="tanggal_izin" class="form-control" name="tanggal_izin" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="alasan"><span class="small text-danger">*</span></label>
                                            <select id="alasan" class="form-control" name="alasan" required>
                                                <option value="" disabled selected>Pilih Alasan Izin</option>
                                                <option value="Sakit">Sakit</option>
                                                <option value="Izin Keluarga">Izin Keluarga</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="alasan">Alasan Izin<span class="small text-danger">*</span></label>
                                        <textarea id="alasan" class="form-control" name="alasan" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="row">
                                <div class="col text-center">
                                    <button type="button" class="btn btn-primary" onclick="submitForm()">Ajukan Izin</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            // Ambil nilai dari input
            const tanggalIzin = document.getElementById('tanggal_izin').value;
            const alasan = document.getElementById('alasan').value;

            // Cek apakah form terisi
            if (!tanggalIzin || !alasan) {
                alert('Mohon isi semua kolom yang diperlukan!');
                return; // Hentikan eksekusi jika ada kolom yang kosong
            }

            // Tampilkan alert sukses
            alert('Pengajuan izin berhasil!');

            // Kirim form setelah menampilkan alert
            document.getElementById('izinForm').submit();
        }
    </script>
@endsection
