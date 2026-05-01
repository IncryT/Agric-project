<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Chatbot Advisor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold">Ask your AgriPrice Advisor</h3>
                        <p class="text-sm text-gray-600 mt-2">Chat about crop prices, market trends, and selling recommendations in one place.</p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 p-4 text-white flex items-center justify-between gap-4">
                            <div>
                                <h4 class="font-semibold">AgriPrice AI</h4>
                                <p class="text-xs text-emerald-100">Live market advice for farmers</p>
                            </div>
                            <div class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.3em] font-semibold text-white/80">
                                <span class="h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span> Online
                            </div>
                        </div>

                        <div class="p-4 space-y-4">
                            <div id="chat-messages" class="min-h-[320px] max-h-[32rem] overflow-y-auto rounded-3xl bg-white p-4 shadow-inner space-y-4">
                                @auth
                                    <div class="flex gap-3">
                                        <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-sm">
                                            Hello {{ auth()->user()->name }}! 🌾 I'm your market advisor. I can help you with current crop prices scraped daily from ZimPriceCheck.com (Mbare Market), market trends, and selling recommendations. What would you like to know?
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <div id="typing" class="hidden text-sm italic text-slate-500">Advisor is thinking...</div>

                            <form id="chat-form" class="flex gap-3">
                                <input id="user-input" type="text" placeholder="Ask about Wheat prices..." class="flex-1 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" />
                                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const chatForm = document.getElementById('chat-form');
            const userInput = document.getElementById('user-input');
            const chatMessages = document.getElementById('chat-messages');
            const typingIndicator = document.getElementById('typing');

            function escapeHtml(text) {
                return text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function renderMarkdown(text) {
                return text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            }

            function appendMessage(text, sender) {
                const wrapper = document.createElement('div');
                wrapper.className = sender === 'user' ? 'flex justify-end' : 'flex gap-3';

                const safeText = escapeHtml(text);
                const content = sender === 'user'
                    ? `<div class="rounded-2xl bg-emerald-600 px-4 py-3 text-sm text-white shadow-sm max-w-[80%]">${safeText}</div>`
                    : `<div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-sm max-w-[80%]">${renderMarkdown(safeText)}</div>`;

                wrapper.innerHTML = content;
                chatMessages.appendChild(wrapper);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            chatForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                const message = userInput.value.trim();
                if (!message) {
                    return;
                }

                appendMessage(message, 'user');
                userInput.value = '';
                typingIndicator.classList.remove('hidden');
                chatMessages.scrollTop = chatMessages.scrollHeight;

                try {
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: `message=${encodeURIComponent(message)}`
                    });

                    const data = await response.json();
                    typingIndicator.classList.add('hidden');
                    appendMessage(data.reply || 'Sorry, I could not get a reply from the advisor.', 'bot');
                } catch (error) {
                    typingIndicator.classList.add('hidden');
                    appendMessage('Sorry, I am having trouble connecting to the market advisor.', 'bot');
                }
            });
        });
    </script>
</x-app-layout>
