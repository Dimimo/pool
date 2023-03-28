<p><br></p>
<h3 class="align-center">Historical chart overview</h3>
<br/>
<div id="app">
    {!! $chart->container() !!}
</div>


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endpush