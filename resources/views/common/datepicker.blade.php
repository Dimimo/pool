@push('css')

    <link rel="stylesheet" href="{{ Storage::disk('static')->url('css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('js')

    <script src="{{ Storage::disk('static')->url('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        //datepicker plugin
        $('.datepicker').datepicker();
    </script>

@endpush
