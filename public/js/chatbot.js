(function(){
  const root = document.getElementById('chatbot-root');
  if (!root) return;

  const panel = document.getElementById('chatbot-panel');
  const toggle = document.getElementById('chatbot-toggle');
  const closeBtn = root.querySelector('.ChatbotClose');
  const messagesEl = document.getElementById('chatbot-messages');
  const form = document.getElementById('chatbot-form');
  const input = document.getElementById('chatbot-input');

  const history = [];
  const suggestions = (window.SKYROSE_CHATBOT && window.SKYROSE_CHATBOT.suggestions) || [];

  function getCsrfToken(){
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  function appendMessage(role, text){
    const bubble = document.createElement('div');
    bubble.className = 'ChatbotBubble ' + (role === 'assistant' ? 'ChatbotBubble--bot' : 'ChatbotBubble--user');
    bubble.textContent = text;
    messagesEl.appendChild(bubble);
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function setLoading(isLoading){
    if (isLoading){
      let spinner = root.querySelector('.ChatbotTyping');
      if (!spinner){
        spinner = document.createElement('div');
        spinner.className = 'ChatbotTyping';
        spinner.innerHTML = '<span></span><span></span><span></span>';
        messagesEl.appendChild(spinner);
      }
    } else {
      const spinner = root.querySelector('.ChatbotTyping');
      if (spinner) spinner.remove();
    }
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  function togglePanel(force){
    const shouldOpen = force !== undefined ? force : panel.hasAttribute('hidden');
    if (shouldOpen){
      panel.removeAttribute('hidden');
      root.classList.add('is-open');
      toggle.setAttribute('aria-expanded', 'true');
      setTimeout(()=> input?.focus({preventScroll:true}), 10);
    } else {
      panel.setAttribute('hidden','hidden');
      root.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle?.focus({preventScroll:true});
    }
  }

  toggle?.addEventListener('click', ()=> togglePanel());
  closeBtn?.addEventListener('click', (e)=> { e.stopPropagation(); togglePanel(false); });
  document.addEventListener('keydown', (e)=> {
    if (e.key === 'Escape' && !panel.hasAttribute('hidden')) togglePanel(false);
  });

  // Suggestion: focus reveals a hint
  input?.addEventListener('focus', ()=>{
    if (suggestions.length){
      input.setAttribute('placeholder', 'Ask about ' + suggestions.slice(0,3).join(', ') + '…');
    }
  });

  form?.addEventListener('submit', function(e){
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;

    appendMessage('user', text);
    history.push({ role: 'user', content: text });
    input.value = '';
    setLoading(true);

    fetch('/chatbot/message', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({ message: text, history: history })
    })
    .then(async (res) => {
      setLoading(false);
      if (!res.ok) {
        const errText = await res.text();
        throw new Error(errText || 'Chatbot unavailable');
      }
      return res.json();
    })
    .then(data => {
      const reply = data.reply || 'Sorry, I could not find an answer right now.';
      appendMessage('assistant', reply);
      history.push({ role: 'assistant', content: reply });
    })
    .catch(err => {
      setLoading(false);
      appendMessage('assistant', 'Sorry, the assistant is unavailable. Please try again shortly.');
      console.error('Chatbot error', err);
    });
  });
})();
