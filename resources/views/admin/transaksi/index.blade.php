@extends('layouts.admin')

@section('title', 'Transaksi Management')

@section('content')
<h1 class="mt-4 text-2xl font-semibold">Transaksi</h1>
<ol class="breadcrumb mb-4 flex items-center space-x-2 text-sm">
    <li class="breadcrumb-item text-gray-500">List Transaksi</li>
</ol>

<!-- DataTables Card -->
<div class="container mx-auto px-6 mt-6">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="border-b p-4 text-lg font-semibold flex items-center bg-gray-100 text-gray-800">
            <i class="fas fa-table mr-2"></i>
            Transaksi Management
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
<x-back-to-list-button route="{{ route('dashboard') }}" />

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script type="module">
    // Import Echo
    import Echo from 'https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.js';

    $(document).ready(function() {
        try {
            // Initialize Echo with Pusher
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });

            window.Echo.connector.pusher.connection.bind('connected', () => {
                console.log('✅ Connected to Pusher');
            });

            window.Echo.connector.pusher.connection.bind('error', (error) => {
                console.error('❌ Pusher Connection Error:', error);
            });

            // Listen for both transaksi and rental updates
            window.Echo.channel('transaksi-channel')
                .listen('.transaksi-updated', (event) => {
                    console.log('🔔 Transaksi Updated Event Received:', event);
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
    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.transaksi.data') }}",
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
                render: function (data) {
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
                    return `<span class="inline-block px-2 py-1 rounded text-xs font-medium ${statusClass}">${statusText}</span>`;
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

    // Handle select all checkbox
    $('#select_all_checkbox').on('click', function() {
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle individual checkbox change
    $('#data-table tbody').on('change', 'input[type="checkbox"]', function() {
        var totalCheckboxes = $('input[type="checkbox"]', table.rows({ 'search': 'applied' }).nodes()).length;
        var checkedCheckboxes = $('input[type="checkbox"]:checked', table.rows({ 'search': 'applied' }).nodes()).length;

        // Update the select all checkbox based on individual checkboxes
        $('#select_all_checkbox').prop('checked', totalCheckboxes === checkedCheckboxes);
        $('#select_all_checkbox').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
    });

    // Handle bulk delete
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
});
</script>
@endpush
