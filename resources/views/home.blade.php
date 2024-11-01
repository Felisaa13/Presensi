@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    <!-- Pesan Sukses atau Error -->
    <div id="successAlert" class="alert alert-success border-left-success alert-dismissible fade show" role="alert"
        style="display: none;">
        <span id="successMessage">Anda telah datang!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div id="errorAlert" class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert"
        style="display: none;">
        <span id="errorMessage">Terjadi kesalahan!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!-- Jam dan Tombol -->
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <div id="digitalClock" class="h1 mb-3"></div>
            <div class="d-flex justify-content-center">
                <form id="attendanceFormCheckIn" method="POST" action="{{ route('checkIn') }}">
                    @csrf
                    <button id="checkInButton" type="submit" class="btn btn-primary mr-2 btn-lg"
                        style="font-size: 1.5rem; padding: 15px 30px;">Datang</button>
                </form>
                <form id="attendanceFormCheckOut" method="POST" action="{{ route('checkOut') }}">
                    @csrf
                    <button id="checkOutButton" type="submit" class="btn btn-secondary btn-lg"
                        style="font-size: 1.5rem; padding: 15px 30px;">Pulang</button>
                </form>
            </div>
            <div id="successAlert" class="alert alert-success mt-3" style="display: none;">
                <span id="successMessage"></span>
            </div>
            <div id="errorAlert" class="alert alert-danger mt-3" style="display: none;">
                <span id="errorMessage"></span>
            </div>
        </div>
    </div>

    <script>
        // Jam Digital
        function startTime() {
            const today = new Date();
            const options = {
                timeZone: 'Asia/Jakarta',
                hour12: false,
            };

            let time = today.toLocaleTimeString('en-US', options);
            document.getElementById('digitalClock').innerHTML = time;
            setTimeout(startTime, 1000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            startTime();
        });

        // Event Handler untuk Tombol "Datang"
        document.getElementById('checkInButton').addEventListener('click', function(e) {
            e.preventDefault();

            const now = new Date();
            const hour = now.getHours();
            const minute = now.getMinutes();

            // Cek waktu datang
            if ((hour === 6 && minute >= 45) || (hour === 7 && minute <= 0)) {
                document.getElementById('successMessage').innerText = "Presensi datang berhasil dicatat!";
                document.getElementById('successAlert').style.display = 'block';

                setTimeout(function() {
                    document.getElementById('successAlert').style.display = 'none';
                }, 3000);

                document.getElementById('attendanceFormCheckIn').submit();
            } else if (hour >= 7) {
                document.getElementById('errorMessage').innerText = "Anda terlambat untuk presensi datang.";
                document.getElementById('errorAlert').style.display = 'block';

                setTimeout(function() {
                    document.getElementById('errorAlert').style.display = 'none';
                }, 3000);
            } else {
                document.getElementById('errorMessage').innerText = "Presensi datang hanya bisa dilakukan antara 06:45 - 07:00.";
                document.getElementById('errorAlert').style.display = 'block';

                setTimeout(function() {
                    document.getElementById('errorAlert').style.display = 'none';
                }, 3000);
            }
        });

        // Event Handler untuk Tombol "Pulang"
        document.getElementById('checkOutButton').addEventListener('click', function(e) {
            e.preventDefault();

            const now = new Date();
            const hour = now.getHours();
            const minute = now.getMinutes();

            // Cek waktu pulang
            if (hour === 15 && minute === 0) {
                document.getElementById('successMessage').innerText = "Presensi pulang berhasil dicatat!";
                document.getElementById('successAlert').style.display = 'block';

                setTimeout(function() {
                    document.getElementById('successAlert').style.display = 'none';
                }, 3000);

                document.getElementById('attendanceFormCheckOut').submit();
            } else {
                document.getElementById('errorMessage').innerText = "Presensi pulang hanya bisa dilakukan pada pukul 15:00.";
                document.getElementById('errorAlert').style.display = 'block';

                setTimeout(function() {
                    document.getElementById('errorAlert').style.display = 'none';
                }, 3000);
            }
        });
    </script>

@endsection
