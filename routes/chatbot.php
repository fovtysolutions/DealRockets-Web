<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ChatbotController;

/*
|--------------------------------------------------------------------------
| Chatbot Routes
|--------------------------------------------------------------------------
|
| Here are all the routes for the comprehensive chatbot functionality
| including product discovery, lead management, jobs, deals, membership,
| support, and multi-language features.
|
*/

// ==========================================
// 🤖 CORE CHATBOT ROUTES
// ==========================================

Route::prefix('chatbot')->name('chatbot.')->group(function () {
    
    // Main chatbot interface
    Route::get('/', [ChatbotController::class, 'index'])->name('index');
    Route::post('/message', [ChatbotController::class, 'processMessage'])->name('message');
    Route::get('/history', [ChatbotController::class, 'getConversationHistory'])->name('history');
    Route::post('/external-api', [ChatbotController::class, 'callExternalApi'])->name('external-api');

    // ==========================================
    // 🔍 1. PRODUCT DISCOVERY & NAVIGATION
    // ==========================================
    
    Route::prefix('products')->name('products.')->group(function () {
        Route::post('/search', [ChatbotController::class, 'searchProductsByNameOrCategory'])->name('search');
        Route::post('/filter', [ChatbotController::class, 'filterProductsByLocationPrice'])->name('filter');
        Route::post('/details', [ChatbotController::class, 'viewProductDetails'])->name('details');
        Route::post('/contact-seller', [ChatbotController::class, 'contactSeller'])->name('contact-seller');
        Route::get('/latest-deals', [ChatbotController::class, 'showLatestDeals'])->name('latest-deals');
        Route::get('/featured', [ChatbotController::class, 'showFeaturedProducts'])->name('featured');
    });

    // ==========================================
    // 📩 2. LEAD MANAGEMENT (BUY/SELL)
    // ==========================================
    
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::post('/buy', [ChatbotController::class, 'postBuyLead'])->name('buy');
        Route::post('/sell', [ChatbotController::class, 'postSellOffer'])->name('sell');
        Route::post('/update', [ChatbotController::class, 'updateLead'])->name('update');
        Route::delete('/delete', [ChatbotController::class, 'deleteLead'])->name('delete');
        Route::post('/status', [ChatbotController::class, 'getLeadStatus'])->name('status');
    });

    // ==========================================
    // 🧑‍💼 3. JOBS & HIRING
    // ==========================================
    
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::post('/search', [ChatbotController::class, 'searchJobsByRoleOrLocation'])->name('search');
        Route::post('/post', [ChatbotController::class, 'postJobListing'])->name('post');
        Route::post('/applicants', [ChatbotController::class, 'viewApplicants'])->name('applicants');
        Route::post('/apply', [ChatbotController::class, 'applyToJob'])->name('apply');
        Route::post('/status', [ChatbotController::class, 'getJobStatus'])->name('status');
    });

    // ==========================================
    // ⚙️ 4. DEAL ASSIST & NEGOTIATION
    // ==========================================
    
    Route::prefix('deals')->name('deals.')->group(function () {
        Route::post('/negotiate', [ChatbotController::class, 'requestNegotiation'])->name('negotiate');
        Route::post('/track-negotiation', [ChatbotController::class, 'trackNegotiationStatus'])->name('track-negotiation');
        Route::post('/escalate', [ChatbotController::class, 'escalateToSupport'])->name('escalate');
        Route::post('/custom-offer', [ChatbotController::class, 'sendCustomOffer'])->name('custom-offer');
    });

    // ==========================================
    // 🧾 5. MEMBERSHIP & SUBSCRIPTIONS
    // ==========================================
    
    Route::prefix('membership')->name('membership.')->group(function () {
        Route::get('/plans', [ChatbotController::class, 'showMembershipPlans'])->name('plans');
        Route::get('/compare', [ChatbotController::class, 'compareMembershipFeatures'])->name('compare');
        Route::post('/upgrade', [ChatbotController::class, 'upgradeMembership'])->name('upgrade');
        Route::post('/cancel', [ChatbotController::class, 'cancelSubscription'])->name('cancel');
    });

    // ==========================================
    // 🧑‍💼 6. USER ACCOUNT & DASHBOARD
    // ==========================================
    
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/profile', [ChatbotController::class, 'viewProfileSummary'])->name('profile');
        Route::post('/business-details', [ChatbotController::class, 'updateBusinessDetails'])->name('business-details');
        Route::post('/reset-password', [ChatbotController::class, 'resetPassword'])->name('reset-password');
        Route::post('/link-contact', [ChatbotController::class, 'linkEmailOrPhone'])->name('link-contact');
        Route::post('/language-preference', [ChatbotController::class, 'setLanguagePreference'])->name('language-preference');
    });

    // ==========================================
    // 🆘 7. SUPPORT & HELP
    // ==========================================
    
    Route::prefix('support')->name('support.')->group(function () {
        Route::post('/faq', [ChatbotController::class, 'viewFaq'])->name('faq');
        Route::post('/ticket', [ChatbotController::class, 'raiseTicket'])->name('ticket');
        Route::post('/track-ticket', [ChatbotController::class, 'trackTicketStatus'])->name('track-ticket');
        Route::post('/human-agent', [ChatbotController::class, 'connectToHumanAgent'])->name('human-agent');
        Route::get('/contact-info', [ChatbotController::class, 'getContactInfo'])->name('contact-info');
    });

    // ==========================================
    // 🌐 8. MULTI-LANGUAGE SUPPORT
    // ==========================================
    
    Route::prefix('language')->name('language.')->group(function () {
        Route::post('/switch', [ChatbotController::class, 'switchLanguage'])->name('switch');
        Route::get('/supported', [ChatbotController::class, 'listSupportedLanguages'])->name('supported');
    });

    // ==========================================
    // 📝 FORM SUBMISSIONS
    // ==========================================
    
    Route::post('/submit-form', [ChatbotController::class, 'submitForm'])->name('submit-form');
});