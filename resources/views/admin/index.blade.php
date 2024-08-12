@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="relative bg-gray-100 min-h-screen">
    <div class="absolute inset-0 -z-10">
        <!-- Background element -->
        <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-500"></div>
    </div>
        <!-- Main Content Wrapper -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-semibold">Menu Utama</h1>
            <ol class="breadcrumb mb-4 flex items-center space-x-1">
                <li class="breadcrumb-item text-gray-500">Klik menu yang anda akan lakukan!</li>
            </ol>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Card 1 -->
                <a href="{{ route('transaksi.index') }}" class="block bg-blue-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">Tambah Rental</div>
                    <div class="bg-blue-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>
                <!-- Card 2 -->
                <a href="{{ route('admin.transaksi.index') }}" class="block bg-gray-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">List Transaksi Rental</div>
                    <div class="bg-gray-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>
                <a href="{{ route('admin.booking.index') }}" class="block bg-teal-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">List Booking</div>
                    <div class="bg-teal-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>
                <!-- Card 3 -->
                <a href="{{ route('admin.jenisMotor.index') }}" class="block bg-green-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">Tambah Unit</div>
                    <div class="bg-green-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>
                <!-- Card 4 -->
                <a href="{{ route('admin.galeri.index') }}" class="block bg-cyan-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">Kontrol Galeri Website</div>
                    <div class="bg-cyan-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="{{ route('admin.rating.index') }}" class="block bg-purple-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">Input Review Kostumer</div>
                    <div class="bg-purple-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>

                <!-- Card 6 -->
                <a href="{{ route('admin.wipe.index') }}" class="block bg-red-600 text-white rounded-lg shadow-lg flex flex-col h-[200px] sm:h-[250px] lg:h-[300px] transition-transform transform hover:scale-105 no-underline">
                    <div class="p-4 flex-1 text-lg font-semibold">Hapus Semua Data</div>
                    <div class="bg-red-700 p-4 flex items-center justify-between rounded-b-lg">
                        <span>View Details</span>
                        <i class="fas fa-angle-right"></i>
                    </div>
                </a>
            </div>

            <!-- DataTables Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="border-b p-4 text-lg font-semibold flex items-center bg-gray-100 text-gray-800">
                    <i class="fas fa-table mr-2"></i>
                    Manager Penyewa
                </div>
                <div class="p-4">
                    <button class="bg-red-600 text-white px-4 py-2 rounded-md mb-3 hover:bg-red-700" id="bulk-delete">Delete Selected</button>
                        <div class="overflow-x-auto">
                            <table id="data-table" class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">
                                            <input type="checkbox" class="form-check-input" id="select_all_checkbox">
                                        </th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Nopol</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Nama Penyewa</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Jenis Motor</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Tanggal Sewa</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Tanggal Kembali</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Total</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- content otomatis datatables --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('styles')
