@extends('layouts.app')

@section('content')
<section>
  <div class="container py-5">

    <div class="row d-flex justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-4">

        <div class="card" id="chat1" style="border-radius: 15px;">
          <div
            class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <i class="fas fa-angle-left"></i>
            <p class="mb-0 fw-bold">Live chat</p>
            <i class="fas fa-times"></i>
          </div>
          <div class="card-body">

            <div id='chat-body'>


            </div>  

            <div data-mdb-input-init class="form-outline">
              <textarea class="form-control bg-body-tertiary" id="textAreaExample" rows="4" placeholder="Type your message"></textarea>
              <div class="text-end p-1">
                <button id='send-message' type="button" class="btn btn-info btn-sm text-white">Send</button>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</section>
@endsection
@section('scripts')
@vite('resources/js/app.js')
<script type="module">

    Echo.channel('chat-room-new')
        .listen('MessageSent', (e) => {
            let userId = "{{ auth()->user()->id }}";
            let image = e.sender == 1 ? 
                    'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp' 
                : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp';

            if(e.message!=null){
                if(e.sender!=userId){
                    document.getElementById('chat-body').innerHTML += 
                    `<div class="d-flex flex-row justify-content-start mb-4">
                        <img src="${image}"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                        <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                            <p class="small mb-0">${e.message}</p>
                        </div>
                    </div>
                    `;
                }else{
                    document.getElementById('chat-body').innerHTML += 
                    `<div class="d-flex flex-row justify-content-end mb-4">
                        <div class="p-3 me-3 border bg-body-tertiary" style="border-radius: 15px;">
                            <p class="small mb-0">${e.message}</p>
                        </div>
                        <img src="${image}"
                            alt="avatar 1" style="width: 45px; height: 100%;">
                    </div>
                    `;
                }
                
            }
        });

        document.getElementById('send-message').addEventListener('click', function(){
        let message = document.getElementById('textAreaExample').value;
        let userId = "{{ auth()->user()->id }}"; 
        fetch(`{{route('send-message')}}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({message, userId})
        });
        document.getElementById('textAreaExample').value = '';
    })
    

</script>
@endsection