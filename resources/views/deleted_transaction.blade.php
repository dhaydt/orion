<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaksi Dihapus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h3 class="card-title">
                Transaksi Dihapus
            </h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                  <tr class="text-capitalize">
                    <th scope="col">#id</th>
                    <th scope="col">total transaksi</th>
                    <th scope="col">nama penyewa</th>
                    <th scope="col">nama admin</th>
                    <th scope="col">tanggal dibuat</th>
                    <th scope="col">tanggal dihapus</th>
                    <th scope="col">waktu mulai</th>
                    <th scope="col">waktu berakhir</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                      <th scope="row">#{{ $d['id'] }}</th>
                      <td>
                        @if ($d['waktu_selesai'])
                            <span class="badge bg-success">Rp. {{ number_format($d->total()) }}</span>
                        @else
                            <span class="badge bg-danger">Meja tidak diselesaikan</span>
                        @endif
                    </td>
                      <td>{{ $d['nama_penyewa'] }}</td>
                      <td>{{ $d['user']['name'] }}</td>
                      <td>{{ \Carbon\Carbon::parse($d['created_at'])->format("d-m-Y H:i") }}</td>
                      <td>{{ \Carbon\Carbon::parse($d['deleted_at'])->format("d-m-Y H:i") }}</td>
                      <td>{{ \Carbon\Carbon::parse($d['waktu_mulai'])->format("d-m-Y H:i") }}</td>
                      <td>
                        @if ($d['waktu_selesai'])
                            {{ \Carbon\Carbon::parse($d['waktu_selesai'])->format("d-m-Y H:i") }}</td>
                        @else
                            <span class="badge bg-danger">Meja tidak diselesaikan</span>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
