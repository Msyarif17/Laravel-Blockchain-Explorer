@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Transaction Histories
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tx" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id </th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Block Confirmation Histories
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="block" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Index </th>
                                    <th>Block</th>
                                    <th>Hash</th>
                                    <th>Created At</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

    <script>
        $(document).ready( function () {
            $('#tx').DataTable({
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{route('blockchain.getTx')}}',
                },
                columns: [
                    {data: 'id'},
                    {data: 'sender'},
                    {data: 'to'},
                    {data: 'amount'},
                    {data: 'status'},
                    {data: 'type'},
                    {data: 'created_at'},

                ]
            });
            $('#block').DataTable({
                serverSide: true,
                processing: true,
                searchDelay: 1000,
                ajax: {
                    url: '{{route('blockchain.getBlock')}}',
                },
                columns: [
                    {data: 'index'},
                    {data: 'block'},
                    {data: 'hash'},
                    {data: 'created_at'},

                ]
            });
        });
    </script>
@stop