@auth()
    @include('argon.layouts.navbars.navs.auth')
@endauth
    
@guest()
    @include('argon.layouts.navbars.navs.guest')
@endguest