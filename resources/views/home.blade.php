@extends('layouts.app')



@section('content')

<style>
.twPc-div {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #e1e8ed;
    border-radius: 6px;
    height: 200px;
}
.twPc-bg {
    background-image: url("https://pbs.twimg.com/profile_banners/50988711/1384539792/600x200");
    background-position: 0 50%;
    background-size: 100% auto;
    border-bottom: 1px solid #e1e8ed;
    border-radius: 4px 4px 0 0;
    height: 95px;
    width: 100%;
}
.twPc-block {
    display: block !important;
}
.twPc-button {
    margin: -35px -10px 0;
    text-align: right;
    width: 100%;
}
.twPc-avatarLink {
    background-color: #fff;
    border-radius: 6px;
    display: inline-block !important;
    float: left;
    margin: -15px 5px 0 8px;
    max-width: 100%;
    padding: 1px;
    vertical-align: bottom;
}
.twPc-avatarImg {
    border: 2px solid #fff;
    border-radius: 7px;
    box-sizing: border-box;
    color: #fff;
    height: 72px;
    width: 72px;
}
.twPc-divUser {
    margin: 20px 0 0;
}
.twPc-divName {
    font-size: 18px;
    font-weight: 700;
    line-height: 21px;
}
.twPc-divName a {
    color: inherit !important;
}
.twPc-divStats {
    margin-left: 11px;
    padding: 10px 0;
}
.twPc-Arrange {
    box-sizing: border-box;
    display: table;
    margin: 0;
    min-width: 100%;
    padding: 0;
    table-layout: auto;
}
ul.twPc-Arrange {
    list-style: outside none none;
    margin: 0;
    padding: 0;
}
.twPc-ArrangeSizeFit {
    display: table-cell;
    padding: 0;
    vertical-align: top;
}
.twPc-ArrangeSizeFit a:hover {
    text-decoration: none;
}
.twPc-StatValue {
    display: block;
    font-size: 18px;
    font-weight: 500;
    transition: color 0.15s ease-in-out 0s;
}
.twPc-StatLabel {
    color: #8899a6;
    font-size: 10px;
    letter-spacing: 0.02em;
    overflow: hidden;
    text-transform: uppercase;
    transition: color 0.15s ease-in-out 0s;
}
</style>

<style>
.thumbnail { padding-bottom: 4px; border-radius: 3px; line-height: 13px; border: 1px solid #EEE; position: relative; box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.034); transition: all 0.25s ease; }
.thumbnail a:hover { text-decoration: none; }
.thumbnail:hover { box-shadow: 1px 2px 15px rgba(116, 189, 226, 0.25); transition: all 0.35s ease; }
.thumbnail h3 { font-size: 95%; margin: 0 0 0 3px; padding: 8px 10px 0 0; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; font-weight: 600; line-height: 18px; }
.thumbnail h3 a { color: #444; }
.thumbnail h3 a:hover { color: #EF6644; }
.thumbnail img.img-rounded { margin: 4px 4px 0 0; float: left; border-radius: 3px; }
.thumbnail small { font-size: 85%; color: #999; padding: 0 0 5px 0; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; }
.thumbnail small a { color: #999; text-decoration: none; }
.thumbnail small a:hover { color: #EF6644; }
.thumbnail .stats { line-height: 14px; bottom: 5px; right: 10px; position: absolute; background-color: #FFF; padding-left: 10px; }
.thumbnail .stats a { font-size: 95%; color: #BBB; text-decoration: none; }
.thumbnail .stats span { margin-left: 3px; }
</style>




<div class="container">

    <section class="content-header">
        <div class="pull-left" ><h1>{{ Auth::user()->name }}</h1>

        </div>
        <br/><br/><br/>
    </section>
    <br/><br/><br/>

    <!-- content -->
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">

                @foreach ($game_instances_user_list as $game_instance)

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="thumbnail">
                        <a href="#" title="Visit design">
                            <img alt="" class="img-responsive" src="https://compass-ssl.xbox.com/assets/dc/48/dc486960-701e-421b-b145-70d04f3b85be.jpg?n=Game-Hub_Content-Placement-0_New-Releases-No-Copy_740x417_02.jpg">
                        </a>
                        <h3>
                        <a href="#" title="Title goes here">{{ $game_instance->name}}</a><br>
                        <!--    <small>(6h ago) <a href="#" title="Visit UserName's profile">Tiempo 00:00</a></small>  -->
                        </h3>
                        <div class="stats">
                            
                        </div>

                    <a href="{{ route('game-instances.goto-game', [$game_instance->experiment_id, $game_instance->id]) }}" class="btn btn-primary btn-block btn-lg">Jugar ahora</a>

                        <!--
                        <a href="{{-- route('game-instances.play', [$game_instance->game->slug, $game_instance->slug, 't' => (new EncryptService())->encrypt_decrypt('encrypt', $game_instance->slug)]) --}}"
                            class="btn btn-primary btn-block btn-lg">Jugar</a>
                        -->

                    </div>
                </div>
        
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
