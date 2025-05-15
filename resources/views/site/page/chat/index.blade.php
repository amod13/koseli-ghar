 {{-- <!-- Floating Chatbot Button and Box -->

 <!-- Floating Chatbot Button and Box -->
 <button class="chatbot__button">
     <span class="material-symbols-outlined">mode_comment</span>
     <span class="material-symbols-outlined">close</span>
 </button>

 <div class="chatbot">
     <div class="chatbot__header">
         <h3 class="chatbox__title">Chatbot</h3>
         <span class="material-symbols-outlined">close</span>
     </div>

     <ul class="chatbot__box">
         @foreach ($data['chats'] as $chat)
             <li class="chatbot__chat {{ $chat->sender === 'user' ? 'outgoing' : 'incoming' }}">
                 @if ($chat->sender !== 'user')
                     <span class="material-symbols-outlined">smart_toy</span>
                 @else
                     <span class="material-symbols-outlined">person</span>
                 @endif
                 <p>{{ $chat->message }}</p>
             </li>
         @endforeach
     </ul>

     <div class="chatbot__input-box">
         <form id="chat-form" class="mt-3">
             <textarea class="chatbot__textarea" name="message" id="message" placeholder="Type a message..." required></textarea>
             <button type="submit" class="material-symbols-outlined" id="send-btn">send</button>
         </form>
     </div>
 </div>


 <script>
     const chatbotToggle = document.querySelector('.chatbot__button');
     const sendChatBtn = document.querySelector('#send-btn');
     const chatInput = document.querySelector('.chatbot__textarea');
     const chatBox = document.querySelector('.chatbot__box');
     const chatbotCloseBtn = document.querySelector('.chatbot__header span');

     let userMessage;
     const inputInitHeight = chatInput.scrollHeight;
     chatInput.addEventListener('keydown', (e) => {
         if (e.key === 'Enter' && !e.shiftKey && window.innerWidth > 800) {
             e.preventDefault();
             handleChat();
         }
     });
     chatbotToggle.addEventListener('click', () =>
         document.body.classList.toggle('show-chatbot')
     );
     chatbotCloseBtn.addEventListener('click', () =>
         document.body.classList.remove('show-chatbot')
     );
     sendChatBtn.addEventListener('click', handleChat);
 </script>

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
                 body: JSON.stringify({
                     message
                 })
             }).then(res => res.json())
             .then(data => {
                 if (data.success) {
                     // Append user message to chat box
                     const chatBox = document.querySelector('.chatbot__box');
                     const newMessage = document.createElement('li');
                     newMessage.classList.add('chatbot__chat', 'outgoing');
                     newMessage.innerHTML = `
                <span class="material-symbols-outlined">person</span>
                <p>${message}</p>
              `;
                     chatBox.appendChild(newMessage);

                     // Clear input
                     document.getElementById('message').value = '';

                     // Scroll to bottom
                     chatBox.scrollTop = chatBox.scrollHeight;
                 }
             });
     });
 </script> --}}
