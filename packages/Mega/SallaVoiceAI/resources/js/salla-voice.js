(function () {
    // 1. Inject CSS if not already added
    if (!document.getElementById('salla-voice-style')) {
        const style = document.createElement('style');
        style.id = 'salla-voice-style';
        style.textContent = `
        .s-search-input-wrapper,
        .s-search-icon,
        salla-search {
            position: relative !important;
        }

        .voice-mic-trigger {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 99 !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            color: #64748b !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            border-radius: 50% !important;
            transition: color 0.2s ease, transform 0.2s ease !important;
        }

        .voice-mic-trigger:hover {
            color: var(--color-primary, #10b981) !important;
            transform: translateY(-50%) scale(1.1) !important;
        }

        .voice-in-input-bar {
            position: absolute !important;
            inset: 0 !important;
            z-index: 100 !important;
            background: #ffffff !important;
            border-radius: inherit !important;
            display: none;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 12px !important;
            border: 1px solid #EAECEF !important;
            box-sizing: border-box !important;
            direction: rtl !important;
            border-radius: 20px !important;
        }

        .voice-wa-listening-group {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            flex-grow: 1 !important;
        }

        .voice-mic-pill {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            border-radius: 50% !important;
            background: var(--color-primary, #10b981) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: var(--color-primary-reverse, #ffffff) !important;
            animation: waPulse 1.2s infinite ease-in-out !important;
        }

        @keyframes waPulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        .voice-status-text {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            font-family: inherit !important;
        }

        .voice-waves {
            display: flex !important;
            align-items: center !important;
            gap: 3px !important;
            height: 14px !important;
        }

        .voice-wave-bar {
            width: 3px !important;
            height: 100% !important;
            background: var(--color-primary, #10b981) !important;
            border-radius: 2px !important;
            animation: waveBounce 1s infinite ease-in-out alternate !important;
        }

        .voice-wave-bar:nth-child(2) { animation-delay: 0.2s !important; }
        .voice-wave-bar:nth-child(3) { animation-delay: 0.4s !important; }
        .voice-wave-bar:nth-child(4) { animation-delay: 0.1s !important; }

        @keyframes waveBounce {
            0% { height: 4px; }
            100% { height: 14px; }
        }

        #voiceCancelBtn {
            border: none !important;
            background: transparent !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
            padding: 6px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
        }

        #voiceCancelBtn:hover {
            color: #ef4444 !important;
        }
        `;
        document.head.appendChild(style);
    }

    // Initialize Voice Search
    function initVoiceSearch() {
        const sallaSearch = document.querySelector('salla-search');
        let input = document.querySelector('.s-search-input');

        if (!input && sallaSearch && sallaSearch.shadowRoot) {
            input = sallaSearch.shadowRoot.querySelector('input');
        }

        if (!input) {
            setTimeout(initVoiceSearch, 300);
            return;
        }

        if (document.getElementById('voiceMicBtn')) return;

        const parent = input.parentElement || input.closest('.s-search-input-wrapper') || input.closest('form') || sallaSearch;
        if (getComputedStyle(parent).position === 'static') {
            parent.style.position = 'relative';
        }

        const micBtn = document.createElement('button');
        micBtn.type = 'button';
        micBtn.id = 'voiceMicBtn';
        micBtn.className = 'voice-mic-trigger';

        const isRTL = document.dir === 'rtl' || document.documentElement.lang === 'ar';
        if (isRTL) {
            micBtn.style.left = '12px';
        } else {
            micBtn.style.right = '12px';
        }

        micBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"></path>
                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                <line x1="12" y1="19" x2="12" y2="22"></line>
            </svg>
        `;

        parent.appendChild(micBtn);

        let inInputBar = parent.querySelector('.voice-in-input-bar');
        if (!inInputBar) {
            inInputBar = document.createElement('div');
            inInputBar.className = 'voice-in-input-bar';
            inInputBar.innerHTML = `
                <div class="voice-wa-listening-group">
                    <div class="voice-mic-pill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"></path>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                            <line x1="12" y1="19" x2="12" y2="22"></line>
                        </svg>
                    </div>
                    <span id="voiceStatusText" class="voice-status-text">جاري الاستماع...</span>
                    <div class="voice-waves">
                        <div class="voice-wave-bar"></div>
                        <div class="voice-wave-bar"></div>
                        <div class="voice-wave-bar"></div>
                        <div class="voice-wave-bar"></div>
                    </div>
                </div>
                <button id="voiceCancelBtn" type="button" title="إلغاء">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            `;
            parent.appendChild(inInputBar);
        }

        const voiceStatusText = inInputBar.querySelector('#voiceStatusText');
        const voiceCancelBtn = inInputBar.querySelector('#voiceCancelBtn');

        let mediaRecorder = null;
        let audioChunks = [];
        let stream = null;
        let isRecording = false;
        let autoStopTimer = null;

        function closeListeningBar() {
            if (isRecording) cancelRecording();
            inInputBar.style.display = 'none';
        }

        voiceCancelBtn.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeListeningBar();
        };

        micBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            inInputBar.style.display = 'flex';
            startRecording();
        });

        async function startRecording() {
            try {
                audioChunks = [];
                voiceStatusText.innerText = 'جاري الاستماع...';
                isRecording = true;

                if (navigator.vibrate) navigator.vibrate(80);

                stream = await navigator.mediaDevices.getUserMedia({
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        autoGainControl: true
                    }
                });

                let mimeType = 'audio/webm';
                if (window.MediaRecorder) {
                    if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) {
                        mimeType = 'audio/webm;codecs=opus';
                    } else if (MediaRecorder.isTypeSupported('audio/mp4')) {
                        mimeType = 'audio/mp4';
                    }
                }

                mediaRecorder = new MediaRecorder(stream, { mimeType });

                mediaRecorder.ondataavailable = (event) => {
                    if (event.data && event.data.size > 0) {
                        audioChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = async () => {
                    const audioBlob = new Blob(audioChunks, { type: mimeType });
                    const fileExt = mimeType.includes('mp4') ? 'mp4' : 'webm';

                    if (stream) {
                        stream.getTracks().forEach(t => t.stop());
                    }

                    await sendAudio(audioBlob, `voice.${fileExt}`);
                };

                mediaRecorder.start(250);

                clearTimeout(autoStopTimer);
                autoStopTimer = setTimeout(() => {
                    if (isRecording) stopRecording();
                }, 4500);

            } catch (e) {
                voiceStatusText.innerText = 'تم رفض الوصول إلى الميكروفون';
                setTimeout(() => closeListeningBar(), 2000);
            }
        }

        function stopRecording() {
            if (!isRecording) return;
            isRecording = false;
            clearTimeout(autoStopTimer);

            voiceStatusText.innerText = 'جاري المعالجة...';
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
        }

        function cancelRecording() {
            isRecording = false;
            clearTimeout(autoStopTimer);
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
            }
        }

        function executeSallaSearch(spokenQuery) {
            input.value = spokenQuery;

            if (sallaSearch && typeof sallaSearch.search === 'function') {
                sallaSearch.search(spokenQuery);
            } else {
                const nativeSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value')?.set;
                if (nativeSetter) {
                    nativeSetter.call(input, spokenQuery);
                }

                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));

                input.focus();
                const enterEvent = new KeyboardEvent('keydown', {
                    bubbles: true,
                    cancelable: true,
                    key: 'Enter',
                    code: 'Enter',
                    keyCode: 13
                });
                input.dispatchEvent(enterEvent);
            }
        }

        async function sendAudio(blob, fileName) {
            try {
                const storeId = window.salla?.config?.get('store.id') || 1;
                const formData = new FormData();
                formData.append('audio', blob, fileName);
                formData.append('store_id', storeId);

                const res = await fetch('https://limra-softwares.com/api/voice-search', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();
                const productList = data.data || data.products || [];
                const spokenText = data.spoken_text || (productList.length > 0 ? productList[0].name : '');

                if (data.success || productList.length > 0 || spokenText) {
                    if (spokenText) {
                        executeSallaSearch(spokenText);
                    }
                    closeListeningBar();
                } else {
                    voiceStatusText.innerText = 'لم يتم التعرف على الصوت';
                    setTimeout(() => closeListeningBar(), 1500);
                }
            } catch (e) {
                voiceStatusText.innerText = 'حدث خطأ أثناء البحث';
                setTimeout(() => closeListeningBar(), 1500);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initVoiceSearch);
    } else {
        initVoiceSearch();
    }
})();
