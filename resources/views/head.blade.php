@if ($enabled)
    <!-- Facebook Pixel Code -->
    <script @if($nonce)nonce="{{$nonce()}}"@endif>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        @foreach($pixel_ids AS $pixel_id)
            fbq('init', '{{ $pixel_id }}');
        @endforeach
        fbq('track', 'PageView');
    </script>

    @foreach ($pixel_ids as $pixel_id)
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $pixel_id }}&ev=PageView&noscript=1" /></noscript>
    @endforeach
    <!-- End Facebook Pixel Code -->
@endif
