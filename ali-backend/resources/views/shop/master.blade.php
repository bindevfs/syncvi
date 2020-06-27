<!DOCTYPE html>
<html lang="en">

<head>
    @include('shop.layout.header')
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header">
    @include('shop.layout.navbar')
    <div class="app-main" >
        @include('shop.layout.sidebar')
        <div id="reload-pjax" style="width: 100%">
            @yield('content')
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            // does current browser support PJAX
            $(document).pjax('[data-pjax] a, a [data-pjax]', '#reload-pjax');
            if ($.support.pjax) {
                $.pjax.defaults.timeout = 3000; // time in milliseconds
                $(document).pjax('[data-pjax] a, a[data-pjax]', '#reload-pjax');
                $(document).on('submit', 'form[data-pjax]', function (event) {
                    $.pjax.submit(event, '#reload-pjax');
                });
            }
        });
    </script>
</div>
</body>
</html>
