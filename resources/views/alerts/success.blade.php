@if (flash()->message)
    <div class="alert alert-{{ flash()->class }} alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <p class="mb-0">
            {{ flash()->message  }}
        </p>
    </div>
@endif
