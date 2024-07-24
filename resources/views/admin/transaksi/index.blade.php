@extends('layouts.admin')

@section('title', 'Transaksi Management')

@section('content')
<div class="container">
    <h1>Transaksi Management</h1>
    {{-- <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Add New Transaksi</a> --}}
    <button class="btn btn-danger mb-3" id="bulk-delete">Delete Selected</button>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th><input type="checkbox" name="select_all_checkbox" id="select_all_checkbox"></th>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Jenis Motor</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.transaksi.data') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_penyewa', name: 'nama_penyewa'},
            {data: 'jenisMotor.merk', name: 'jenisMotor.merk'},
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
    $('.data-table tbody').on('change', 'input[type="checkbox"]', function(){
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
    $('.data-table').on('click', '.delete', function(){
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
