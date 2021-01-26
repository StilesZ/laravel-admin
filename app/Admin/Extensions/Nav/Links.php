<?php

namespace App\Admin\Extensions\Nav;
class Links
{
    public function __toString()
    {
        return <<<HTML
            <li class="dropdown bar-notification">
                <a href="#" class="dropdown-toggle text-success" data-toggle="dropdown" role="button"
                   aria-expanded="false">
                    <img src="<?php echo asset('img/country_flag/' . \App\Language::find(app_config('Language'))->icon); ?>" alt="Language">
                </a>
                <ul class="dropdown-menu lang-dropdown arrow right-arrow" role="menu">
                    @foreach(get_language() as $lan)
                        <li>
                            <a href="{{url('language/change/'.$lan->id)}}"
                               @if($lan->id==app_config('Language')) class="text-complete" @endif>
                                <img class="user-thumb"
                                     src="<?php echo asset('img/country_flag/' . $lan->icon); ?>"
                                     alt="user thumb">
                                <div class="user-name">{{$lan->language}}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

HTML;
    }
}
