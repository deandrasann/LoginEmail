@extends('layout')

@section('content')
<body style="background-color: #F5F5F5">
<div class="container mt-5">
    <h2 class="text-center">Daftar Buku</h2>
    {{-- <form action="{{ route('buku.search') }}" method="get">
        @csrf
        <input type="text" name="kata" id="kata" class="form-control" placeholder="Cari..."
            style="width: 30%; display:inline; margin-top:10px; margin-bottom:10px; float:right;">
    </form> --}}

    <table class="display table table-bordered" id="table_buku">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
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
        "paging": true,
        "lengthChange": true,
        "pageLength": 10
    });
});
</script>

@endsection
