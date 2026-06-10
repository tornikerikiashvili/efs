@include('layouts.header', [
    'services' => ($cat = App\Models\Services::select('id', 'name_' . app()->getLocale())->where('status', 1)->get()),
])
<div class="section-empty section-item">
    <div class="container content">
        <div class="row">
            <div class="col-md-6">
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.1265586288473!2d44.90464320000002!3d41.6820417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440e0c27993b55%3A0x185f017fb75863e!2s7%20Abel%20Enukidze%20St%2C%20T&#39;bilisi!5e0!3m2!1sen!2sge!4v1781078795622!5m2!1sen!2sge" width="100%" height="334" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
