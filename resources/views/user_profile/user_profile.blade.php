@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/user-profile.css') }}">
 
  <div class="main">
    <div class="search-bar">
      <input type="text" placeholder="Search" />
      
    </div>
    <div class="main-container">
      <div class="profile">
        <div class="profile-avatar"> 
          <img src="{{url('assets/img/users.png')}}" alt="" class="profile-img">
          <div class="profile-name">{{ $user->name }}</div>
        </div>
        <img src="https://images.unsplash.com/photo-1508247967583-7d982ea01526?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" alt="" class="profile-cover">
        <div class="profile-menu">
          <a class="profile-menu-link" href="{{ route('user_profile.about')    }}">About</a>
          <a class="profile-menu-link" href="{{ route('user_profile.timeline') }}">Timeline</a>
          <a class="profile-menu-link" href="{{ route('user_profile.medallas') }}">Medallas</a>
        </div>
      </div>
    </div>
    <div class="nav_sections">
        <!-- Aquí cambian las secciones -->
       @yield('specific_content')
    </div>
  </div>
    
    

@endsection