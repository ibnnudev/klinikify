@if (Session::has('success'))
    SnackBar({
    message: '{{ Session::get('success') }}',
    status: 'success',
    });
@elseif (Session::has('error'))
    SnackBar({
    message: '{{ Session::get('error') }}',
    status: 'error',
    });
@endif
