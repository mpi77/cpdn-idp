  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{ get_title() }}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="dist/img/favicon.png" />
    {{ stylesheet_link('css/bootstrap.min.css') }}
    {{ stylesheet_link('css/font-awesome.min.css') }}
    {{ stylesheet_link('css/custom.css') }}
    {{ assets.outputCss() }}
    
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>