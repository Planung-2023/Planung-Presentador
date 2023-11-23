<style>
    .foto-perfil {
    border-radius: 20%;
    overflow: hidden;
    width: 50px;
    height: 50px;
    border: 2px solid black;
    padding: 0%;
    }

    .foto-perfil img{
        object-fit: cover;
    }

    .container-perfil{
        padding: 6px;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 10px;
        background: white;
        max-height: 60px;
    }
</style>

<nav class="topbar navbar mx-auto" style="background-color: rgba(0,0,0,.85); padding: 15px; position: relative;">
    <div class="container-fluid d-flex justify-content-between align-items-center text-center">
        <div class="navbar-brand">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='https://ahk.proj.disilab.cpci.org.ar/'">
                <i style="color: white; margin-right: 6px" class="bi bi-house-fill"></i>
                Volver a la App
            </button>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <img class="logo" style="width: 25%; height: 25%;" src="{{asset('favicon.ico')}}">
        </div>
        <div class="navbar-brand">
            <div class="container-perfil bg-secondary" style="color: #ffffff">
                <div class="d-flex align-items-center">
                    <div class="foto-perfil">
                        <img style="width:100%; height:100%;" src="{{ asset('images/' . $fotoPerfilUsuario) }}" alt="Foto de perfil">
                    </div>
                    <h5 class="ms-3 mb-0">{{ $nombreUsuario }}</h5>
                    <ul class="nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: #ffffff" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            </a>
                            <ul style="padding:10px; color:#ffffff" class="dropdown-menu dropdown-menu-end bg-secondary" aria-labelledby="navbarDropdown">
                                <li style="margin-bottom:15px">
                                    <h5 class="text-center">Datos del usuario</h5>
                                </li>
                                <li>
                                    <h6>Nombre</h6>
                                    <p>{{$usuario->nombre}} {{$usuario->apellido}}</p>
                                </li>
                                <li>
                                    <h6>Correo</h6>
                                    <p>{{$usuario->email}}</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li class="text-center">
                                    <button class="btn btn-dark mx-auto" onclick="window.location.href='{{ route('logout') }}'">
                                        <h5 style="color:#ffffff">Logout</h5>
                                    </button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>