@extends('admin.main.app')
@section('content')
@include('alert.message')
<div class="container">
    <h3>ChatBot</h3>
    <div id="chat-box" style="height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
        @foreach ($chats as $chat)
            <div style="text-align: {{ $chat->sender == 'user' ? 'right' : 'left' }};">
                <strong>{{ ucfirst($chat->sender) }}:</strong> {{ $chat->message }}
            </div>
        @endforeach
    </div>

    <form id="chat-form" class="mt-3">
        <input type="text" name="message" id="message" class="form-control" placeholder="Type a message..." required>
        <button type="submit" class="btn btn-primary mt-2">Send</button>
    </form>
</div>

<script>
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        let message = document.getElementById('message').value;
        fetch("{{ route('chat.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message })
        }).then(res => res.json())
          .then(data => {
              if (data.success) {
                  location.reload(); // or use AJAX to append messages
              }
          });
    });
</script>
@endsection
