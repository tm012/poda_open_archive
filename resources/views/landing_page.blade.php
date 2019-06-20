@extends('/default_contents')


@section('content')
		
		<div class="site-content">
			

			<div class="hero">
				<ul class="slides">
					<li data-bg-image="images/DSC_5517.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important;" class="slide-title">Keep your PEBL Data flowing</h2>
								<a href="/welcome" class="button">go with the flow</a>
							</div>
						</div>
					</li>
					<li data-bg-image="images/DSC_7153.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important;" class="slide-title"> Your donation help us build</h2>
								
								<a href="https://www.superiorideas.org/projects/open-source-psychology-software" class="button">let's take a look</a>
							
								
							</div>
						</div>
					</li>
					<li data-bg-image="images/DSC_5547.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important;" class="slide-title">Register here for accessing large array of data</h2>
								<a href="/register" class="button">let's roll</a>
							</div>
						</div>
					</li>
				</ul>
			</div>

			<main class="main-content">
				@if($featuredCount >0)
					<div class="fullwidth-block">
						<div class="container">
							<div class="row">

							 	@if($featuredCount == "1")
							 		@foreach($featured_studies as $featured_study=>$value)
							 			@php

							 			$abstract_reduced = substr($value->study_description, 0, 250);
							 			$abstract_reduced = $abstract_reduced.'....';

							 			@endphp
										<div  class="col-sm-12" align="center">
											<div style="height: 350px;" class="feature">
												<img src="images/icon-genetics-small.png" alt="" class="feature-image">
												<h2 class="feature-title">{{$value->study_name}}</h2>
												<p>{{$abstract_reduced}}</p>
												<button type="button" value="{{$value->study_id}}" class="btn btn-outline-info btn_featured_learn_more">LEARN MORE </button>
											</div>
										</div>						 				
							 		@endforeach
							 	@endif
							 	@if($featuredCount == "2")
							 		@foreach($featured_studies as $featured_study=>$value)
							 			@php

							 			$abstract_reduced = substr($value->study_description, 0, 200);
							 			$abstract_reduced = $abstract_reduced.'....';

							 			@endphp
										<div class="col-sm-6" align="center">
											<div style="height: 350px;" class="feature">
												<img src="images/icon-genetics-small.png" alt="" class="feature-image">
												<h2 class="feature-title">{{$value->study_name}}</h2>
												<p>{{$abstract_reduced}}</p>
												<button type="button" value="{{$value->study_id}}" class="btn btn-outline-info btn_featured_learn_more">LEARN MORE </button>
											</div>
										</div>						 				
							 		@endforeach
							 	@endif

							 	@if($featuredCount == "3")
							 		@foreach($featured_studies as $featured_study=>$value)
							 			@php

							 			$abstract_reduced = substr($value->study_description, 0, 150);
							 			$abstract_reduced = $abstract_reduced.'....';

							 			@endphp
										<div class="col-sm-4" align="center">
											<div style="height: 350px;" class="feature">
												<img src="images/icon-genetics-small.png" alt="" class="feature-image">
												<h3 class="feature-title">{{$value->study_name}}</h3>
												<p>{{$abstract_reduced}}</p>
												<button type="button" value="{{$value->study_id}}" class="btn btn-outline-info btn_featured_learn_more">LEARN MORE </button>
											</div>
										</div>						 				
							 		@endforeach
							 	@endif

							 	@if($featuredCount > 3)
							 		@foreach($featured_studies as $featured_study=>$value)
							 			@php

							 			$abstract_reduced = substr($value->study_description, 0, 100);
							 			$abstract_reduced = $abstract_reduced.'....';

							 			@endphp
										<div class="col-sm-3" align="center">
											<div style="height: 350px;" class="feature">
												<img src="images/icon-genetics-small.png" alt="" class="feature-image">
												<h3 >{{$value->study_name}}</h3>
												<p>{{$abstract_reduced}}</p>
												<button type="button" value="{{$value->study_id}}" class="btn btn-outline-info btn_featured_learn_more">LEARN MORE </button>
											</div>
										</div>						 				
							 		@endforeach
							 	@endif							 							 	

							</div> <!-- .row -->
						</div> <!-- .container -->
					</div> <!-- .fullwidth-block -->
				@endif	
				@if($latest_news_studies_count >0)
					<div class="fullwidth-block" data-bg-color="#edf2f4">
						<div class="container">
							<h2 class="section-title">Latest News</h2>
							<div class="row">
								@if($latest_news_studies_count == "1")
									<div class="col-md-4">
										
									</div>
									<div class="col-md-4">
										@foreach($latest_news as $latest_new=>$value)
										
								 			@php

								 				if($value->news_image_path_storage !="")
								 				{
								 					$path = $value->news_image_path_storage;
											        $s3 = \Storage::disk('s3');
											        $client = $s3->getDriver()->getAdapter()->getClient();
											        $expiry = "+10000 minutes";

											        $command = $client->getCommand('GetObject', [
											            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
											            'Key'    => $path
											        ]);
										            $request_tm = $client->createPresignedRequest($command, $expiry);
    												$image_url = (string) $request_tm->getUri();
								 				}
								 				else{
								 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
								 				}
								 				$abstract_reduced = substr($value->news_description, 0, 250);
							 					$abstract_reduced = $abstract_reduced.'....';				
								 			@endphp
											<div class="post">
												<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
												<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$value->id]) !!}">{{$value->news_title}}</a></h2>
												<small class="date">{{$value->created_at}}</small>
												<p>{{$abstract_reduced}}</p>
											</div>
										@endforeach
									</div>
									<div class="col-md-4">
										
									</div>
								@endif
								@if($latest_news_studies_count == "2")
									<div class="col-md-2">

									</div>
									<div class="col-md-4">
							 			@php

							 				if($latest_news[0]["news_image_path_storage"] !="")
							 				{
							 					$path = $latest_news[0]["news_image_path_storage"];
										        $s3 = \Storage::disk('s3');
										        $client = $s3->getDriver()->getAdapter()->getClient();
										        $expiry = "+10000 minutes";

										        $command = $client->getCommand('GetObject', [
										            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
										            'Key'    => $path
										        ]);
									            $request_tm = $client->createPresignedRequest($command, $expiry);
												$image_url = (string) $request_tm->getUri();
							 				}
							 				else{
							 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
							 				}
							 				$abstract_reduced = substr($latest_news[0]["news_description"], 0, 250);
						 					$abstract_reduced = $abstract_reduced.'....';
						 					$news_id = 	$latest_news[0]["id"];			
							 			@endphp
										<div class="post">
											<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
											<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$news_id ]) !!}">{{$latest_news[0]["news_title"]}}</a></h2>
											<small class="date">{{$latest_news[0]["created_at"]}}</small>
											<p>{{$abstract_reduced}}</p>
										</div>										
									</div>

									<div class="col-md-4">
							 			@php

							 				if($latest_news[1]["news_image_path_storage"] !="")
							 				{
							 					$path = $latest_news[1]["news_image_path_storage"];
										        $s3 = \Storage::disk('s3');
										        $client = $s3->getDriver()->getAdapter()->getClient();
										        $expiry = "+10000 minutes";

										        $command = $client->getCommand('GetObject', [
										            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
										            'Key'    => $path
										        ]);
									            $request_tm = $client->createPresignedRequest($command, $expiry);
												$image_url = (string) $request_tm->getUri();
							 				}
							 				else{
							 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
							 				}
							 				$abstract_reduced = substr($latest_news[1]["news_description"], 0, 250);
						 					$abstract_reduced = $abstract_reduced.'....';	
						 					$news_id = 	$latest_news[1]["id"];				
							 			@endphp
										<div class="post">
											<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
											<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$news_id]) !!}">{{$latest_news[1]["news_title"]}}</a></h2>
											<small class="date">{{$latest_news[1]["created_at"]}}</small>
											<p>{{$abstract_reduced}}</p>
										</div>										
									</div>
									<div class="col-md-2">

									</div>
								@endif
								@if($latest_news_studies_count == "3")
									
									<div class="col-md-4">
							 			@php

							 				if($latest_news[0]["news_image_path_storage"] !="")
							 				{
							 					$path = $latest_news[0]["news_image_path_storage"];
										        $s3 = \Storage::disk('s3');
										        $client = $s3->getDriver()->getAdapter()->getClient();
										        $expiry = "+10000 minutes";

										        $command = $client->getCommand('GetObject', [
										            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
										            'Key'    => $path
										        ]);
									            $request_tm = $client->createPresignedRequest($command, $expiry);
												$image_url = (string) $request_tm->getUri();
							 				}
							 				else{
							 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
							 				}
							 				$abstract_reduced = substr($latest_news[0]["news_description"], 0, 250);
						 					$abstract_reduced = $abstract_reduced.'....';	
						 					$news_id = 	$latest_news[0]["id"];			
							 			@endphp
										<div class="post">
											<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
											<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$news_id]) !!}">{{$latest_news[0]["news_title"]}}</a></h2>
											<small class="date">{{$latest_news[0]["created_at"]}}</small>
											<p>{{$abstract_reduced}}</p>
										</div>										
									</div>

									<div class="col-md-4">
							 			@php

							 				if($latest_news[1]["news_image_path_storage"] !="")
							 				{
							 					$path = $latest_news[1]["news_image_path_storage"];
										        $s3 = \Storage::disk('s3');
										        $client = $s3->getDriver()->getAdapter()->getClient();
										        $expiry = "+10000 minutes";

										        $command = $client->getCommand('GetObject', [
										            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
										            'Key'    => $path
										        ]);
									            $request_tm = $client->createPresignedRequest($command, $expiry);
												$image_url = (string) $request_tm->getUri();
							 				}
							 				else{
							 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
							 				}
							 				$abstract_reduced = substr($latest_news[1]["news_description"], 0, 250);
						 					$abstract_reduced = $abstract_reduced.'....';
						 					$news_id = 	$latest_news[1]["id"];				
							 			@endphp
										<div class="post">
											<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
											<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$news_id]) !!}">{{$latest_news[1]["news_title"]}}</a></h2>
											<small class="date">{{$latest_news[1]["created_at"]}}</small>
											<p>{{$abstract_reduced}}</p>
										</div>										
									</div>
									<div class="col-md-4">
							 			@php

							 				if($latest_news[2]["news_image_path_storage"] !="")
							 				{
							 					$path = $latest_news[2]["news_image_path_storage"];
										        $s3 = \Storage::disk('s3');
										        $client = $s3->getDriver()->getAdapter()->getClient();
										        $expiry = "+10000 minutes";

										        $command = $client->getCommand('GetObject', [
										            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
										            'Key'    => $path
										        ]);
									            $request_tm = $client->createPresignedRequest($command, $expiry);
												$image_url = (string) $request_tm->getUri();
							 				}
							 				else{
							 					$image_url= "http://icc.mtu.edu/wp-content/uploads/2016/01/ICC_CyberHuman_Dark-300x300.jpg";
							 				}
							 				$abstract_reduced = substr($latest_news[2]["news_description"], 0, 250);
						 					$abstract_reduced = $abstract_reduced.'....';	
						 					$news_id = 	$latest_news[2]["id"];			
							 			@endphp
										<div class="post">
											<figure class="featured-image"><img style="height: 230px!important;" src="{!! url($image_url ) !!}" alt=""></figure>
											<h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$news_id]) !!}">{{$latest_news[2]["news_title"]}}</a></h2>
											<small class="date">{{$latest_news[2]["created_at"]}}</small>
											<p>{{$abstract_reduced}}</p>
										</div>										
									</div>
								@endif
							</div> <!-- .row -->
							<div align="right"><a href="/news" class="button">Show more</a></div>
						</div> <!-- .container -->
					</div> <!-- .fullwidth-block -->

					
				@endif
				<div class="fullwidth-block">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<h2 class="section-title">Our mission and vision</h2>
								<p>PEBL Online Data Archive (PODA) is an online data archive that allows researchers to share
