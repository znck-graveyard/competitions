@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <br>
                <br>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Timestamp</th>
                    </tr>
                    @foreach($voters as $i => $voter)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ $voter->user->name }}
                            </td>
                            <td>
                                {{ $voter->user->email }}
                            </td>
                            <td>
                                {{  $voter->voted_at }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection