import $ from 'jquery';
let typingTimer;
let doneTypingInterval = 2000; // 2 seconds

$(document).ready(function() {
    // Ensure this runs after the DOM is fully loaded

    $('#send-message-btn').on('click', function() {
        const message = $('#message-input').val();
        const receiverId = window.receiverId; 

        // Validate message input is not empty
        if (message.trim() === '') {
            alert('Message cannot be empty');
            return;
        }

        $.ajax({
            url: '/messages/send',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}", // Ensure CSRF token is properly passed
                receiver_id: receiverId,
                message: message
            },
            success: function(response) {
                // If the message is successfully sent, append it to the chat
                $('.chat-body').append(`
                    <div class="message sent">
                        <p>${message}</p>
                        <small>Just now</small>
                    </div>
                `);
                $('#message-input').val(''); // Clear the input field
            },
            error: function(xhr, status, error) {
                // If there's an error, handle it here
                console.error("Error sending message:", xhr.responseText);
                alert("An error occurred while sending the message. Please try again.");
            }
        });

        function scrollToBottom() {
            $('.chat-body').animate({
                scrollTop: $('.chat-body')[0].scrollHeight
            }, 500); // 500ms for smooth scrolling
        }
        
        $(document).ready(function() {
            $('#send-message-btn').on('click', function() {
                const message = $('#message-input').val();
                const receiverId = window.receiverId;
        
                if (message.trim() === '') {
                    alert('Message cannot be empty');
                    return;
                }
        
                $.ajax({
                    url: '/messages/send',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        receiver_id: receiverId,
                        message: message
                    },
                    success: function(response) {
                        $('.chat-body').append(`
                            <div class="message sent">
                                <p>${message}</p>
                                <small>Just now</small>
                            </div>
                        `);
                        $('#message-input').val('');
                        scrollToBottom(); // Scroll to the latest message
                    },
                    error: function(xhr) {
                        console.error("Error sending message:", xhr.responseText);
                        alert("An error occurred while sending the message.");
                    }
                });
            });
        
            // Optionally send on "Enter" key press
            $('#message-input').keypress(function(e) {
                if (e.which == 13 && !e.shiftKey) {
                    $('#send-message-btn').click();
                    return false; // Prevent newline
                }
            });
        
            // Auto-scroll on page load
            scrollToBottom();
        });
        

        

$('#message-input').on('input', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
    // Notify the server that you're typing...
});

function doneTyping() {
    // Notify the server that typing has stopped...
}

    });
});
