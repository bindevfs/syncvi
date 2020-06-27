<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.header')
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    @include('admin.layout.navbar')
    <div class="app-main">
        @include('admin.layout.sidebar')
        <div id="pagess" style="width: 100%">
            @yield('content')
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            // does current browser support PJAX
            $(document).pjax('[data-pjax] a, a[data-pjax]', '#pagess');
            if ($.support.pjax) {
                $.pjax.defaults.timeout = 3000; // time in milliseconds
                $(document).pjax('[data-pjax] a, a[data-pjax]', '#pagess');
                $(document).on('submit', 'form[data-pjax]', function (event) {
                    $.pjax.submit(event, '#pagess');
                });
            }
        })
    </script>
</div>
</body>
</html>
