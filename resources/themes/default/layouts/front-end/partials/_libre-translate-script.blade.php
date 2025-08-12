<!-- LibreTranslate JavaScript -->
<script>
    class LibreTranslateManager {
        constructor() {
            this.currentLanguage = 'en';
            this.originalContent = new Map();
            this.isTranslating = false;
            this.apiUrl = '{{ route("translate.text") }}'; // Laravel backend
            this.batchApiUrl = '{{ route("translate.batch") }}'; // Laravel batch endpoint
            this.init();
        }

        init() {
            this.bindEvents();
            this.storeOriginalContent();
        }

        bindEvents() {
            // Toggle dropdown
            document.getElementById('libreTranslateBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });

            // Language search
            document.getElementById('languageSearch').addEventListener('input', (e) => {
                this.filterLanguages(e.target.value);
            });

            // Language selection
            document.querySelectorAll('.language-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    const code = e.currentTarget.dataset.code;
                    const name = e.currentTarget.dataset.name;
                    this.selectLanguage(code, name);
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.group-4')) {
                    this.closeDropdown();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.shiftKey && e.key === 'T') {
                    e.preventDefault();
                    this.toggleDropdown();
                }
                if (e.key === 'Escape') {
                    this.closeDropdown();
                }
            });
        }

        toggleDropdown() {
            const dropdown = document.getElementById('libreTranslateDropdown');
            dropdown.classList.toggle('show');
            
            if (dropdown.classList.contains('show')) {
                document.getElementById('languageSearch').focus();
            }
        }

        closeDropdown() {
            document.getElementById('libreTranslateDropdown').classList.remove('show');
        }

        filterLanguages(searchTerm) {
            const items = document.querySelectorAll('.language-item');
            const term = searchTerm.toLowerCase();

            items.forEach(item => {
                const name = item.dataset.name.toLowerCase();
                const code = item.dataset.code.toLowerCase();
                
                if (name.includes(term) || code.includes(term)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        async selectLanguage(code, name) {
            if (this.isTranslating) return;

            this.closeDropdown();
            
            // Update UI
            document.getElementById('currentLangText').textContent = name;
            document.querySelectorAll('.language-item').forEach(item => {
                item.classList.remove('selected');
            });
            document.querySelector(`[data-code="${code}"]`).classList.add('selected');

            // If English is selected, restore original content
            if (code === 'en') {
                this.restoreOriginalContent();
                this.currentLanguage = 'en';
                return;
            }

            // Translate page content with fallback
            await this.translatePageWithFallback(code, name);
        }

        storeOriginalContent() {
            // Store original text content for restoration
            const elementsToTranslate = document.querySelectorAll(
                'h1, h2, h3, h4, h5, h6, p, span:not(.flag), a, button, label, .nav-label, .text-wrapper, .detail-title, .detail-description'
            );

            elementsToTranslate.forEach((element, index) => {
                if (element.textContent.trim() && !element.closest('.libre-translate-dropdown')) {
                    this.originalContent.set(`element_${index}`, {
                        element: element,
                        text: element.textContent.trim()
                    });
                }
            });
        }

        async translatePage(targetLang, langName) {
            this.isTranslating = true;
            this.showStatus('Translating page...', 'info');

            try {
                const textsToTranslate = Array.from(this.originalContent.values())
                    .map(item => item.text)
                    .filter(text => text.length > 0 && text.length < 1000); // Increased limit

                // Use batch translation endpoint
                const response = await fetch(this.batchApiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        texts: textsToTranslate,
                        source: 'en',
                        target: targetLang
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success && data.translations) {
                    // Apply translations
                    let textIndex = 0;
                    this.originalContent.forEach((item, key) => {
                        if (textIndex < data.translations.length && data.translations[textIndex]) {
                            item.element.textContent = data.translations[textIndex];
                            textIndex++;
                        }
                    });

                    this.currentLanguage = targetLang;
                    this.showStatus(`Page translated to ${langName}`, 'success');
                } else {
                    throw new Error('Translation response invalid');
                }

            } catch (error) {
                console.error('Translation error:', error);
                this.showStatus('Translation failed. Please try again.', 'error');
            } finally {
                this.isTranslating = false;
            }
        }

        async translateText(text, sourceLang, targetLang) {
            try {
                const response = await fetch(this.apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        text: text,
                        source: sourceLang,
                        target: targetLang
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                return data.success ? data.translatedText : text;
            } catch (error) {
                console.error('Translation API error:', error);
                return text; // Return original text on error
            }
        }

        restoreOriginalContent() {
            this.originalContent.forEach(item => {
                item.element.textContent = item.text;
            });
            this.showStatus('Page restored to English', 'success');
        }

        showStatus(message, type = 'info') {
            // Remove existing status
            const existingStatus = document.querySelector('.translation-status');
            if (existingStatus) {
                existingStatus.remove();
            }

            // Create new status
            const status = document.createElement('div');
            status.className = `translation-status ${type} show`;
            status.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'spinner fa-spin'}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(status);

            // Auto remove after 3 seconds
            setTimeout(() => {
                status.classList.remove('show');
                setTimeout(() => status.remove(), 300);
            }, 3000);
        }

        // Fallback: Client-side translation using Google Translate
        initGoogleTranslateFallback() {
            if (!window.google || !window.google.translate) {
                // Load Google Translate script
                const script = document.createElement('script');
                script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                document.head.appendChild(script);
                
                // Initialize Google Translate
                window.googleTranslateElementInit = () => {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,zh,co,hr,cs,da,nl,en,eo,et,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,he,hi,hmn,hu,is,ig,id,ga,it,ja,jv,kn,kk,km,rw,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ny,or,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,sw,sv,tl,tg,ta,tt,te,th,tr,tk,uk,ur,ug,uz,vi,cy,xh,yi,yo,zu',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false
                    }, 'google_translate_element');
                };
            }
        }

        // Enhanced translation with fallback
        async translatePageWithFallback(targetLang, langName) {
            try {
                // Try our Laravel backend first
                await this.translatePage(targetLang, langName);
            } catch (error) {
                console.warn('Backend translation failed, trying client-side fallback');
                this.showStatus('Trying alternative translation method...', 'info');
                
                // Fallback to Google Translate Widget
                this.initGoogleTranslateFallback();
                
                // Wait for Google Translate to load
                setTimeout(() => {
                    if (window.google && window.google.translate) {
                        // Trigger Google Translate
                        const selectElement = document.querySelector('.goog-te-combo');
                        if (selectElement) {
                            selectElement.value = targetLang;
                            selectElement.dispatchEvent(new Event('change'));
                            this.showStatus(`Page translated to ${langName} (via Google)`, 'success');
                        }
                    } else {
                        this.showStatus('Translation service unavailable', 'error');
                    }
                }, 2000);
            }
        }
    }

    // Initialize LibreTranslate when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        window.libreTranslate = new LibreTranslateManager();
    });
</script>