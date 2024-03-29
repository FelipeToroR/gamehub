
@extends('user_profile.user_profile')


@section('specific_content')

<div class="timeline">
        <div class="timeline-left">
          <div class="intro box">
            <div class="intro-title">
              Introduction
              <button class="intro-menu"></button>
            </div>
            <div class="info">
              <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 503.889 503.889" fill="currentColor">
                  <path d="M453.727 114.266H345.151V70.515c0-20.832-16.948-37.779-37.78-37.779H196.517c-20.832 0-37.78 16.947-37.78 37.779v43.751H50.162C22.502 114.266 0 136.769 0 164.428v256.563c0 27.659 22.502 50.161 50.162 50.161h403.565c27.659 0 50.162-22.502 50.162-50.161V164.428c0-27.659-22.503-50.162-50.162-50.162zm-262.99-43.751a5.786 5.786 0 015.78-5.779h110.854a5.786 5.786 0 015.78 5.779v43.751H190.737zM32 164.428c0-10.015 8.147-18.162 18.162-18.162h403.565c10.014 0 18.162 8.147 18.162 18.162v23.681c0 22.212-14.894 42.061-36.22 48.27l-167.345 48.723a58.482 58.482 0 01-32.76 0L68.22 236.378C46.894 230.169 32 210.321 32 188.109zm421.727 274.725H50.162c-10.014 0-18.162-8.147-18.162-18.161V253.258c8.063 6.232 17.254 10.927 27.274 13.845 184.859 53.822 175.358 52.341 192.67 52.341 17.541 0 7.595 1.544 192.67-52.341 10.021-2.918 19.212-7.613 27.274-13.845v167.733c.001 10.014-8.147 18.162-18.161 18.162z" /></svg>
                Alumno de <a href="#">PUCV</a>
              </div>
              <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                  <path d="M9 22V12h6v10" />
                </svg>
                Live in <a href="#">_Chile</a>
              </div>
              <div class="info-item">
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                  <path d="M437 75C388.7 26.6 324.4 0 256 0S123.3 26.6 75 75C26.6 123.3 0 187.6 0 256s26.6 132.7 75 181c48.3 48.4 112.6 75 181 75s132.7-26.6 181-75c48.4-48.3 75-112.6 75-181s-26.6-132.7-75-181zM252.4 481.9c-52-.9-103.7-19.5-145.2-55.8L256 277.2l21.7 21.8a165.9 165.9 0 00-35.7 87c-3.5 30.5 0 63.3 10.4 95.9zM299 320.3l105.7 105.8a224.8 224.8 0 01-121.3 54.1C262 419.5 268 360.3 299 320.3zm21.2-21.2c40-31 99.2-37 160-15.6A224.8 224.8 0 01426 404.8zM482 252.4a231.7 231.7 0 00-96-10.4 165.9 165.9 0 00-87 35.7L277.3 256l148.9-148.8c36.3 41.5 55 93.2 55.8 145.2zm-290.2-39.5c-40 31-99.2 37-160 15.6A224.8 224.8 0 0186 107.2zm-84.5-127a224.8 224.8 0 01121.3-54.1C250 92.5 244 151.7 213 191.7zM270 126c3.5-30.5 0-63.3-10.4-95.9 52 .9 103.7 19.5 145.2 55.8L256 234.8 234.3 213a165.9 165.9 0 0035.7-87zM30 259.6a242 242 0 0072.7 11.7c7.8 0 15.6-.5 23.2-1.3a165.9 165.9 0 0087-35.7l21.8 21.7L85.9 404.8a225.3 225.3 0 01-55.8-145.2z" /></svg>
                Player name <a href="#">{{$user->name}}</a>
              </div>
            </div>
          </div>
          <div class="event box">
            <div class="event-wrapper">
              <img src="{{url('assets/img/docs/eventos.jpg')}}" class="event-img" />
              <div class="event-date">
                <div class="event-month">Jan</div>
                <div class="event-day">01</div>
              </div>
              <div class="event-title">Proximos Eventos</div>
              <div class="event-subtitle">01st Jan, 2024 07:00AM</div>
            </div>
          </div>
       
        </div>

        <div class="timeline-right" style="color:white; overflow-y: auto;"> <!-- Empieza Seccion Timeline -->
          <div class="row">
             <div class="card mb-3  d-flex"><div class="card-body p-2"> <b class="card-title p-0 m-0"></b></div> </div>
       
         <!-- SECCION diferent a timeline, hacerle cambios-->
         @foreach ($game_instances_user_list as $game_instance)
         <div class="album box">
            <div class="status-main">
              <img src="{{url('assets/img/users.png')}}" class="status-img" />
              <div class="album-detail">
                <div class="album-title"><strong>{{$user->name}}</strong> Participo en <span>{{ $game_instance->name}}</span></div>
                <div class="album-date">{{ $game_instance->updated_at->diffForHumans()}}</div>
              </div>
              <button class="intro-menu"></button>
            </div>
            <div class="album-content" style="color:white; ">{{ $game_instance->name}}
              <div class="album-photos">
              <img class="album-photo" data-src="holder.js/100px180/" alt="100%x150" src="\assets\gamification\bg-game-default.jpg" data-holder-rendered="true" >
                <div class="album-right"> 
                </div>
              </div>
            </div>
      </div>
      @endforeach

          </div>
        </div>
</div>
@endsection