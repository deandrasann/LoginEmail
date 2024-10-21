<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
</head>
<body style="background-color: #F5F5F5">
<a href="{{route('buku.create')}}" class="btn btn-primary float-end m-4"
    style="width: 200px; height : 50px"> Tambah buku</a>    
<div class="container mt-5">
    <h2 class="text-center">Daftar Buku</h2>
    <form action="{{ route('buku.search') }}" method="get">
        @csrf
        <input type="text" name="kata" id="kata" class="form-control" placeholder="Cari..."
            style="width: 30%; display:inline; margin-top:10px; margin-bottom:10px; float:right;">
    </form>

    @section('content')
    @if(isset($data_buku) && count($data_buku))
    <div class="alert alert-success">Ditemukan </div>
    @else
    <div class="alert alert-warning"><h4>tidak ditemukan</h4>
    <a href="/buku" class="btn btn-warning">Kembali</a></div>
    @endif
    @endsection

    <table class="display table table-striped" id="table_buku">
        @if (Session::has('created'))
        <div class="alert alert-success">
            {{ Session::get('created') }}
        </div>
        @endif
        @if (Session::has('updated'))
        <div class="alert alert-primary">
            {{ Session::get('updated') }}
        </div>
        @endif
        @if (Session::has('deleted'))
        <div class="alert alert-danger">
            {{ Session::get('deleted') }}
        </div>
        @endif
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $index => $buku)
            <tr>
                <td>{{ $buku->id }}</td>
                <td>{{ $buku->Judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ 'Rp. '. number_format($buku->harga, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus?')" type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="m-4 d-flex justify-content-around text-center">
        <div class="card" style="width: 18rem;">
            <h4 class="mt-4">{{$rowCount}}</h4>
            <div class="card-body">
              <p class="card-text">Total buku</p>
            </div>
          </div>
          <div class="card" style="width: 18rem;">
            <h4 class="mt-4">{{ 'Rp. '.number_format($totalPrice, 0, ',', '.') }}</h4>
            <div class="card-body">
              <p class="card-text">Total Harga</p>
            </div>
          </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#table_buku').DataTable({
        "searching": true,
        "paging": true,
        "lengthChange": true,
        "pageLength": 10
    });
});
</script>

</body>
</html>
