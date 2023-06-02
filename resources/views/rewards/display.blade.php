<div class="row">
    <div class="col-12 pt-1">
        <p>{{ $rewardObject->message }}</p>
    </div>
    @foreach($rewardObject->list as $key => $rewardItem)
    <div class="col-3 pr-1 pl-1 pb-1">
        <div class="card card-reward {{$rewardItem['class']}}">
            <div class="card-header">
            <p class="text-center pb-0 mb-0 font-weight-bold">DÍA {{$rewardItem['day']}}</p>
            </div>
            <div class="card-body p-2">
               <img src="\assets\gamification\gold-cofre.png" class="img-fluid mx-auto d-block"/>
            </div>
            <div class="card-footer">
                <small>{{$rewardItem['name']}} </small>
            </div>
        </div>
    </div>
    @endforeach    
</div>