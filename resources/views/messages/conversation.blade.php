@section('content')
@auth
<div class="messaging-app">

    <!-- Sidebar with Profile and Contacts -->
    <div class="content-sidebar">
        <div class="profile-section">
            <img src="{{ $user->profile_picture_url ?? asset('images/default.png') }}" alt="Profile Picture">
            <p>{{ auth()->user()->name }}</p>
        </div>
        
        <div class="contacts-section">
            <h4>Contacts</h4>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search contacts...">
                <button id="search-button">🔍</button>
            </div>
            <ul class="contacts-list">
                @foreach(App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                <li>
                    <button onclick="window.location.href='{{ route('messages.show', $user->id) }}'">
                        <div class="contact-item">
                            <div class="contact-profile-picture">
                                <img src="{{ $user->profile_picture_url ?? asset('images/default.png') }}" alt="Profile Picture">
                            </div>
                            <div class="contact-details">
                                <span class="contact-name">{{ $user->name }}</span>
                                <span class="status-dot {{ $user->is_online ? 'online' : 'offline' }}"></span>
                            </div>
                        </div>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Conversation Section -->
    <div class="conversation-section">
        @if(isset($contact))
            <div class="conversation-header">
                <div class="conversation-profile">
                    <img src="{{ $user->profile_picture_url ?? asset('images/default.png') }}" alt="Profile Picture">
                </div>
                <div class="contact-name">{{ $contact->name }}</div>
            </div>
            
            <div class="message-list">
                @if ($messages->isEmpty())
                    <p class="no-messages">No messages yet. Start the conversation!</p>
                @else
                    @foreach ($messages as $message)
                        <div class="message-item {{ $message->sender_id == auth()->id() ? 'outgoing' : 'incoming' }}">
                            <div class="message-bubble">
                                {{ $message->message }}
                                <div class="message-timestamp">{{ $message->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Message Input Section -->
            <div class="message-input-container">
                <form action="/messages/send" method="POST">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $contact->id }}">
                    <textarea name="message" placeholder="Type your message..." maxlength="300" required></textarea>
                    <button type="submit" class="send-button">➤</button>
                </form>
            </div>
        @else
            <p class="no-contact">Please select a contact to start a conversation.</p>
        @endif
    </div>
</div>

<script>
    document.getElementById('search-input').addEventListener('keyup', filterContacts);
    document.getElementById('search-button').addEventListener('click', filterContacts);

    function filterContacts() {
        const searchInput = document.getElementById('search-input').value.toLowerCase();
        const contacts = document.querySelectorAll('.contacts-list li');
        contacts.forEach(contact => {
            const contactName = contact.innerText.toLowerCase();
            contact.style.display = contactName.includes(searchInput) ? '' : 'none';
        });
    }
</script>
@endauth
@endsection
@include('layouts.app')
<style>
/* General Container */

.container {
        max-width: 1200px;
        margin: auto;
        padding:30px;
    
    }

.messaging-app {
    display: flex;
    max-width: 1000px;
    margin: auto;
    background-color: #f8f9fa;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 80px;
}

/* Sidebar */
.content-sidebar {
    width: 250px;
    background-color: #002554;
    color: #000; /* Black font for sidebar */
    display: flex;
    flex-direction: column;
    padding: 15px;
    overflow-y: auto;
    border-right: 2px solid #ccc;
    height: 100vh;
}

.sidebar-profile img {
    width: 50px; /* Set the size to fit your sidebar layout */
    height: 50px; /* Keep the aspect ratio */
    border-radius: 50%; /* Make it circular */
    object-fit: cover; /* Ensure the image is not distorted */
}

@media (max-width: 768px) {
    .sidebar-profile img, .conversation-profile img {
        width: 40px;
        height: 40px;
    }
}


.profile-section {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.profile-section img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 12px;
    object-fit: cover;
}

.contacts-section h4 {
    color: #e8a800;
    margin-bottom: 8px;
    font-size: 14px;
}

.contacts-list li {
    list-style: none;
    padding: 10px;
    margin-bottom: 5px;
    background: #003366;
    border-radius: 40px;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.contacts-list li:hover {
    background: #02497a;
}

.contact-item {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between; /* Space out items */
}

.contact-profile-picture {
    margin-right: 10px;
    flex-shrink: 0; /* Prevent resizing */
}

.contact-profile-picture img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.contact-details {
    display: flex;
    flex: 1; /* Take available space */
    justify-content: space-between; /* Name and dot on opposite sides */
    align-items: center;
}

.contact-name {
    font-size: 14px;
    color: #fff;
}

/* Separate hover effects */
.contact-profile-picture:hover img {
    transform: scale(1.1); /* Zoom effect on profile picture */
}

.contact-details.hover-name:hover .contact-name {
    color: #e8a800; /* Highlight the name on hover */
}

.contacts-list button {
    display: flex;
    align-items: center;
    background: none;
    border: none;
    color: black; /* Black font for contact names */
    width: 100%;
    padding: 0;
    text-align: left;
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: auto; /* Push to the far right */
}

.online { background-color: #76d7c4; }
.offline { background-color: #f39c12; }

/* Conversation Section */
.conversation-section {
    width: calc(100% - 250px);
    display: flex;
    flex-direction: column;
    background-color: #f5f5f5;
    padding: 15px;
    height: 100vh;
    overflow-y: hidden;
}

/* Conversation Header */
.conversation-header {
    display: flex;
    align-items: center; /* Align items vertically */
    padding: 15px;
    background-color: #1d2d50;
    color: #fff;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Profile Picture Styling */
.conversation-profile img {
    width: 50px;
    height: 50px;
    border-radius: 50%; /* Make it circular */
    object-fit: cover; /* Ensure image fits well */
    margin-right: 12px; /* Add spacing between picture and name */
}

/* Name Styling */
.conversation-name {
    font-size: 16px;
    font-weight: bold;
    color: #e8e8e8; /* Slightly lighter than white */
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .conversation-profile img {
        width: 40px;
        height: 40px;
        margin-right: 8px;
    }

    .conversation-name {
        font-size: 14px;
    }
}


.message-list {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
}

.message-item {
    display: flex;
    margin-bottom: 12px;
    padding: 8px;
}

.message-item.incoming {
    justify-content: flex-start;
}

.message-item.outgoing {
    justify-content: flex-end;
}

.message-bubble {
    max-width: 60%;
    padding: 10px 16px;
    border-radius: 20px;
    font-size: 13px;
    line-height: 1.4;
    word-wrap: break-word;
    position: relative;
}

.message-item .message-bubble {
    max-width: 50%;
    padding: 10px 16px;
    border-radius: 20px;
    font-size: 12px;
    line-height: 1.4;
    word-wrap: break-word;
    position: relative;
    transition: transform 0.3s ease-in-out;
    color: #000; /* Black font for message text */
}

.message-item.incoming .message-bubble {
    background-color: #d0312d;
    color: #fff;
    margin-right: 8px;
}

.message-item.outgoing .message-bubble {
    background-color: #e8a800;
    color: #fff;
    margin-left: 8px;
}

.message-item .message-bubble:hover {
    transform: translateX(5px);
}

.message-timestamp {
    position: absolute;
    bottom: -8px;
    right: 4px;
    font-size: 9px;
    color: #888;
}

/* Message Input Section */
.message-input-container {
    display: flex;
    align-items: center;
    background-color: #ececec;
    padding: 8px;
    border-radius: 6px;
}

.message-input-container textarea {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 8px;
    font-size: 13px;
    resize: none;
    height: 40px;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
    color: #000; /* Black font for input text */
}

.message-input-container textarea:focus {
    box-shadow: 0 0 6px rgba(46, 178, 249, 0.6);
}

.send-button {
    background-color: #e8a800;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 50%;
    margin-left: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.send-button:hover {
    transform: scale(1.1);
}

.search-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.search-bar input {
    width: 70%;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    color: #000; /* Black font for search input */
}

.search-bar button {
    padding: 8px;
    background-color: #0288d1;
    color: white;
    border: none;
    border-radius: 5px;
}
</style>
</style>