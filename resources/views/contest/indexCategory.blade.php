@extends('app')
@section('content')
    <div id="contest-category-banner" class="{{ $contest_type }}">
        <div class="container">
            <div class="row">
                <div class="col-xs-12" id="contest-category-banner-container">
                    <div id="contest-category-banner-content">
                        <div>
                            <h1 class="text-white text-center">{{ $contest_type }}</h1>

                            <h3 class="text-white text-center">Showcase your Work and stay inspired. </h3>
                            <div class="text-center">
                                <a href="" class="btn btn-primary" role="button">Participate</a>
                                <a href="" class="btn btn-white" role="button">Create Contest</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

</div>



    <p class="text-center"><b><h2>Explore Contests</h2></b></p>

    <div class="container">
        <ul>
            @foreach ($contests as $contest)
                @if($contest->image)
                <li><img src="{{ $contest->image }} " class="thumbnail" alt="Contest Banner"></li>
                @endif
                   <li> {{ $contest->name }} <label> {{ $contest->entries->count() }} </label></li>
            @endforeach
        </ul>

    </div>

    <?php echo $contests->render(); ?>

@endsection