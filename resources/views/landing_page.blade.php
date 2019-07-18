@extends('/default_contents')


@section('content')
		
		<div class="site-content">
			

			<div class="hero">
				<ul class="slides">
					<li data-bg-image="images/DSC_5517.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important; color:white;" class="slide-title">Keep Your PEBL Data Flowing</h2>
								<a style="text-decoration:none;" href="/welcome" class="button">Go With The Flow</a>
							</div>
						</div>
					</li>
					<li data-bg-image="images/DSC_7153.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important; color:white;" class="slide-title"> Your Donation Will Help Us Build</h2>
								
								<a style="text-decoration:none;" href="https://www.superiorideas.org/projects/open-source-psychology-software" class="button">Let's Take A Look</a>
							
								
							</div>
						</div>
					</li>
					<li data-bg-image="images/DSC_5547.JPG">
						<div class="container">
							<div class="slide-content">
								<h2 style="font-family: Cursive!important; color:white;" class="slide-title">Register Here For Accessing Large Array Of Data</h2>
								<a style="text-decoration:none;" href="/register" class="button">Let's Roll</a>
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
											<div  class="feature">
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
											<div  class="feature">
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
											<div  class="feature">
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
											<div class="feature">
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
							<div align="right"><a href="/news" style="text-decoration:none;" class="button">Show more</a></div>
						</div> <!-- .container -->
					</div> <!-- .fullwidth-block -->

					
				@endif

				<div class="fullwidth-block">
					<div align="center" class="container">
						<div class="row">
							<div class="col-md-12">
								<img src="/images/banner_poda_instructions_jpg.jpg" style="height:auto; max-width:100%;border:none;display:block;" alt="">
							</div>
				
						</div>
					</div>
				</div>

				<div class="fullwidth-block">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<h2 class="section-title">Our mission and vision</h2>
								<p>The exponential growth of data in many research fields means that revolutionary measures are needed for data management & accessibility. Government regulations and scientific standards both encourage open archival of research data, and the most popular avenue for sharing research data are online repositories. Most of the online data archives (e.g., Open Science Framework; Harvard dataverse; zenodo.org) are created for general purpose use rather than field-specific data hosting. Some domain-specific archives have been developed (e.g., animal tracking movebank.org; the COMSes.net agent-based modeling network) that take advantage of communities of practice and common data formats, and these can offer advantages over general-purpose archives. PEBL Online Data Archive (<a href="https://poda.cls.mtu.edu">PODA</a>) hosts behavioral test data collected using the Psychology Experiment Building Language (PEBL) Test Battery. PEBL is a free, open-source software system, which includes more than 100 psychological tasks used by a wide range of researchers and clinicians across many behavioral and medical science disciplines. PODA is an online data archive that allows researchers to share raw data from PEBL tasks. The initial goal of PODA is to provide researchers a common location for archiving data produced by PEBL, so that multiple researchers and laboratories can share data of common tasks in a common format.</p>
							</div>
							<div class="col-md-4">
								@if($latest_studies_count >0)
									<h2 class="section-title">Latest Studies</h2>
									<ul class="arrow-list has-border">
										@foreach($latest_studies as $latest_study=>$value)
											<li><a class ="bread_tags" data-value="{{$value->study_id}}"onclick='return check()' href="/datesets">{{$value->study_name}}</a></li>
										@endforeach
										
									</ul>
									<a href="/welcome" style="text-decoration:none;" class="button">Show more</a>
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