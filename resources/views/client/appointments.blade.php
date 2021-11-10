<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} - Client Appointments</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">

  @laravelPWA
</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('client.appointment') }}/#" class="nav-link">Appointments</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-chevron-down"></i>
            <span class="ml-2">My Profile</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ auth()->user()-> name }}</span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout',['token' => csrf_token()]) }}" class="dropdown-item">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('client.home') }}" class="brand-link">
        <span class="brand-text font-weight-light">PET LIFE CLINIC</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ auth()->user()->avatar }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{ route('client.home') }}" class="d-block">{{ auth()->user()->name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="{{ route('client.home') }}" class="nav-link">
                <i class="nav-icon fas fa-first-aid"></i>
                <p>
                  Medicines
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('client.appointment') }}" class="nav-link active">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Appointments
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Appointments</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Appointments</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif

        <!-- Default box -->
        <div class="card card-solid">
          <div class="card-body pb-0">
            <div class="row">

              @forelse($appointments as $appointment)
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-body pt-0 mt-3">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>{{ $appointment->medicine->name }}</b></h2>
                        <p class="text-muted text-sm"><b>Description: </b> {{ $appointment->medicine->description }} </p>
                        <p class="text-muted text-sm"><b>Availability: </b> {{ $appointment->medicine->is_available ? 'Available' : 'Out of stock'}} </p>
                        <p class="text-muted text-sm"><b>Status: </b> {{ $appointment->is_approved ? 'Approved' : 'Pending'}} </p>
                        <p class="text-muted text-sm"><b>Appointment Date: </b> {{ date('F j, Y',strtotime($appointment->appointment_date)) }} </p>
                      </div>
                      <div class="col-5 text-center">
                        <img src="{{ $appointment->medicine->thumbnail }}" alt="{{ Str::slug($appointment->medicine->name) }}" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="{{ route('client.appointment.cancel',['id' => $appointment->id]) }}" class="btn btn-sm btn-danger {{ $appointment->is_approved ? 'disabled' : '' }}">
                        <i class="fas fa-ban mr-1"></i> Cancel
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @empty
              <h2>No appointments found.</h2>
              @endforelse
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{ $appointments->links() }}
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer fixed">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; {{ date('Y') }} - {{ date('Y') + 1 }} <a href="/">Pet Life Clinic</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>

  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- AdminLTE App -->
  <script src="{{ url('dist/js/adminlte.min.js') }}"></script>

  @auth
  <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    if ('Notification' in window) {

      Notification.requestPermission().then((permission) => {
        if (permission !== 'granted') {
          Swal.fire({
            title: 'Notification needed',
            text: 'Please enable notification to make app work properly.',
            icon: 'error',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
          })

          throw new Error('Permission denied')
        }
      })
    }

    const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
      url: "{{ route('auth.token') }}",
    });

    const beamsClient = new PusherPushNotifications.Client({
      instanceId: '45ec9053-3bc7-4a9c-a63c-191a790fee08',
    });

    beamsClient.start()
      .then(() => beamsClient.clearAllState())
      .then(() => beamsClient.setUserId("user_id_{{ Auth::id() }}", beamsTokenProvider))
      .then(() => console.log('Successfully registered and subscribed!'))
      .catch(console.error);
  </script>
  @endauth
</body>

</html>