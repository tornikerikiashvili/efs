@include('layouts.header',['services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()])
<div class="section-empty">
    <div class="container content">
        <h3>{{ __('about.about.about_us') }}</h3>
        <div class="row">
            <div class="container">
                <div class="col-md-12">
                    <hr class="space s">
                    <h4 class="misia">{{ takeText($about,'mission') }}</h2>
                    <p>
                        {{ takeText($about,'mission_text') }}
                    </p>
                </div>
                <div class="col-md-12">
                    <hr class="space s">
                    <h4 class="mizani">{{ takeText($about,'goal') }}</h2>
                    <p>
                        {{ takeText($about,'goal_text') }}
                    </p>
                </div>
                <div class="col-md-12">
                    <hr class="space s">
                    <h4 class="girebulebebi">{{ takeText($about,'values') }}</h2>
                    <p>
                        {{ takeText($about,'values_text') }}
                    </p>
                </div>
            </div>
        </div>
        <hr class="space s">
    </div>
</div>
<style>
    h4 {
        font-weight: bold;
        color: #707070;
    }
</style>
<script>
    $(document).ready(function() {
        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            console.log(hash, 'hash');
            $('html, body').animate({
                scrollTop: $("." + hash).offset().top - 120
            }, 1000);
        }



        // $( ".customfade" ).fadeIn( "slow", function() {
        //     // Animation complete
        // });
    });
</script>
@include('layouts.footer')
