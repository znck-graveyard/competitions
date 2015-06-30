@extends('app')
@section('content')
    <div class="jumbotron {{$type}}">
        <hgroup style="text-align: center">
            <h1>{{ $type }}</h1>

            <h3>Showcase your Work and stay inspired. </h3>
        </hgroup>

    </div>

    <p style="text-align: center;"><b>Explore Contests</b></p>

    <div class="container">
        <?php foreach ($contests as $contest): ?>
        <?php echo $contest->name; ?>
        <?php endforeach; ?>
    </div>

    <?php echo $contests->render(); ?>

@endsection