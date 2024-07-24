<div class="btn-group">
  <a href="{{ route('transaksi.show', $id) }}" class="btn btn-info btn-sm">View</a>
  <a href="{{ route('transaksi.edit', $id) }}" class="btn btn-warning btn-sm">Edit</a>
  <form action="{{ route('transaksi.destroy', $id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
  </form>
</div>
