@include('layouts.header', [
    'services' => ($cat = App\Models\Services::select('id', 'name_' . app()->getLocale())->where('status', 1)->get()),
])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('menu.contact') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-empty section-item">
    <div class="container content">
        <div class="row">
            <div class="col-md-6">
                    
                    {!! google_map_iframe() !!}
            </div>
            <div class="col-md-6">
                <div class="row vertical-row">
                    <div class="col-md-12 boxed white">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="fa-ul text-light">
                                    <li><i class="fa-li fa fa-map-marker"></i> {{ __('other.contact_address') }}</li>
                                    <li><i class="fa-li fa fa-calendar "></i> {{ __('other.workdays') }} 10.00 - 18.00
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="fa-ul text-light">
                                    <li><i class="fa-li fa fa-envelope-o"></i> info@ef-s.ge</li>
                                    <li><i class="fa-li fa fa-phone "></i> +995 591 51 61 83 </li>
                                </ul>
                            </div>
                        </div>
                        <hr class="space m">
                        <form action="#" class="form-box form-ajax" method="post" data-email="federico@pixor.it">
                            <div class="row">
                                <div class="col-md-6">
                                    <input id="name" name="name"
                                        placeholder="{{ __('other.contact_form.name') }}" type="text"
                                        class="form-control form-value" required="">
                                </div>
                                <div class="col-md-6">
                                    <input id="email" name="email"
                                        placeholder="{{ __('other.contact_form.email') }}" type="email"
                                        class="form-control form-value" required="">
                                </div>
                            </div>
                            <hr class="space xs">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="messagge" name="messagge" placeholder="{{ __('other.contact_form.comment') }}"
                                        class="form-control form-value" required=""></textarea>
                                    <hr class="space s">
                                    <button class="btn-sm btn" type="submit"><i class="fa fa-envelope-o"></i>Send
                                        messagge</button>
                                </div>
                            </div>
                            <div class="success-box">
                                <div class="alert alert-success">Congratulations. Your message has been sent
                                    successfully</div>
                            </div>
                            <div class="error-box">
                                <div class="alert alert-warning">Error, please retry. Your message has not been sent
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
