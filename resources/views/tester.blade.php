@extends('layouts.admin_app')

@section('content')


<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary imgViewer" data-toggle="modal" data-target="#imgViewer">
    Open modal
  </button>
  
  <!-- The Modal -->
  <div class="modal" id="imgViewer">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body text-center">
          <img src="http://localhost/eform/public/storage/user_attachments/4/DIzH3s_1585718698.png" alt="DIzH3s_1585718698.png" class="img-responsive" id="imgViewerSrc">
          <p class="text-center" style="font-weight: 600; padding-top:30px;" id="imgViewerAlt">Lorem ipsum dolor sit amet co</p>
        </div>

  
      </div>
    </div>
  </div>
@endsection