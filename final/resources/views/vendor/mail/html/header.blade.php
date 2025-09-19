@props(['url'])
<tr>
    <td class="header" style="padding: 20px 0; text-align: center;">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://scontent.fmnl13-3.fna.fbcdn.net/v/t1.15752-9/494858026_4086746148238880_6689606138782300917_n.png?_nc_cat=106&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeE-gjs-0eHSVHDYRP0_cxFUngG91gmkCSqeAb3WCaQJKkv5HZedTLuqmWoUY2u8JnZlYG6L0Q9p06FEC7ha4XDE&_nc_ohc=77It1tuXuC8Q7kNvwHla4_h&_nc_oc=AdlFr3mnPRdnqEjP36bSxLad0L06B8_GafEXHAw75Ay6YJjYoi-DouF8PFlhfckZ4hZ9YAoNeDQOAp6E_Rf38_Rp&_nc_zt=23&_nc_ht=scontent.fmnl13-3.fna&oh=03_Q7cD2AF7HRBr8NmHIoeBlX0KXJax9C7mN_PfnIl_4l1gQaFu9g&oe=683D5451" 
                     style="width: 500px; height: auto; max-width: 100%; border: 0; line-height: 100%; outline: none; text-decoration: none;" 
                     alt="Company Logo"
                     width="180">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>