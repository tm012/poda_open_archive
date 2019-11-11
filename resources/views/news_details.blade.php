@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br>		

							 			@php

							 				if($news[0]->news_image_path_storage !="")
							 				{
							 					$path = $news[0]->news_image_path_storage;
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
							 					
						 					
							 			@endphp


			<main class="main-content">
				<div class="fullwidth-block">
					<div class="container">
						
						<div class="row">
							<div class="col-md-6">
								<figure>
									<img src="{!! url($image_url ) !!}" alt="">
								</figure>
							</div>
							<div class="col-md-6">
								<h2 class="section-title">{{$news[0]->news_title}}</h2>
								<ul class="project-info">
									<li><strong>Date:</strong> {{$news[0]->created_at}}</li>
								
									<li><strong>Author(s):</strong>  {{$news[0]->news_author}}</li>
								
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<p>{{$news[0]->news_description}}</p>

								
							</div>
							
						</div>
					</div>
				</div>

				
			

			

			</main> <!-- .main-content -->

			
	
 @endsection