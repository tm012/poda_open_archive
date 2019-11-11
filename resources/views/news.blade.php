@extends('default_contents')
@section('content')



  <br> <br><br> <br>
      <br> <br><br> <br> 
 <div class="container">
	 <div class="row">

	  @foreach($news as $service=>$value)
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
	  <div class="col-md-6 col-lg-4">
	    <div class="product is-gray">
	      <div class="image d-flex align-items-center justify-content-center">
	        <div class=" text-uppercase"></div><img src="{!! url($image_url ) !!}" alt="product" class="img-fluid">
	      
	      </div>
	      <div align="left" ><h2 class="entry-title"><a href="{!! route('switch_news_details', ['news_id'=>$value->id]) !!}">{{$value->news_title}}</a></h2></div>
	      <p>{{$abstract_reduced}}</p>
	      <small class="date">{{$value->created_at}}</small>
												
	    </div>
	  </div>

	  @endforeach
	</div>
</div>

 @endsection



