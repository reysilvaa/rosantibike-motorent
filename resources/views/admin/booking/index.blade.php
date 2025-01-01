@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<h1 class="mt-4 text-2xl font-semibold">Booking</h1>
<ol class="breadcrumb mb-4 flex items-center space-x-2 text-sm">
    <li class="breadcrumb-item text-gray-500">List Booking</li>
</ol>

<!-- DataTables Card -->
<div class="container mx-auto px-6 mt-6">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="border-b p-4 text-lg font-semibold flex items-center bg-gray-100 text-gray-800">
            <i class="fas fa-table mr-2"></i>
            Booking Management
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
                                <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Nama Penyewa</th>
                                <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Jenis Motor</th>
                                <th class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider">Tanggal Sewa</th>
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
<x-back-to-list-button route="{{ route('dashboard') }}" />

@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script type="module">
    // Import Echo
    import Echo from 'https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.js';

    // Wait for document ready
    $(document).ready(function() {
        try {
            // Initialize Echo with Pusher
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });

            // Add connection logging
            window.Echo.connector.pusher.connection.bind('connected', () => {
                console.log('✅ Connected to Pusher');
            });

            window.Echo.connector.pusher.connection.bind('error', (error) => {
                console.error('❌ Pusher Connection Error:', error);
            });

            // Listen for both booking and rental updates
            window.Echo.channel('booking-channel')
                .listen('.booking-updated', (event) => {
                    console.log('🔔 Booking Updated Event Received:', event);
                    refreshTable();
                });

            window.Echo.channel('rentals')
                .listen('.rental.updated', (event) => {
                    console.log('🔔 Rental Updated Event Received:', event);
                    refreshTable();
                });

            // Function to refresh DataTable
            function refreshTable() {
                try {
                    let table = $('#data-table').DataTable();
                    console.log('📊 Reloading DataTable...');
                    table.ajax.reload(null, false);
                    console.log('✅ DataTable Reload Complete');
                } catch (error) {
                    console.error('❌ Error reloading DataTable:', error);
                }
            }

        } catch (error) {
            console.error('❌ Error initializing Echo:', error);
        }
    });
</script>
<!-- Import DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- Import DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

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
            ajax: "{{ route('admin.booking.data') }}",
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'nopol', name: 'nopol'},
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {
                        let statusClass = '';
                        let statusText = data || 'Unknown';
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

                        return `
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium ${statusClass}">
                                ${statusText}
                            </span>
                        `;
                    }
                },
                {data: 'tgl_kembali', name: 'tgl_kembali'},
                {data: 'nama_penyewa', name: 'nama_penyewa'},
                {data: 'merk_motor', name: 'merk_motor'},
                {data: 'tgl_sewa', name: 'tgl_sewa'},
                {data: 'total', name: 'total'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Handle bulk delete
        $('#select_all_checkbox').on('click', function() {
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('#data-table tbody').on('change', 'input[type="checkbox"]', function() {
            if (!this.checked) {
                var el = $('#select_all_checkbox').get(0);
                if (el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
            }
        });

        $('#bulk-delete').on('click', function(e) {
            var ids = [];
            $('.booking_checkbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah Anda yakin?',
                    text: 'Anda ingin menghapus booking yang dipilih?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#4c51bf',
                    cancelButtonColor: '#38a169',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.booking.bulkDelete') }}",
                            method: 'POST',
                            data: {
                                ids: ids,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Bulk Delete Berhasil',
                                    text: 'Bookings berhasil dihapus.',
                                    confirmButtonColor: '#4c51bf'
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Kesalahan',
                                    text: 'Terjadi kesalahan saat mencoba menghapus booking yang dipilih.',
                                    confirmButtonColor: '#4c51bf'
                                });
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Ada Booking Terpilih',
                    text: 'Silakan pilih setidaknya satu booking untuk dihapus.',
                    confirmButtonColor: '#4c51bf'
                });
            }
        });
    });
</script>
@endpush
