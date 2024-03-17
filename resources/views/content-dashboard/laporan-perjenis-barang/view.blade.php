@extends('layouts.app')

@section('content')
    @include('layouts.overview',['text' => 'Laporan perjenis/Asal Barang','icon' => 'mdi mdi-airplay'])
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('laporan_gudang.index-perbarang') }}" class="btn btn-sm bg-green text-white aadd mb-4"><i class="mdi mdi-keyboard-backspace"></i>Kembali</a>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover datatables-styles data-all" width="100%" id="table1">
                        <thead>
                            <tr>
                                <th>Data Pemohon</th>
                                <th>Total Pokok Lelang</th>
                                <th>Total PNBP Lelang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($summary as $item)
                                <tr>
                                    <td>{{ $item['nama_entitas'] }}</td>
                                    <td>{{ $item['total_pokok_lelang'] }}</td>
                                    <td>{{ $item['total_pnbp_lelang'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
