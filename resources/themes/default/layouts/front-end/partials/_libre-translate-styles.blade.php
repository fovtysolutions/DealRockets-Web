<!-- LibreTranslate CSS Styles -->
<style>
    .libre-translate-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        width: 400px;
        max-height: 500px;
        overflow: hidden;
        z-index: 1000;
        display: none;
        border: 1px solid #e9ecef;
    }

    .libre-translate-dropdown.show {
        display: block;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 20px;
        border-radius: 15px 15px 0 0;
    }

    .search-container {
        position: relative;
        margin-bottom: 15px;
    }

    .search-container i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .search-container input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: none;
        border-radius: 25px;
        background: rgba(255,255,255,0.9);
        font-size: 14px;
        outline: none;
    }

    .search-container input::placeholder {
        color: #6c757d;
    }

    .translate-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        opacity: 0.9;
    }

    .language-sections {
        max-height: 350px;
        overflow-y: auto;
        padding: 0;
    }

    .language-sections::-webkit-scrollbar {
        width: 6px;
    }

    .language-sections::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .language-sections::-webkit-scrollbar-thumb {
        background: #007bff;
        border-radius: 3px;
    }

    .language-section {
        padding: 20px;
        border-bottom: 1px solid #f8f9fa;
    }

    .language-section:last-child {
        border-bottom: none;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 15px 0;
        font-size: 14px;
        font-weight: 600;
        color: #495057;
    }

    .section-title i {
        color: #007bff;
    }

    .language-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .language-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .language-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
    }

    .language-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }

    .language-item.selected {
        background: #e3f2fd;
        color: #007bff;
        font-weight: 500;
    }

    .language-item .flag {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .language-item .name {
        font-size: 14px;
        flex: 1;
    }

    .popular-languages .language-item {
        background: rgba(0,123,255,0.05);
        border: 1px solid rgba(0,123,255,0.1);
    }

    .popular-languages .language-item:hover {
        background: rgba(0,123,255,0.1);
        border-color: rgba(0,123,255,0.2);
    }

    /* Translation Status */
    .translation-status {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #007bff;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 10px;
    }

    .translation-status.show {
        display: flex;
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .translation-status.success {
        background: #28a745;
    }

    .translation-status.error {
        background: #dc3545;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .libre-translate-dropdown {
            width: 320px;
            right: -50px;
        }

        .language-grid {
            grid-template-columns: 1fr;
        }

        .dropdown-header {
            padding: 15px;
        }

        .language-section {
            padding: 15px;
        }
    }

    /* Hide original language dropdown when LibreTranslate is active */
    .group-4.libre-active #languageDropdown-class {
        display: none !important;
    }

    /* Hide Google Translate widget */
    #google_translate_element {
        display: none !important;
    }

    /* Hide Google Translate banner */
    .goog-te-banner-frame {
        display: none !important;
    }

    body {
        top: 0 !important;
    }

    /* Custom loading animation */
    .translation-loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>