results of their behavioral tests with other researchers of the field. The data archive is built
mainly for data produced on PEBL (Psychology Experiment Building Language) which is a free,
open-source software system, used in running different types of behavioral experiments. This
search based online archive will help researchers to find appropriate data from the archive for
their research. The main goals for this online archive is to reduce the timing for data collection
in a research project and ultimately removing the need for running experiments for data
collection which may have already run by others. This will save both resource and time in a
research project. As the archive grows, researchers will be able to browse on a large array of
data and it will help us to preserve data which may get lost with time otherwise.</p>
							</div>
							<div class="col-md-4">
								@if($latest_studies_count >0)
									<h2 class="section-title">Latest Studies</h2>
									<ul class="arrow-list has-border">
										@foreach($latest_studies as $latest_study=>$value)
											<li><a class ="bread_tags" data-value="{{$value->study_id}}"onclick='return check()' href="/datesets">{{$value->study_name}}</a></li>
										@endforeach
										
									</ul>
									<a href="/welcome" class="button">Show more</a>
								@endif	
							</div>
						</div>
					</div>
				</div>

<!-- 				<div class="fullwidth-block cta" data-bg-image="images/cta-bg.jpg">
					<div class="container">
						<h2 class="cta-title">Neque porro quisquam</h2>
						<p>Modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem enim ad minima veniam quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil moles</p>
						<a href="#" class="button">See details</a>
					</div>
				</div> -->

