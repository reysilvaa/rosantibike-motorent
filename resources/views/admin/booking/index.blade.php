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
        // fixedHeader: true,
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

                    // Mengembalikan HTML untuk sel dengan status
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
        ],
        drawCallback: function() {
            $('.paginate_button').addClass('px-3 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100');
            $('.paginate_button.current').addClass('bg-blue-600 text-white hover:bg-blue-700').removeClass('text-gray-700 bg-white hover:bg-gray-100');
            $('.dataTables_info').addClass('text-sm text-gray-700 px-3 py-2');

            $('.dataTables_length').addClass('flex items-center space-x-4 mb-2');
            $('.dataTables_filter').addClass('flex items-center space-x-4 mb-2');

            $('.dataTables_length select').addClass('py-2 px-3 border-2 border-blue-500 bg-white rounded-md shadow-md hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm');
            $('.dataTables_filter input').addClass('py-2 px-3 border-2 border-blue-500 bg-white rounded-md shadow-md hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm');
        }
    });

    $('#select_all_checkbox').on('click', function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

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
        $('.booking_checkbox:checked').each(function(){
            ids.push($(this).val());
        });

        if(ids.length > 0){
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
                        success: function(response){
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


    $('#data-table').on('click', '.delete', function(){
        var id = $(this).data('id');
        if(confirm("Are you sure you want to delete this transaksi?")){
            $.ajax({
                url: "/admin/booking/" + id,
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
                    alert('An error occurred while trying to delete the transaction.');
                }
            });
        }
    });
});
</script>
@endpush


