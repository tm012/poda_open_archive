		 <br> <br>
			<footer class="site-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="widget">
								<h3 class="widget-title">Our address</h3>
								<!-- <strong>Meese Center 203</strong> -->
								<address>Cognitive and Learning Sciences, Michigan Technological University, Houghton. MI-49931</address>
								<!-- <a href="tel:+1 800 931 812">+1 906-487-1159</a> <br> -->
								<a href="mailto:poda.manager@gmail.com">Email: PODA Manager</a>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<h3 class="widget-title">Guidelines</h3>

								<ul class="arrow-list" >
									<!-- <li><a style="text-decoration:none; color:black;" href="">Help</a></li> 
									<li><a style="text-decoration:none;color:black;" href="">FAQ</a></li> -->
							<!-- 		<li><a style="text-decoration:none; color:black;" href="">Quick-Start Guide</a></li> 
									<li><a style="text-decoration:none; color:black;" href="">Licenses</a></li> -->
									<li><a style="text-decoration:none; color:black;"  data-toggle="modal" data-target="#myModalInstructions" href="">How to Upload?</a></li>
									<li><a style="text-decoration:none; color:black;"  data-toggle="modal" data-target="#myModalKeyFile" href="">What is a Key File?</a></li>
									<li> <a style="text-decoration:none; color:black;" href="https://www.superiorideas.org/" target="_blank">Where to Donate?</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-4">
							<div class="widget">
								<h3 class="widget-title">Partners</h3>
								<ul class="arrow-list">

									<li>
										<div class='container2-img-a-tag'>
												<div>
													<img style='margin-top:15px!important;'src='<?= secure_asset('images/mtu_logo.png') ?>' class='iconDetails-img-a-tag'>
												</div>	
											<div style='margin-left:60px;'>
											<a class="image-a-tag" style="text-decoration:none; color:black;" target="_blank" href="https://www.mtu.edu/cls/">Michigan Technological University's Department. of Cognitive and Learning Sciences</a>

											</div>
										</div>


									</li>
									<li>
										<div class='container2-img-a-tag'>
												<div>
													<img  src='<?= secure_asset('images/icc_logo.png') ?>' class='iconDetails-img-a-tag'>
												</div>	
											<div style='margin-left:60px;'>
											<a class="image-a-tag" style="text-decoration:none; color:black; margin-top:2px!important;" target="_blank" href="http://icc.mtu.edu/hcc/">Institute of Computing & Cybersystems</a>

											</div>
										</div>


									</li>

									<li>
										<div class='container2-img-a-tag'>
												<div>
													<img src='<?= secure_asset('images/superior_ideas.jpeg') ?>' class='iconDetails-img-a-tag'>
												</div>	
											<div style='margin-left:60px;'>
											<a class="image-a-tag" style="text-decoration:none; color:black; margin-top:10px!important;" target="_blank" href="https://www.superiorideas.org/projects/open-source-psychology-software">Superior Ideas</a>

											</div>
										</div>


									</li>

									<!-- <li><a style="text-decoration:none; color:black;" target="_blank" href="http://icc.mtu.edu/hcc/">Institute of Computing & Cybersystems</a></li>
									<li><a style="text-decoration:none; color:black;" target="_blank" href="https://www.superiorideas.org/projects/open-source-psychology-software">Superior Ideas </a></li> --> 
								
							
								</ul>
							</div>
						</div>						
						<div class="col-md-3">
							<div class="widget">
								<h3 class="widget-title">PEBL</h3>
								<ul class="arrow-list">
									<li><a style="text-decoration:none;color:black;" href="http://pebl.sourceforge.net/" target="_blank">PEBL Website</a></li> 
									<li> <a style="text-decoration:none;color:black;" href="https://en.wikipedia.org/wiki/PEBL_(software)" target="_blank">PEBL Wikipedia</a></li>

								</ul>
							</div>
						</div>
<!-- 						<div class="col-md-3">
							<div class="widget">
								<h3 class="widget-title">Social media</h3>
								<p>Deserunt mollitia animi id est laborum dolorum fuga harum quidem rerum facilis.</p>
								<div class="social-links">
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
									<a href="#"><i class="fa fa-google-plus"></i></a>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</div>
							</div>
						</div> -->
					</div> <!-- .row -->
@php
$year  = date("Y");
@endphp
					<p class="colophon">© {{$year}} Shane T. Mueller, Associate Professor of Psychology, Cognitive and Learning Sciences, Michigan Technological University. All rights reserved.</p>
				</div> <!-- .container -->
			</footer>
 <div class="modal fade" id="myModalInstructions">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Instructions</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          1. First create a study from <a href='http://poda.cls.mtu.edu/studies/create_study'>Create Study</a> page.
            <br><br>
          2. After that go to the study page and click on "Upload Dataset as Zip".
            <br><br>
          3. Zip your data set and then upload it. Please make sure the name of the zip file is the name of your data set. Don't forget to add the task name for the data set. <a href="https://drive.google.com/file/d/1NdD3oKg7kV0WW8d0ueYAzI-vru84KqAP/view?usp=sharing" target="_blank">Please See This Data Set For Example.</a>

          <br><br>
          3. Your upload files need to be approved by the admin.
          <br><br>
          4. While uploading key file, use the first column for indexing and second column for file names. Don't use this two columns for any other use. <a href="https://drive.google.com/file/d/1LtyXkbjWJsx1-SJTuUzAFaZ03q3mehYa/view?usp=sharing" target="_blank">Please See This Key File For Example.</a>
          <br><br>
          
          4. Please refrain yourself from uploading unnecessary data or you will be banned.    
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
         <!--  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>

   <div class="modal fade" id="myModalKeyFile">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Key File</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
          Key file is a spreadsheet which links each participant's code with demographic information, experimental condition etc. You can put any number of custom columns but use the first column for indexing and second column for file names. Don't use this two columns for any other use. <a href="https://drive.google.com/file/d/1LtyXkbjWJsx1-SJTuUzAFaZ03q3mehYa/view?usp=sharing" target="_blank">Please See This Key File For Example.</a>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
         <!--  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>
			<style type="text/css">
				
				
				.site-footer {
				  background-color:	#337ab7;
				  color: #000;
				}

				.site-footer a {
  color: #000;
}
			</style>