@extends('default_contents')
@section('content')



<div class="container">

    <h3 style="text-align: center;" class="jumbotron">File(s) Upload to  <span class="oblique">{{Session::get("current_path")}}</span> </h3>

    <div>
	    <form method="post" action="{{url('file_upload/file/upload/store')}}" enctype="multipart/form-data"
	                  class="dropzone" id="dropzone">
	        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

	        <input name="data_id" type="hidden" value="0"/>
          <input name="path" type="hidden" value="{{Session::get("current_path")}}"/>

	        </form>
	</div>
	<br><br>


	<div class="container">
	  <div class="row">
	    <div class="col-md-4"></div>
	   <div align="center" class="col-md-4">

      <button type="button" class="btn btn-outline-success done_btn">DONE</button>
	   </div>
	   <div class="col-md-4"></div>
	  </div>

	</div>





</form>
</div>




@endsection



@section('page-script')


<script type="text/javascript">


        Dropzone.options.dropzone =
         {
            maxFilesize: 100000000,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                var new_file_name = "" ;


                var bodyContent = $.ajax({
                        url: "/check_for_filename",
                        global: false,
                        type: "GET",
                        data: {
                          file_name: file.name,

                          submit_check_1: "submit_check_1"


                        },

                        async:false,
                        success: function(msg){
                           //alert(msg);
                           new_file_name = msg;
                        }
                     }
                  ).responseText;
                  return new_file_name;
                //return time+file.name;
            },
            // acceptedFiles: ".jpeg,.jpg,.png,.gif,text/csv,.txt,.docx,.doc,image/*,application/pdf,.psd,application/vnd.ms-excel,.odt,.ppt,.pptx,.svg,.zip",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file)
            {
                var name = file.upload.filename;
                this.enable();
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("file_upload/file/delete") }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },

            success: function(file, response)
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
            ,
            init:function(){
                  var self = this;
                  // config
                  self.options.addRemoveLinks = true;
                  // self.options.dictRemoveFile = "Delete";
                  //New file added
                  self.on("addedfile", function (file) {
                    console.log('new file added ', file);
                  });
                  // Send file starts
                  self.on("sending", function (file) {
                    console.log('upload started', file);
                   // $('.meter').show();
                  });

                  // File upload Progress
                  self.on("totaluploadprogress", function (progress) {
                    console.log("progress ", progress);


                    //$('.roller').width(progress + '%');
                  });


                  self.on("uploadprogress", function (file, progress, bytesSent) {
                    console.log("uploadprogress ", progress);
                    var totalSizeLimit = 300*1024*1024; //300MB

                     var alreadyUploadedTotalSize = getTotalPreviousUploadedFilesSize();
                     console.log("total ", alreadyUploadedTotalSize);
                       // if((alreadyUploadedTotalSize + bytesSent) > totalSizeLimit){
                       //    this.disable();
                       //    console.log("disable");
                       //  }


                  });



                  self.on("queuecomplete", function (progress) {
                    //$('.meter').delay(999).slideUp(999);
                  });

                  // On removing file
                  // self.on("removedfile", function (file) {
                  //   console.log(file);
                  // });

                function getTotalPreviousUploadedFilesSize(){
                   var totalSize = 0;
                   self.getFilesWithStatus(Dropzone.SUCCESS).forEach(function(file){
                      totalSize = totalSize + file.size;
                   });
                   return totalSize;
                }

    }



};
</script>

<script type="text/javascript">

	$( ".done_btn" ).click(function() {
    window.location.href = "/contents";
});
</script>


<style>
.dropzone {
/*width: 100px;*/
height: 300px;
min-height: 0px !important;
}
</style>

@endsection