<script type="text/javascript">
$(document).ready(function() {
    $.extend($.fn.dataTable.defaults, {
        language: {
            paginate: {
                previous: '<button class="px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">Previous</button>',
                next: '<button class="px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">Next</button>',
            },
            info: '<span class="text-sm text-gray-700 px-3 py-2">Showing _START_ to _END_ of _TOTAL_ entries</span>',
            lengthMenu: '<span class="text-sm text-gray-700 px-3 py-2">Show _MENU_ entries</span>',
            search: '<span class="text-sm text-gray-700 px-3 py-2">Search:</span>'
        }
    });

    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.transaksi.data') }}",
        // fixedHeader: true,
        paging: true,
        searching: true,
        ordering: true,
        responsive: true, // Menambahkan opsi responsive
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'nopol', name: 'nopol'},
            {data: 'nama_penyewa', name: 'nama_penyewa'},
            {data: 'merk_motor', name: 'merk_motor'},
            {data: 'tgl_sewa', name: 'tgl_sewa'},
            {data: 'tgl_kembali', name: 'tgl_kembali'},
            {
                data: 'status',
                name: 'status',
                render: function (data, type, row) {
                    // Mengatur kelas berdasarkan status
                    let statusClass = '';
                    let statusText = data || 'Unknown'; // Default to 'Unknown' jika data kosong

                    switch (data) {
                        case 'ready':
                            statusClass = 'bg-green-500 text-white';
                            break;
                        case 'perpanjang':
                            statusClass = 'bg-yellow-500 text-black';
                            break;
                        case 'disewa':
                            statusClass = 'bg-red-500 text-white';
                            break;
                        default:
                            statusClass = 'bg-gray-500 text-white';
                    }

                    // Mengembalikan HTML untuk sel dengan status
                    return `
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium ${statusClass}">
                            ${statusText}
                        </span>
                    `;
                }
            },            {data: 'total', name: 'total'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function() {
            // Menambahkan gaya pada tombol pagination
            $('.paginate_button').addClass('px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100');
            $('.paginate_button.current').addClass('bg-blue-600 text-white hover:bg-blue-700').removeClass('text-gray-700 bg-white hover:bg-gray-100');
            $('.dataTables_info').addClass('text-sm text-gray-700 px-3 py-2');

            // Menyelaraskan filter length dan search secara horizontal
            $('.dataTables_length').addClass('flex items-center space-x-4 mb-2');
            $('.dataTables_filter').addClass('flex items-center space-x-4 mb-2');

            // Menambahkan gaya pada elemen select dan input
            $('.dataTables_length select').addClass('py-2 px-3 border-2 border-blue-500 bg-white rounded-md shadow-md hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm');
            $('.dataTables_filter input').addClass('py-2 px-3 border-2 border-blue-500 bg-white rounded-md shadow-md hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm');
        }
    });

    // Menangani klik pada kontrol "Select all"
    $('#select_all_checkbox').on('click', function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Menangani klik pada checkbox untuk mengatur status kontrol "Select all"
    $('#data-table tbody').on('change', 'input[type="checkbox"]', function(){
        if(!this.checked){
            var el = $('#select_all_checkbox').get(0);
            if(el && el.checked && ('indeterminate' in el)){
                el.indeterminate = true;
            }
        }
    });

    $('#bulk-delete').on('click', function(e){
        var ids = [];
        $('.transaksi_checkbox:checked').each(function(){
            ids.push($(this).val());
        });

        if(ids.length > 0){
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin?',
                text: 'Anda ingin menghapus transaksi yang dipilih?',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4c51bf',  // Warna indigo-600
                cancelButtonColor: '#38a169',  // Warna hijau
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.transaksi.bulkDelete') }}",
                        method: 'POST',
                        data: {
                            ids: ids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response){
                            table.draw();
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi Berhasil Dihapus',
                                text: 'Transaksi yang dipilih berhasil dihapus.',
                                confirmButtonColor: '#4c51bf'  // Warna indigo-600 untuk tombol "OK"
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan',
                                text: 'Terjadi kesalahan saat mencoba menghapus transaksi yang dipilih.',
                                confirmButtonColor: '#4c51bf'  // Warna indigo-600 untuk tombol "OK"
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Ada Transaksi Terpilih',
                text: 'Silakan pilih setidaknya satu transaksi untuk dihapus.',
                confirmButtonColor: '#4c51bf'  // Warna indigo-600 untuk tombol "OK"
            });
        }
    });

    // Menangani tombol delete
    $('#data-table').on('click', '.delete', function(){
        var id = $(this).data('id');

        Swal.fire({
            icon: 'question',
            title: 'Apakah Anda yakin?',
            text: 'Anda ingin menghapus booking ini?',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#4c51bf',  // Warna indigo-600
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/transaksi/" + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        table.draw();
                        Swal.fire({
                            icon: 'success',
                            title: 'Booking Berhasil Dihapus',
                            text: 'Booking berhasil dihapus.'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Terjadi kesalahan saat mencoba menghapus booking.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