<!-- 				<div class="fullwidth-block" data-bg-color="#edf2f4">
					<div class="container">
						<div class="subscribe-form">
							<h2>Join our newsletter</h2>
							<form action="#">
								<input type="text" placeholder="Enter your email">
								<input type="submit" value="Subscribe">
							</form>
						</div>
					</div>
				</div> -->

			</main> <!-- .main-content -->


		</div>

<!-- 		<script src="{{ asset('/js/theame_science_lab/jquery-1.11.1.min.js') }}"></script>

	 	<script src="{{ asset('/js/theame_science_lab/app.js') }}"></script>
	 	<script src="{{ asset('/js/theame_science_lab/plugins.js') }}"></script> -->
@endsection	 	
@section('page-script')	
<script type="text/javascript">
    //$(document).ready(function() {
        $('.btn_featured_learn_more').click(function() {
            //alert($(this).attr("value"));
            ajax_call_go_to_dataset($(this).attr("value"));
        });
    //});

    $(".bread_tags").click(function(){
    	i=$(this).data("value");
	    //alert(i);
	    ajax_call_go_to_dataset_from_a_tag(i);
	   // ajax_call_to_set_bread_crumb_path(i) ;
	   // ajax_call_go_to_files(i,'1');
	    
	});


	function ajax_call_go_to_dataset_from_a_tag(study_id) {
	  var study_id = study_id;
	  console.log(study_id);





	  $.ajax({
	    url: "/go_to_study_page",
	    data: {
	      study_id: study_id,
	      submit_check_1: "submit_check_1"


	    },
	    type: 'GET',
	    async: false,
	    success: function (data) {
	      console.log("Success");
	      console.log(data);
	      //window.location.href = "/datesets";


	    //
	    //  $("#sub_category_admin").html(html);


	    }
	  })




	}


	function ajax_call_go_to_dataset(study_id) {
	  var study_id = study_id;
	  console.log(study_id);





	  $.ajax({
	    url: "/go_to_study_page",
	    data: {
	      study_id: study_id,
	      submit_check_1: "submit_check_1"


	    },
	    type: 'GET',
	    async: false,
	    success: function (data) {
	      console.log("Success");
	      console.log(data);
	      window.location.href = "/datesets";


	    //
	    //  $("#sub_category_admin").html(html);


	    }
	  })




	}

</script>

@endsection