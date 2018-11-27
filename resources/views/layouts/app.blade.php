<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  @yield('top_scripts')
  <script type="text/javascript">
    var Laravel = {csrfToken: "{{csrf_token()}}" };
  </script>
  <link rel="stylesheet" href="{{ customUrl(mix('css/app.css')) }}">
  @if(true)
    <style type="text/css">
      @font-face {
        font-family: 'Glyphicons Halflings';

        src: url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.eot");
        src: url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.eot?#iefix") format('embedded-opentype'), 
            url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.woff2") format('woff2'), 
            url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.woff") format('woff'), 
            url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.ttf") format('truetype'), 
            url("{{url('')}}/fonts/bootstrap/glyphicons-halflings-regular.svg#glyphicons_halflingsregular") format('svg');
      }
      @font-face {
        font-family: 'FontAwesome';
        src: url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.eot?v=4.7.0");
        src: url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.eot?#iefix&v=4.7.0") format('embedded-opentype'), 
            url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.woff2?v=4.7.0") format('woff2'), 
            url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.woff?v=4.7.0") format('woff'), 
            url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.ttf?v=4.7.0") format('truetype'), 
            url("{{url('')}}/fonts/font-awesome/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular") format('svg');
        font-weight: normal;
        font-style: normal;
      }

      .icheckbox_square-blue,
      .iradio_square-blue {
          background: url("{{url('')}}/images/vendor/icheck/skins/square/blue.png") no-repeat;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: italic;
        font-weight: 300;
        src: local('Source Sans Pro Light Italic'), local('SourceSansPro-LightItalic'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-LightItalic.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: italic;
        font-weight: 600;
        src: local('Source Sans Pro SemiBold Italic'), local('SourceSansPro-SemiBoldItalic'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-Italic.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 300;
        src: local('Source Sans Pro Light'), local('SourceSansPro-Light'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-Light.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 400;
        src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-Regular.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 600;
        src: local('Source Sans Pro SemiBold'), local('SourceSansPro-SemiBold'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-Semibold.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      /* latin */
      @font-face {
        font-family: 'Source Sans Pro';
        font-style: normal;
        font-weight: 700;
        src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url("{{url('')}}/fonts/source-sans-pro/SourceSansPro-Bold.ttf") format('truetype');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

    </style>
  @endif

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}

</head>
<body class="hold-transition @yield('body_class')">
<div id="app">  
@yield('content')
</div>
<script src="{{ customUrl(mix('/js/manifest.js')) }}"></script>
<script src="{{ customUrl(mix('/js/vendor.js')) }}"></script>
<script src="{{ customUrl(mix('/js/app.js')) }}"></script>
@yield('scripts')
</body>
</body>
</html>
