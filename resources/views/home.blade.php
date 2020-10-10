@extends('layout.app')

@section('title')
Home
@endsection

<style>
    .navbar-nav {
        margin-left: 90%;
        text-align: right;
    }
</style>

<body>
    <div class="container">
        <br>
        @include('layout.navbar')

        @if (session('data')!= null)
        <script>
            var x = document.getElementById('login');
            x.innerHTML = 'logout'
            x.href = 'logout';
        </script>
        @endif

        <a href="{{ route('upload') }}">
            <button>Tambah Data</button>
        </a>
        <br>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">doc_id</th>
                    <th scope="col">img_name</th>
                    <th scope="col">img_path</th>
                    <th scope="col">created_by</th>
                    <th scope="col">created_at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gambar as $gbr)
                <tr>
                    <th scope="row">{{$loop->index +1}}</th>
                    <td>{{$gbr->doc_id}}</td>
                    <td>{{$gbr->img_name}}</td>
                    <td>{{$gbr->img_path}}</td>
                    <td>{{$gbr->created_by}}</td>
                    <td>{{$gbr->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>