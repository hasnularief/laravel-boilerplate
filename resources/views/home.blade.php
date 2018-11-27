@extends('layouts.app')

@section('top_scripts')
<script>
    var _HOST = "{{url('/')}}/";
    var _USER = {
        name : "{{ request()->user()->name  }}",
        email: "{{ request()->user()->email }}"
    };
</script>
@endsection

@section('body_class', 'skin-blue sidebar-mini') 

@section('content')
<div class="wrapper">

  @include('layouts.header')
 
  @include('layouts.sidebar')
    
    <div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->
    {!! isset($vue_component) ? $vue_component : null !!}
    <!-- /.content-wrapper -->
    </div>

  @include('layouts.footer')

  @include('layouts.asidebar')
</div>
@endsection
