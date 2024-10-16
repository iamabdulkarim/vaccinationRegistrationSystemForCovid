@if (Session::has('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! implode('', $errors->all('<div>:message</div>')) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif


<script>
 document.addEventListener("DOMContentLoaded", function() {
    const ALERT_TIMEOUT = 3000; // 3 seconds for automatic dismiss

    // dismiss alerts after 3s
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        setTimeout(() => {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close(); 
            }
        }, ALERT_TIMEOUT);
    });
});

</script>
