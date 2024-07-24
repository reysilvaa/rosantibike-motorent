@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <h1 class="mt-4 text-2xl font-semibold">Dashboard</h1>
    <ol class="breadcrumb mb-4 flex items-center space-x-2">
        <li class="breadcrumb-item text-gray-500">Dashboard</li>
    </ol>
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Adjust card size by using smaller height and width -->
            <div class="bg-blue-600 text-white rounded-lg shadow-md flex flex-col h-[200px] sm:h-[250px] lg:h-[300px]">
                <div class="p-4 flex-1">Tambah Rental</div>
                <div class="bg-blue-700 p-4 flex items-center justify-between rounded-b-lg">
                    <a class="text-white hover:underline" href="{{ route('transaksi.index')}}">View Details</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
            <div class="bg-gray-600 text-white rounded-lg shadow-md flex flex-col h-[200px] sm:h-[250px] lg:h-[300px]">
                <div class="p-4 flex-1">List Transaksi Rental</div>
                <div class="bg-gray-700 p-4 flex items-center justify-between rounded-b-lg">
                    <a class="text-white hover:underline" href="{{ route('admin.transaksi.transaksi')}}">View Details</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
            <div class="bg-green-600 text-white rounded-lg shadow-md flex flex-col h-[200px] sm:h-[250px] lg:h-[300px]">
                <div class="p-4 flex-1">Tambah Unit</div>
                <div class="bg-green-700 p-4 flex items-center justify-between rounded-b-lg">
                    <a class="text-white hover:underline" href="#">View Details</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
            <div class="bg-red-600 text-white rounded-lg shadow-md flex flex-col h-[200px] sm:h-[250px] lg:h-[300px]">
                <div class="p-4 flex-1">Hapus Semua Data</div>
                <div class="bg-red-700 p-4 flex items-center justify-between rounded-b-lg">
                    <a class="text-white hover:underline" href="#">View Details</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 mt-6">
        <div class="bg-white shadow-md rounded-lg">
            <div class="border-b p-4 text-lg font-semibold">
                <i class="fas fa-table mr-2"></i>
                Transaksi Management
            </div>
            <div class="p-4">
                <button class="bg-red-600 text-white px-4 py-2 rounded-md mb-3 hover:bg-red-700" id="bulk-delete">Delete Selected</button>
                <div class="overflow-x-auto">
                    <table id="data-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="form-check-input" id="select_all_checkbox">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penyewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Motor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
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
  $(document).ready(function() {
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
