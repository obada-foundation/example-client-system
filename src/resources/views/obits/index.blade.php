@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Local Obits'
])

@section('head')
    <title>Local Obits</title>
    <meta name="description" content="Local inventory of Obits">
    <meta name="keywords" content="obits, list">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>

@endsection

@section('page_content')

    <div class="card">
        <div class="card-body">
            <obit-list load-all-obits-url="{{ route('obits.load-all') }}"></obit-list>
        </div>
    </div>

@endsection


@section('scripts')
    <!-- todo: move to js file as dependencies -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
