<footer class="footer">
    <div class="container">
        <div class="col-xs-12 col-md-3 text-center-xs">
            <ul class="list-inline center-block">
                <li><a target="_blank" class="breve" href="http://brevelabs.com/">
                        <img src="http://brevelabs.com/images/badge/breve-small.svg" alt="Breve Labs"
                             class="breve-small">
                        <img src="http://brevelabs.com/images/badge/breve-large.svg" alt="Breve Labs"
                             class="breve-large">
                    </a></li>
            </ul>
        </div>

        <div class="col-xs-12 col-md-9 text-right text-center-xs" style="line-height: 50px;">
            <ul class="list-inline center-block">
                <li><a href="{{ url('about') }}">About</a></li>
                <li><a href="{{ url('blog') }}">Blog</a></li>
{{--                <li><a href="{{ url('support') }}">Support</a></li>--}}
                <li><a href="{{ url('terms') }}">Terms of Service</a></li>
{{--                <li><a href="{{ url('privacy') }}">Privacy Policy</a></li>--}}
                <li><a href="{{ url('copyright') }}">&copy; Wizzspace</a></li>
            </ul>
            <ul class="list-inline center-block">
                <li><a href="https://twitter.com/#" title="Follow us on Twitter">
                        <img src="{{ asset('image/social/twitter.png') }}" alt="Twitter"
                             style="height: 1.8em; border-radius: 2px"/>
                    </a></li>
                <li><a href="https://facebook.com/#" title="Like us on Facebook">
                        <img src="{{ asset('image/social/facebook.png') }}" alt="Facebook"
                             style="height: 1.8em; border-radius: 2px"/>
                    </a></li>
                <li><a href="https://instagram.com/#" title="Follow us on Intstagram">
                        <img src="{{ asset('image/social/instagram.png') }}" alt="Instagram"
                             style="height: 1.8em; border-radius: 2px"/>
                    </a></li>
            </ul>
        </div>
    </div>
</footer>