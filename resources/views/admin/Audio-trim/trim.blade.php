@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"></li>
                        <li class="breadcrumb-item active" aria-current="page">Audio List</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div id="main"></div>
                <script src="https://unpkg.com/react@15.3.1/dist/react.min.js"></script>
                <script src="https://unpkg.com/react-dom@15.3.1/dist/react-dom.min.js"></script>
                <script src="./dist/worker.js" type="text/js-worker" x-audio-encode></script>
                <script src="./dist/index.js"></script>
            </div>
        </div>
    </div>
@endsection
<script>
        //Merge two files
        $path = 'path.mp3';
        $path1 = 'path1.mp3';
        $mp3 = new PHPMP3($path);

        $newpath = 'path.mp3';
        $mp3->striptags();

        $mp3_1 = new PHPMP3($path1);
        $mp3->mergeBehind($mp3_1);
        $mp3->striptags();

        $mp3->setIdv3_2('url','encodedBy');

        $mp3->save($newpath);

        //Extract 30 seconds starting after 10 seconds.
        $path = 'path.mp3';
        $mp3 = new PHPMP3($path);
        $mp3_1 = $mp3->extract(10,30);
        $mp3_1->save('newpath.mp3');

        //Extract the exact length of time
        $path = 'path.mp3';
        $mp3 = new PHPMP3($path);
        $mp3->setFileInfoExact();
        echo $mp3->time;
        //note that this is the exact length!
</script>
