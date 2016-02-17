{{ partial('public/head') }}
<body class="">
	<div class="se-pre-con">
		<div class="showbox">
  			<div class="loader">
    			<svg class="circular" viewBox="25 25 50 50">
      				<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    			</svg>
  			</div>
		</div>
	</div>
  	{{ partial('public/navbar') }}
  	<div class="container">
  		{{ flashSession.output() }}
		{{ content() }}
	</div>
    
	{{ javascript_include("js/jquery.min.js") }}
	{{ javascript_include("js/bootstrap.min.js") }}
	{{ javascript_include("js/app.js") }}
	{{ assets.outputJs() }}
</body>