<div class="grid-dropdown-actions dropdown">
{{--    <ul class="dropdown-menu" style="display: block; min-width: 70px !important;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);border-radius:0;left: -65px;top: 5px;">--}}

{{--        @foreach($default as $action)--}}
{{--            <li>{!! $action->render() !!}</li>--}}
{{--        @endforeach--}}

{{--        @if(!empty($custom))--}}

{{--            @if(!empty($default))--}}
{{--                <li class="divider"></li>--}}
{{--            @endif--}}

{{--            @foreach($custom as $action)--}}
{{--                <li>{!! $action->render() !!}</li>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </ul>--}}

    @foreach($default as $action)
        {!! $action->render() !!}
    @endforeach

    @if(!empty($custom))

        @if(!empty($default))
            <a class="divider"></a>
        @endif

        @foreach($custom as $action)
            {!! $action->render() !!}
        @endforeach
    @endif
</div>

<script>
    $('.table-responsive').on('shown.bs.dropdown', function(e) {
        var t = $(this),
            m = $(e.target).find('.dropdown-menu'),
            tb = t.offset().top + t.height(),
            mb = m.offset().top + m.outerHeight(true),
            d = 20;
        if (t[0].scrollWidth > t.innerWidth()) {
            if (mb + d > tb) {
                t.css('padding-bottom', ((mb + d) - tb));
            }
        } else {
            t.css('overflow', 'visible');
        }
    }).on('hidden.bs.dropdown', function() {
        $(this).css({
            'padding-bottom': '',
            'overflow': ''
        });
    });
</script>

@yield('child')
