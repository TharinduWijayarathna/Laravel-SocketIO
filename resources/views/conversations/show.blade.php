@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Chat with {{ $otherUser->name }}
                </div>

                <div class="card-body" id="chat-messages" style="height: 400px; overflow-y: scroll;">
                    @foreach($messages as $message)
                        <div class="message {{ $message->sender_id == auth()->id() ? 'text-end' : 'text-start' }} mb-2">
                            <span class="{{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }} p-2 rounded">
                                {{ $message->message }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer">
                    <form id="message-form">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                        <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message...">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="module">
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            this.reset(); // Clear input
        });
    });

    window.Echo.channel('chat.{{ $conversation->id }}')
        .listen('.message.sent', (data) => {
            const chatMessages = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');

            messageDiv.className = 'message ' +
                (data.sender_id == {{ auth()->id() }} ? 'text-end' : 'text-start') +
                ' mb-2';

            messageDiv.innerHTML = `
                <span class="${data.sender_id == {{ auth()->id() }} ? 'bg-primary text-white' : 'bg-light'} p-2 rounded">
                    ${data.message}
                </span>
            `;

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
</script>
@endsection
