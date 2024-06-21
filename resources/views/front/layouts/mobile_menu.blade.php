<div class="off-canvas-active">
    <a class="off-canvas-close"><i class=" ti-close "></i></a>
    <div class="off-canvas-wrap">
        <div class="welcome-text off-canvas-margin-padding pb-0 mb-2">
            <p>Brainlite</p>
        </div>
        <div class="mobile-menu-wrap off-canvas-margin-padding-2">
            <div id="mobile-menu" class="slinky-mobile-menu text-left">
                <ul>
                    <li>
                        <a href="#" onclick="return false;">Disease</a>
                        <ul class="sub-menu-style">
                            @forelse($headerCategories as $cat)
                            <li><a href="{{route('front.diseases', $cat->category_slug)}}">{{remove_icon_text($cat->category_name)}} </a></li>
                            @empty
                            @endforelse
                        </ul>
                    </li>
                    <li><a href="{{route('front.about_page')}}">About</a></li>
                    <li><a href="{{route('front.cms_page', 'contact-us')}}">Contact</a></li>
                    {{-- @if($detectDevice == 'iphone')
                    <li><a href="inapp://share">Share App</a></li>
                    @endif --}}
                </ul>
            </div>
        </div>

    </div>
</div>