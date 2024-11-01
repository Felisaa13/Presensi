@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Rekap') }}</h1>

    <!-- Data Presensi Siswa -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Presensi Siswa</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>NISN</th>
                                <th>Tanggal</th>
                                <th>Datang</th>
                                <th>Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presensi as $d)
                                <tr>
                                    <td>{{ $d->NISN }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} </td>
                                    <td>{{ \Carbon\Carbon::parse($d->waktu_datang)->timezone('Asia/Jakarta')->format('H:i') }} </td>
                                    <td>
                                        @if($d->waktu_pulang)
                                            {{ \Carbon\Carbon::parse($d->waktu_pulang)->timezone('Asia/Jakarta')->format('H:i') }}
                                        @else
                                            {{-- Kosongkan atau beri tanda placeholder jika ingin --}}
                                        @endif
                                    </td>
                                    </tr>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
