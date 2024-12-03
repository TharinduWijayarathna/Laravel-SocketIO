@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Start a Conversation') }}</div>
                <div class="card-body">
                    <h5>Select a User to Chat</h5>
                    <ul class="list-group">
                        @foreach($users as $user)
                            <li class="list-group-item">
                                <a href="{{ route('conversations.show', $user->id) }}">
                                    {{ $user->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Conversations') }}</div>
                <div class="card-body">
                    @forelse($conversations as $conversation)
                        @php
                            $otherUser = $conversation->user_one_id == auth()->id()
                                ? $conversation->userTwo
                                : $conversation->userOne;
                        @endphp
                        <div class="mb-2 card">
                            <div class="card-body">
                                <a href="{{ route('conversations.show', $conversation->id) }}">
                                    Chat with {{ $otherUser->name }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>No conversations yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
