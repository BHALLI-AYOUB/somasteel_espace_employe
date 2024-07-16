<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <title><?php echo e(config('app.name', 'Espace Employé')); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js', ]); ?>
    <?php echo $__env->yieldPushContent('vite'); ?>
</head>
<?php
    $route = Route::current();
    $routeName = $route->getName(); // Get the name of the current route
?>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-warning p-0 container-fluid">
            <div class="container-fluid d-flex justify-content-between p-0">
                <a class="p-0 m-0" data-bs-toggle="offcanvas" <?php if(auth()->guard()->check()): ?> href=" #offcanvasNavbar" <?php endif; ?> role="button"
                    aria-controls="offcanvasNavbar">
                    <img src="<?php echo e(asset("images/solasteellogowhite.png")); ?>" class="logoicon p-0 m-0" />
                </a>
                <a class="navbar-brand me-0 px-0" href="<?php echo e(url('/home')); ?>">
                    <?php echo e(config('app.name', 'Espace Employé')); ?>

                </a>
                <div class="d-flex align-items-center d-inline">
                    <?php if(auth()->guard()->guest()): ?>
                    <?php if(Route::has('login')): ?>
                            <a class="nav-link fw-bolder border-3 border-bottom border-dark me-3" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        
                    <?php endif; ?>
                    <?php else: ?>
                    <a id="" class="nav-link  d-flex align-items-center badge rounded-pill text-bg-light d-inline ps-1 pe-1 fs-6"
                        href="<?php echo e(route('home')); ?>" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php if(Auth::user()->profile_picture): ?>
                        <img class="user-avatar rounded-pill me-1" src="<?php echo e(route('profile.image', basename(auth()->user()->profile_picture))); ?>"
                            alt="user" />
                        <?php else: ?>
                        <span class="user-avatar rounded-pill d-flex align-items-center justify-content-center">
                            <i class="fa fa-user"></i>
                        </span>
                        <?php endif; ?>

                        <?php echo e(Auth::user()->nom); ?>

                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(auth()->guard()->check()): ?>
            <a class="menu-button" data-bs-toggle="offcanvas" href="#offcanvasNavbar" role="button" aria-controls="offcanvasNavbar">
                <label class="menu-label bg-warning">
                    <input type="checkbox">
                    <svg viewBox="0 0 32 32">
                        <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
                        <path class="line" d="M7 16 27 16"></path>
                    </svg>
                </label>
            </a>
            <?php endif; ?>
        </nav>

        <!-- Offcanvas menu -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header border-2 border-warning border-bottom">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php echo e(config('app.name', 'Soma Employé')); ?></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    <?php if(auth()->guard()->guest()): ?>
                    <?php if(Route::has('login')): ?>
                    <li class="nav-item text-center">
                        <a class="nav-link active" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                    </li>
                    
                    <?php endif; ?>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-center"  href="<?php echo e(route('home')); ?>" role="button">
                            <?php echo e(__('Profile')); ?>

                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center"  href="<?php echo e(route('demandes.index')); ?>" role="button">
                            <?php echo e(__('Demandes Congé')); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center"  href="<?php echo e(route('absence.index')); ?>" role="button">
                            <?php echo e(__('Permission d\'absence')); ?>

                        </a>
                    </li>
                    
                
                <li class="nav-item">
                    <a class="nav-link text-center"  href="<?php echo e(route('notedefrais.index')); ?>" role="button">
                        <?php echo e(__('NoteDeFrais')); ?>

                    </a>
                </li>
            

                    <?php if(Auth::user()->isRH()): ?>
                        <li class="nav-item">
                            <a class="nav-link text-center"  href="<?php echo e(route('annuaire.index')); ?>" role="button">
                                <?php echo e(__('Annuaire des Employés')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a id="logout-link" class="nav-link text-center text-danger" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <?php echo e(__('Logout')); ?>

                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                    <?php endif; ?>
                    <!-- Other navigation links go here -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li> -->
                </ul>
            </div>
        </div>

        
        <div id="dynamicErrorAlert" class="alert alert-SE alert-danger p-2" role="alert" style="display: none;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span id="errorMessage">
                <?php if($errors->has('date_fin') || $errors->has('matricule')
                || $errors->has('error') || session('error')): ?>
                    <?php echo e(implode('<br>', $errors->get('date_fin'))); ?>

                    <?php echo e(implode('<br>', $errors->get('matricule'))); ?>

                    <?php echo e(implode('<br>', $errors->get('error'))); ?>

                    <?php echo e(__(session('error'))); ?>

                <?php endif; ?>
            </span>
        </div>
        
        <div id="dynamicSuccessAlert" class="alert alert-SE alert-success" role="alert" style="display: none;">
            <i class="fas fa-check-to-slot me-2"></i>
            <span id="successMessage">
                <?php if(session('succes')): ?>
                <?php echo e(__(session('succes'))); ?>

                <?php endif; ?>
            </span>
        </div>
        <main class="py-2">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>

</html>
<?php /**PATH C:\Users\pc\Desktop\somasteel_espace_employeV0.1\resources\views/layouts/app.blade.php ENDPATH**/ ?>