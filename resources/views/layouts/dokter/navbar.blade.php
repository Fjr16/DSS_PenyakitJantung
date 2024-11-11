<nav class="navbar navbar-expand-xl navbar-dark bg-primary">
  <div class="container-fluid">

   <div class="collapse navbar-collapse" id="navbar-ex-7">
   <div class="navbar-nav me-auto">
      <a class="nav-item nav-link {{ $title == 'Home' ? 'active' : '' }}" href="/">Home</a>
      <a class="nav-item nav-link {{ $title == 'Diagnosa' ? 'active' : '' }}" href="{{ route('diagnosa.create') }}">Diagnosa</a>
   </div>
   <ul class="navbar-nav ms-lg-auto">
      @can('admin')
      <a class="nav-item nav-link {{ $title == 'Dashboard' ? 'active' : '' }}" href="/dashboard">Dashboard</a>
      @endcan
      <li class="nav-item">
         @auth
         <form action="{{ route('logout') }}" method="POST">
         @csrf
            <button class="btn nav-link"><i class="tf-icons navbar-icon bx bx-lock-open-alt"></i> Logout</button>
         </form>
         @else    
            <a class="nav-link" href="{{ route('login') }}"><i class="tf-icons navbar-icon bx bx-lock-open-alt"></i> Login</a>
         @endauth
      </li>
   </ul>
   </div>
  </div>
</nav>