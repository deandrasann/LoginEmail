<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Form Buku</title>
</head>
<body>
    <div class="container mt-5">
        <h4>Tambah Buku</h4>
        <form method="post" action="{{ route('buku.store') }}">
            @csrf
            <div class="mb-3">
                Judul <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                @error('judul')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 row">
                <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                <div class="col-md-6">
                    <input type="file"
                           class="form-control @error('photo') is-invalid @enderror"
                           id="photo"
                           name="photo"
                           value="{{ old('photo') }}">
                    @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                </div>
            </div>


            <div class="mb-3">
                Penulis <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}">
                @error('penulis')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                Harga <input type="text" name="harga" class="form-control" value="{{ old('harga') }}">
                @error('harga')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                Tanggal Terbit <input type="date" name="tgl_terbit" class="form-control" value="{{ old('tgl_terbit') }}">
                @error('tgl_terbit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <a href="{{ url('buku') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>
