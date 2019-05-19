
@extends('default_contents')
@section('content')
<?php

?>


<div class="grid-container">
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item">

    <h2 style="font-style: italic;">Thank You</h2>



    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">

      </div>
      <div class="col-sm-4"></div>
    </div>


  </div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
</div>


@endsection

@section('page-script')




<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  background-color: #2196F3;
  padding: 10px;
}
.grid-item {

  padding: 20px;
  font-size: 30px;
  text-align: center;
}
</style>

@endsection
