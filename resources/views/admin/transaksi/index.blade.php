@extends('layouts.admin')

@section('title', 'Transaksi Management')

@section('content')
<h1 class="mt-4 text-2xl font-semibold">Transaksi</h1>
<ol class="breadcrumb mb-4 flex items-center space-x-2 text-sm">
    <li class="breadcrumb-item text-gray-500">List Transaksi</li>
</ol>
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded-lg mb-4">
        <div class="border-b p-4 bg-gray-100 flex items-center justify-between">
            <i class="fas fa-table mr-2"></i>
            <span class="font-semibold">Tabel Transaksi</span>
        </div>
        <div class="p-4">
            <button class="bg-red-600 text-white px-4 py-2 rounded-md mb-3 hover:bg-red-700" id="bulk-delete">Delete Selected</button>
            <div class="overflow-x-auto">
                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <input type="checkbox" class="form-check-input" id="select_all_checkbox">
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penyewa</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Motor</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Rows will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.tailwind.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">
  $(function () {
    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.transaksi.data') }}",
        fixedHeader: true,
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama_penyewa', name: 'nama_penyewa'},
            {data: 'jenis_motor.merk', name: 'jenisMotor.merk'},
            {data: 'tgl_sewa', name: 'tgl_sewa'},
            {data: 'tgl_kembali', name: 'tgl_kembali'},
            {data: 'status', name: 'status'},
            {data: 'total', name: 'total'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Handle click on "Select all" control
    $('#select_all_checkbox').on('click', function(){
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#data-table tbody').on('change', 'input[type="checkbox"]', function(){
      if(!this.checked){
         var el = $('#select_all_checkbox').get(0);
         if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
         }
      }
    });

    // Handle form submission event
    $('#bulk-delete').on('click', function(e){
      var ids = [];
      $('.transaksi_checkbox:checked').each(function(){
          ids.push($(this).val());
      });
      if(ids.length > 0){
        if(confirm("Are you sure you want to delete selected transaksi?")){
          $.ajax({
            url: "{{ route('admin.transaksi.bulkDelete') }}",
            method: 'POST',
            data: {
              ids: ids,
              _token: '{{ csrf_token() }}'
            },
            success: function(response){
              table.draw();
            }
          });
        }
      } else {
        alert("Please select at least one transaksi");
      }
    });

    // Handle delete button
    $('#data-table').on('click', '.delete', function(){
      var id = $(this).data('id');
      if(confirm("Are you sure you want to delete this transaksi?")){
        $.ajax({
          url: "/admin/transaksi/" + id,
          method: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(response){
            table.draw();
          }
        });
      }
    });
  });
</script>
@endpush
