@extends('/default_contents')


@section('content')
		
		<div class="site-content">
			

			<div class="hero">
				<ul class="slides">
					<li data-bg-image="images/slider-1.jpg">
						<div class="container">
							<div class="slide-content">
								<h2 class="slide-title">LaboreLabore et dolore magna</h2>
								<p>Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit.</p>
								<a href="#" class="button">See details</a>
							</div>
						</div>
					</li>
					<li data-bg-image="images/slider-2.jpg">
						<div class="container">
							<div class="slide-content">
								<h2 class="slide-title">LaboreLabore et dolore magna</h2>
								<p>Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit.</p>
								<a href="#" class="button">See details</a>
							</div>
						</div>
					</li>
					<li data-bg-image="images/slider-3.jpg">
						<div class="container">
							<div class="slide-content">
								<h2 class="slide-title">LaboreLabore et dolore magna</h2>
								<p>Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit.</p>
								<a href="#" class="button">See details</a>
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
										<div class="col-sm-12" align="center">
											<div class="feature">
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
											<div class="feature">
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
											<div class="feature">
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
				<div class="fullwidth-block" data-bg-color="#edf2f4">
					<div class="container">
						<h2 class="section-title">Latest News</h2>
						<div class="row">
							<div class="col-md-4">
								<div class="post">
									<figure class="featured-image"><img src="images/news-1.jpg" alt=""></figure>
									<h2 class="entry-title"><a href="">Magni dolores rationale</a></h2>
									<small class="date">2 oct 2014</small>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="post">
									<figure class="featured-image"><img src="images/news-2.jpg" alt=""></figure>
									<h2 class="entry-title"><a href="">Perspiciatis unde omnus</a></h2>
									<small class="date">2 oct 2014</small>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
								</div>
							</div>
							<div class="col-md-4">
								<div class="post">
									<figure class="featured-image"><img src="images/news-3.jpg" alt=""></figure>
									<h2 class="entry-title"><a href="">Voluptatem laundantium  totam</a></h2>
									<small class="date">2 oct 2014</small>
									<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
								</div>
							</div>
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .fullwidth-block -->

				<div class="fullwidth-block">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<h2 class="section-title">Our mission and vision</h2>
								<p>Consequuntur minima, delectus quia labore sapiente maiores illo enim numquam sint? Molestias odio itaque, recusandae ut quae fuga ea tempore facere facilis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi cupiditate repellat velit quo, fugiat dolores eum corrupti commodi? Deserunt, adipisci sunt voluptas aliquid aliquam eos. Perspiciatis, similique atque deserunt nam.</p>
								<p>Distinctio delectus consequuntur sed quod ipsum a, odio obcaecati neque, aliquam nostrum aliquid reprehenderit ad quae qui autem voluptate omnis quas Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime magnam amet obcaecati dolore omnis consectetur dignissimos iste cupiditate excepturi quae porro fugiat, nemo iure, minima. Fuga hic voluptate ratione, at.ullam.</p>
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